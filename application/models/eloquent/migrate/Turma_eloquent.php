<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma_eloquent extends  Eloquent {

   
      
    protected $table = 'tbturma';

    protected $primaryKey = 'codturma';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    public function serie(){
  

        get_instance()->load->model('eloquent/migrate/Serie_eloquent');
        return $this->hasOne('Serie_eloquent', 'codserie', 'codserie');

    }


    public function matriculas(){
  

        get_instance()->load->model('eloquent/migrate/Matricula_eloquent');
        return $this->hasMany('Matricula_eloquent', 'codturma', 'codturma');

    }



   
}