<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends  Eloquent {

   
      
    protected $table = 'tbmovimento';

    protected $primaryKey = 'codmovimento';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];
    

    public function staff(){
        get_instance()->load->model('eloquent/migrate/Funcionario');
        return $this->hasOne(
            'Funcionario',
            'codprofessor',
            'codfornecedor'
        );
    }


    public function supplier(){
        get_instance()->load->model('eloquent/migrate/Fornecedor');
        return $this->hasOne(
            'Fornecedor',
            'codestoque_fornecedor',
            'codfornecedor'
        );
    }
    
   
}