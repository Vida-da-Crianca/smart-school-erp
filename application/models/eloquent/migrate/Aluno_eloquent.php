<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno_eloquent extends  Eloquent {

   
      
    protected $table = 'tbaluno';

    protected $primaryKey = 'codaluno';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    

    public function guardian(){
        get_instance()->load->model('eloquent/migrate/Guardian_eloquent');
        return $this->belongsToMany(
            'Guardian_eloquent',
            'tbalunoresp',
            'codresp',
            'codalunoresp'
           
        );
    }
   
}