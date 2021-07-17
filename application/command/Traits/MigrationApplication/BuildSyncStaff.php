<?php


namespace Application\Command\Traits\MigrationApplication;

use Illuminate\Support\Str;

trait  BuildSyncStaff
{




    public function buildStaff($data)
    {   

        $name =  explode(' ', $data->nome);
        $firstName =  $name[0];
        unset($name[0]);
        $lastName = implode(' ',$name);
        $isMarried = [
          //  1 => ''
        ];
        // dump(Str::slug($data->cargo));
        $cargo =  Str::slug($data->cargo);
        $isTeach = !empty($data->cargo) && ($cargo == 'professor' || $cargo == 'professora' ) ? 4 : 0;
       // $isTeach = $isTeach !=  0 ? $isTeach : (!empty($data->cargo) &&  strpos('professora', Str::slug($data->cargo))  ? 4 : 0); 
        return [
           'employee_id' => !empty($data->rg) ?  only_numeric($data->rg) : sprintf('R%s',substr(md5(Str::slug($data->nome)),0, 11)),
           'department'  => $isTeach,
           'designation' => $data->designation ??  $data->designation,
           'lang_id' => 92,
           'name' => $firstName,
           'surname' => $lastName,
           'email' => $data->email_profissional ? $data->email_profissional : $data->email,
           'dob' => $data->nasc_data,
           'gender' => $data->sexo == 1 ? 'Male' : 'Female',
           'bank_account_no' => $data->conta_numero,
           'bank_name'=> $data->bank->descricao  ?? $data->bank->descricao ,
           'bank_branch' => $data->conta_agencia,
           'contact_no' => $data->telefone,
           'account_title' => 'conta corrente',
           'date_of_joining' => $data->admissao_data,
           'date_of_leaving' => $data->demissao_data,
           'is_active' => $data->situacao ==  1 ? 1 : 0,
           'emergency_contact_no' => $data->telefone_celular,
           'work_exp' => $data->escolaridade,
           'local_address' => trim(sprintf('%s, %s - %s%s%s%s%s-%s', 
           trim($data->endereco), $data->numero, $data->bairro, 
           PHP_EOL, 
           $data->cep,
           PHP_EOL,
           $data->city->nome ??  $data->city->nome ,  $data->city->uf->sigla ?? $data->city->uf->sigla))
        ];
    }


   
}
