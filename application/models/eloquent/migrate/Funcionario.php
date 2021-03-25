<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends  Eloquent {

   
      
    protected $table = 'tbprofessor';

    protected $primaryKey = 'codprofessor';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];
    

    public function city(){
        get_instance()->load->model('eloquent/migrate/Cidade');
        return $this->hasOne(
            'Cidade',
            'codcidade',
            'codcidade'
        );
    }


    public function bank(){
        get_instance()->load->model('eloquent/migrate/Banco');
        return $this->hasOne(
            'Banco',
            'codbanco',
            'conta_banco'
        );
    }
    
   
}