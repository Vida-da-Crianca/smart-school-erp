<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends  Eloquent {

   
      
    protected $table = 'tbcidade';

    protected $primaryKey = 'codcidade';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];


    public function uf(){
        get_instance()->load->model('eloquent/migrate/Estado');
        return $this->hasOne(
            'Estado',
            'codestado',
            'codestado'
        );
    }

    
}