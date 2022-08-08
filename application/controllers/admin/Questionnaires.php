<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Questionnaires extends Admin_Controller {

    public $exam_type = array();
    private $sch_current_session = "";

    public function __construct() {
        parent::__construct();
        $this->load->library('customlib');
        $this->load->library('encoding_lib');
        $this->load->library('mailsmsconf');
        $this->load->model("classteacher_model");
        $this->load->model("section_model");
        $this->load->model("question_model");

        $this->exam_type = $this->config->item('exam_type');
        $this->sch_current_session = $this->setting_model->getCurrentSession();
        $this->attendence_exam = $this->config->item('attendence_exam');
        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    
    public function add() {
        // if (!$this->rbac->hasPrivilege('question_bank', 'can_view')) {
        //     access_denied();
        // }

        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'Examinations/questionnaires_add');

        $role = $this->customlib->getUserData();

    

        if ($role['role_id'] == "2") {

            $data = array(
                'questionnaires' => $this->question_model->getQuestionnaires($role['id']),
            );

        } else {
            $data  = array(
                'questionnaires' => $this->question_model->getQuestionnaires(),
            );

        }

        

        $this->load->view('layout/header', $data);
        $this->load->view('admin/examgroup/questionnaires_add', $data);
        $this->load->view('layout/footer', $data);
    }

    
    public function index() {
        // if (!$this->rbac->hasPrivilege('exam_group', 'can_view')) {
        //     access_denied();
        // }
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'Examinations/questionnaires');

        $role = $this->customlib->getUserData();


        if ($role['role_id'] == "2") {

            $data = array(
                'questionnaires' =>  $this->question_model->searchQuestionnairesForTeachers($role['id']) ,
            );

        } else {
            $data  = array(
                'questionnaires' => $this->question_model->getQuestionnaires(),
            );

        }

        $this->load->view('layout/header', $data);
        $this->load->view('admin/examgroup/questionnaires', $data);
        $this->load->view('layout/footer', $data);
    }




    public function updateQuestionary() {
        $quest_title = htmlspecialchars($this->input->post('quest_title'));
        $quest_description = htmlspecialchars($this->input->post('quest_description'));
        $quest_observation = htmlspecialchars($this->input->post('quest_observation'));
        $quest_status = htmlspecialchars($this->input->post('quest_status'));
        $quest_id = htmlspecialchars($this->input->post('quest_id'));

        $this->question_model->updateQuestionary($quest_title, $quest_description, $quest_observation, $quest_status,  $quest_id);


    }

    public function add_questionnaries() {
        
        $role = $this->customlib->getUserData();


        $quest_title = htmlspecialchars($this->input->post('quest_title'));
        $quest_description = htmlspecialchars($this->input->post('quest_description'));
        $quest_observation = htmlspecialchars($this->input->post('quest_observation'));
        $quest_criteria = htmlspecialchars($this->input->post('quest_criteria'));
        $quest_user =  $this->customlib->getUserData()['id'];


        if ($quest_criteria == "classes") {
            
            if ($role['role_id'] == "2"){
                $r = explode("-", $this->input->post('quest_section'));
            
                $quest_section = $r[1];
                $quest_segment = $r[0];
                $quest_teacher = null;


            } else {

               

                $quest_section = htmlspecialchars($this->input->post('quest_section'));
                $quest_segment = htmlspecialchars($this->input->post('quest_segment'));
                $quest_teacher = null;
            }



        } else if ($quest_criteria == "teachers") {

            $r = explode("-", $this->input->post('quest_section'));
            
            $quest_section = $r[0];
            $quest_segment = $r[1];
            $quest_teacher = htmlspecialchars($this->input->post('quest_segment'));

        }

        $quest_data = date('d-m-Y');
        $quest_time = date('H:i:s');
        $quest_status = htmlspecialchars($this->input->post('quest_status'));

        $this->question_model->addQuestionary($quest_title, $quest_description, $quest_observation, $quest_criteria, $quest_segment, $quest_section, $quest_data, $quest_time, $quest_status, $quest_teacher, $quest_user);

    }

    public function deleteQuestionary() {
        $quest_id = htmlspecialchars($this->input->post('quest_id'));

        $this->question_model->deleteQuestionary($quest_id);

    }

    public function deleteQuestionaryCheck() {
        $quest_id = htmlspecialchars($this->input->post('quest_id'));

        $this->question_model->deleteQuestionaryCheck($quest_id);

    }



// Inicio Respostas
    public function addAnswers()  {

        $quest_id= htmlspecialchars($this->input->post('quest_id'));
        $quest_ask_title = htmlspecialchars($this->input->post('quest_answer_title'));

        $this->question_model->addAnswers($quest_id, $quest_ask_title);
    }

    public function deleteAnswers() {

        $answer_id = htmlspecialchars($this->input->post('answer_id'));

        $this->question_model->deleteAnswers($answer_id);
    }

    public function getAnswers() {
        $quest_id = htmlspecialchars($this->input->post('quest_id'));
        $data =  $this->question_model->getAnswers($quest_id);

        if (count($data) == 0) {
            echo ' <center><div> <p> Nenhuma Resposta Cadastrada.</p> </div></center> ';
        } else {
            foreach($data as $d) {
                echo '
                    <div class="row" style="margin-top:5px;" >
                        <div class="col-md-11" style="background-color:#222533;color:#FFF;border:1px solid #555;padding-top:4px ">
                            <p class="align-middle line-clamp-1 " >'.$d->quest_answer_title.'</p>
                        </div>
                        <div class="col-md-1" onclick="deleteAnswers('.$d->id.')" style="color:red;font-weight:bolder;text-align:center;cursor:pointer">
                            <p  style="padding:2px;font-size:20px;cursor:pointer">X</p>
                        </div>
                    </div>
                ';
            }

        }
       
    }

// Fim Respostas





// Inicio Perguntas
public function addAsks()  {

    $quest_id= htmlspecialchars($this->input->post('quest_id'));
    $quest_ask_title = htmlspecialchars($this->input->post('quest_ask_title'));

    $this->question_model->addAsks($quest_id, $quest_ask_title);
}

public function deleteAsks() {

    $ask_id = htmlspecialchars($this->input->post('ask_id'));

    $this->question_model->deleteAsks($ask_id);
}

public function getAsks() {
    $quest_id = htmlspecialchars($this->input->post('quest_id'));
    $data =  $this->question_model->getAsks($quest_id);

    if (count($data) == 0) {
        echo ' <center><div> <p> Nenhuma Pergunta Cadastrada.</p> </div></center> ';
    } else {
        foreach($data as $d) {
            echo '
                <div class="row" style="margin-top:5px;" >
                    <div class="col-md-11" style="background-color:#222533;color:#FFF;border:1px solid #555;padding-top:4px ">
                        <p class="align-middle line-clamp-1 " >'.$d->quest_ask_title.'</p>
                    </div>
                    <div class="col-md-1" onclick="deleteAsks('.$d->id.')" style="color:red;font-weight:bolder;text-align:center;cursor:pointer">
                        <p  style="padding:2px;font-size:20px;cursor:pointer">X</p>
                    </div>
                </div>
            ';
        }

    }
   
}


// Fim  Perguntas













// Inicio Respondendo Formulário
    public function answerAddAnswerUser() {

        $quest_id = $this->input->post('quest_id');
        $answers = $this->input->post('answers[]');
        $quest_data = date('d-m-Y');
        $quest_time = date('H:i:s');
        $quest_user = $this->customlib->getUserData()['id'];

        $quest_criteria = $this->input->post('quest_criteria');
        $quest_segment = $this->input->post('quest_segment');
        $quest_section = $this->input->post('quest_section');
        $quest_teacher = $this->input->post('quest_teacher');

        // Check
        $this->question_model->questionnaries_user_answer_check($quest_id, $quest_user, $quest_data, $quest_time, $quest_criteria, $quest_segment, $quest_section, $quest_teacher);

        foreach ($answers as $a ) {

            $r = explode("-", $a);
            $quest_ask_id = $r[1];
            $quest_answer_id = $r[0];

            $this->question_model->questionnaries_user_answer_list($quest_id, $quest_ask_id, $quest_answer_id, $quest_user);

          
        }

      
    }

    public function answerGetQuestion() {

        $quest_id = htmlspecialchars($this->input->post('quest_id'));
        $data =  $this->question_model->answerGetQuestion($quest_id);

        if (count($data) == 0) {
            echo ' <center><div> <br><br><p> Nenhuma Resposta Cadastrada.</p> </div></center> ';
        } else {
            $count = 0;
            foreach($this->question_model->answerGetAsks($quest_id) as $p) {
                $count++;

                echo '
                <div class="row" style="border-bottom:1px solid #555 ;">
                <div class="col-md-9" style="padding:10px">
                    <small style="font-weight: bold;">PERGUNTA '.$count.'</small>
                    <p>'.$p->quest_ask_title.'</p>
                </div>
                <div class="col-md-3"   >
                                 
                    <select class="form-control " required style="margin-top:15px" name="answers[]" id="">
                        <option value="">SELECIONAR RESPOSTA</option> 
                    
                    ';

                        foreach ($this->question_model->answerGetQuestion($quest_id) as $a) {
                            echo '<option value="'.$a->id.'-'.$p->id.'">'.$a->quest_answer_title.'</option>';
                        }

                echo '</select>
                </div>
            </div>
                ';
            }

        }
    }



        public function answerGetQuestionView() {

            $quest_id = htmlspecialchars($this->input->post('quest_id'));
            $data =  $this->question_model->answerGetQuestion($quest_id);
            $quest_user = $this->customlib->getUserData()['id'];


                                                                                                            
      

    
            if (count($data) == 0) {
                echo ' <center><div> <br><br> <p> Nenhuma Resposta Cadastrada.</p> </div></center> ';
            } else {
                $count = 0;
                foreach($this->question_model->answerGetAsks($quest_id) as $p) {
                    $count++;
    
                    echo '
                    <div class="row" style="border-bottom:1px solid #555 ;">
                    <div class="col-md-9" style="padding:10px">
                        <small style="font-weight: bold;">PERGUNTA '.$count.'</small>
                        <p>'.$p->quest_ask_title.'</p>
                    </div>
                    <div class="col-md-3"   >
                                     
                       
                        
                        ';
    
                       $answer_id =  $this->question_model->user_answer_check_item($quest_id, $p->id, $quest_user);

                       echo '<p style="margin-top:15px;font-weight:bold;text-align:center">'.$this->question_model->getAnswer($answer_id).'</p>';
    
                    echo '
                    </div>
                </div>
                    ';
                }
    
            }

        }

// Fim Respondendo Formulario



// Duplicar

public function Duplicar() {
    $quest_id = $this->input->post('quest_id');

    // Pegando informações
    $q = $this->question_model->getQuestionary($quest_id);
    $asks = $this->question_model->getAsks($quest_id);
    $answers = $this->question_model->getAnswers($quest_id);
    $quest_user = $this->customlib->getUserData()['id'];


    // Criando novo questionario
    $new_quest_id = $this->question_model->addQuestionaryDuplicated("Cópia - ".$q['quest_title'], $q['quest_description'], $q['quest_observation'], $q['quest_criteria'], $q['quest_segment'], $q['quest_section'], $q['quest_data'], $q['quest_time'], $q['quest_status'], $q['quest_teacher'], $quest_user);

    //Criando Perguntas
    foreach ($asks as $ask ) {

        $this->question_model->addAsks($new_quest_id, $ask->quest_ask_title );

    }

    //Criando Respostas
    foreach ($answers as $ans ) {

        $this->question_model->addAnswers($new_quest_id, $ans->quest_answer_title );
    }
}
// Duplicar










    // Function

    public function getClasses() {

        $role = $this->customlib->getUserData();

        if ($role['role_id'] == "2") {

            foreach ( $this->question_model->class_teacher($role['id']) as $class) { 
                echo '<option value="'.$class->class_id.'" >'.$this->class_model->get($class->class_id)['class'].' </option>';
            }

            // print_r($this->question_model->class_teacher($role['id']) );

        } else {
            
            foreach ($this->class_model->get() as $class) { 
                echo '<option value="'.$class['id'].'" >'.$class['class'].' </option>';
            }

        }

    }

    public function getSections() {

        $role = $this->customlib->getUserData();


        if ($role['role_id'] == "2") {

            $teacher_id = $role['id'];
            $data = $this->question_model->class_teacher($teacher_id);
    
            foreach ($data as $sec) { 
                echo '<option value="'.$sec->class_id.'-'.$sec->section_id.'" >'.$this->class_model->get($sec->class_id)['class'].' | '.$this->section_model->get($sec->section_id)['section'].' </option>';
            }

        } else {

            $class_id = $this->input->post('class_id');
            $data = collect($this->section_model->getClassBySection($class_id))->unique('section_id');
    
            foreach ($data->all() as $sec) { 
                echo '<option value="'.$sec['section_id'].'" >'.$sec['section'].' </option>';
            }

        }


        
       

    }

    public function getSectionsRelated() {
       
        $role = $this->customlib->getUserData();


        if ($role['role_id'] == "2") {


            $teacher_id = $role['id'];
            $data = $this->question_model->class_teacher($teacher_id);

            foreach ($data as $sec) { 
                echo '<option value="'.$sec->class_id.'-'.$sec->section_id.'" >'.$this->class_model->get($sec->class_id)['class'].' | '.$this->section_model->get($sec->section_id)['section'].' </option>';
            }

        } else {

            $teacher_id = $this->input->post('teacher_id');
            $data = $this->question_model->class_teacher($teacher_id);

            foreach ($data as $sec) { 
                echo '<option value="'.$sec->class_id.'-'.$sec->section_id.'" >'.$this->class_model->get($sec->class_id)['class'].' | '.$this->section_model->get($sec->section_id)['section'].' </option>';
            }

        }

        

    }

    public function getTeachers() {
        foreach ($this->staff_model->getStaffbyrole($role = 2) as $class) { 
            echo '<option value="'.$class['id'].'" >'.$class['name'].' '.$class['surname'].' </option>';
        }
    }

  
}
