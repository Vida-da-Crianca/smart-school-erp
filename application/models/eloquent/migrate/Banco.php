<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends  Eloquent {

   
      
    protected $table = 'tbbanco';

    protected $primaryKey = 'codbanco';

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
    
   
}