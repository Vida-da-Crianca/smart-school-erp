<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula_eloquent extends  Eloquent {

   
      
    protected $table = 'tbmatricula';

    protected $primaryKey = 'codmatricula';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];


    public function aluno(){
        get_instance()->load->model('eloquent/migrate/Aluno_eloquent');
        return $this->belongsTo(
            'Aluno_eloquent',
            'codaluno'
        );
    }

    public function serie(){
  

        get_instance()->load->model('eloquent/migrate/Serie_eloquent');
        return $this->belongsTo('Serie_eloquent', 'codserie', 'codserie');

    }

    public function lancamentos() 
    {
        get_instance()->load->model('eloquent/migrate/Lancamento');
        return $this->hasMany('Lancamento', 'codmatricula', 'codmatricula');
    }


   
}