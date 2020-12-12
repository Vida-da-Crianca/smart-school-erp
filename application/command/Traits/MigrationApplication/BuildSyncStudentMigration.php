<?php

namespace Application\Command\Traits\MigrationApplication;


trait BuildSyncStudentMigration
{



    public function buildStudent($data)
    {
        $guardianType = isset($data->aluno->mother->id) && $data->aluno->mother->id == $data->aluno->codresp_financeiro ?  "mother" : "father";
        $student = isset($data->aluno->nome) ?  preg_split('#\s#', $data->aluno->nome) :  [];
        $firstName =  current($student);
        unset($student[0]);
        $lastName = implode(' ', $student);



        $build = [

            "admission_no" => $data->aluno->rm, //RM
            "roll_no" => $data->aluno->ra,
            "class_id" => $data->options->classe_id,
            "section_id" => $data->options->section_id,
            "firstname" => $firstName,
            "lastname" => $lastName,
            "gender" => $data->aluno->sexo == 1 ? "Male" : ($data->aluno->sexo == 2 ?  "Female" : "No"),
            "dob" => $data->aluno->nasc_data,
            "mobileno" => $data->aluno->telefone,
            "email" => $data->aluno->email,
            "admission_date" => explode(' ', $data->aluno->data_cadastro)[0],
            "blood_group" => "",
            "height" => "12",
            "weight" => "",
            "measure_date" => explode(' ', $data->aluno->data_cadastro)[0],
            "father_name" => $data->aluno->father->nome ?? $data->aluno->father->nome,
            "father_phone" => $data->aluno->father->telefone ?? $data->aluno->father->telefone,
            "father_occupation" => null,
            "mother_name" => $data->aluno->mother->nome ?? $data->aluno->mother->nome,
            "mother_phone" => $data->aluno->mother->telefone ?? $data->aluno->mother->telefone,
            "mother_occupation" => null,
            "guardian_is" => $guardianType,
            "guardian_name" => $data->aluno->mother->nome ?? $data->aluno->mother->nome,
            "guardian_relation" => $guardianType,
            "guardian_phone" => $data->aluno->guardian->telefone ?? $data->aluno->guardian->telefone,
            "guardian_occupation" => $data->aluno->guardian->profissao ?? $data->aluno->guardian->profissao,
            "guardian_email" => $data->aluno->guardian->email ?? $data->aluno->guardian->email,
            "guardian_document" => only_numeric($data->aluno->guardian->cpf) ?? only_numeric($data->aluno->guardian->cpf),
            "guardian_postal_code" => only_numeric($data->aluno->guardian->cep) ?? only_numeric($data->aluno->guardian->cep),
            "guardian_address" => $data->aluno->guardian->endereco ?? $data->aluno->guardian->endereco,
            "guardian_address_number" => $data->aluno->guardian->numero ?? $data->aluno->guardian->numero,
            "guardian_district" => $data->aluno->guardian->bairro ?? $data->aluno->guardian->bairro,
            "guardian_city" => 'Barretos',
            "guardian_state" => 'SP',
            "current_address" => $data->aluno->email ?? $data->aluno->email,
            "permanent_address" => $data->aluno->email ?? $data->aluno->email,
            "vehroute_id" => "",
            "adhar_no" => "",
            "previous_school" => "",
            "note" => "",
            'is_active'           => 'yes',

        ];


        $user = \Student_eloquent::where('admission_no', $data->aluno->rm)->first();
        if ($user)
            $build['id'] = $user->id;
        return $build;
    }

    function syncStudent($data)
    {
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];

        // $exceptions = ['class_id', 'section_id'];
        unset($data['class_id']);
        unset($data['section_id']);
        unset($data['measure_date']);
        $insert_id = $this->CI->student_model->add(
            $data,
            [
                'adm_auto_insert' =>  false,
                // 'adm_update_status' => 0
            ]
        );

        if ($insert_id == null)
            $insert_id =  $data['id'];

        $data_new = array(
            'student_id'    => $insert_id,
            'class_id'      => $class_id,
            'section_id'    => $section_id,
            'session_id'    => $this->current_session,
            'fees_discount' => 0,
        );
        // $this->CI->student_model->add_student_session($data_new);
        $sessionStudent = new \Student_session_eloquent;
        $sessionStudent->forceFill($data_new);

        $sessionStudent->save();

        $sessionMaster = [
            'student_session_id' => $sessionStudent->id,
            'fee_session_group_id' => 2,
        ];
        \Student_fee_master_eloquent::updateOrCreate(
            $sessionMaster,
            $sessionMaster
        );

        $user_password = $this->CI->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);


        $data_student_login = array(
            'username' => $this->student_login_prefix . $insert_id,
            'password' => $user_password,
            'user_id'  => $insert_id,
            'role'     => 'student',
            'childs' => 0
        );

        $this->CI->user_model->add($data_student_login);

        // if ($sibling_id > 0) {
        //     $student_sibling = $this->student_model->get($sibling_id);
        //     $update_student  = array(
        //         'id'        => $insert_id,
        //         'parent_id' => $student_sibling['parent_id'],
        //     );
        //     $student_sibling = $this->student_model->add($update_student);
        // } else {
        $parent_password   = $this->CI->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
        $temp              = $insert_id;
        $data_parent_login = array(
            'username' => $this->CI->parent_login_prefix . $insert_id,
            'password' => $parent_password,
            'user_id'  => 0,
            'role'     => 'parent',
            'childs'   => $temp,
        );
        $ins_parent_id  = $this->CI->user_model->add($data_parent_login);
        $update_student = array(
            'id'        => $insert_id,
            'parent_id' => $ins_parent_id,
        );
        $this->CI->student_model->add($update_student);
        // }

        // \Student_fee_master_eloquent::updateOrCreate([
        //     'student_session_id' => $insert_id,
        //     'fee_session_group_id' => $deposite->id,
        // ], [
        //      'is_active' => 'yes',
        //      'student_session_id' => $insert_id,

        // ]);


        return  ['id' => $insert_id, 'session_id' => $sessionStudent->id,] ;
    }
}