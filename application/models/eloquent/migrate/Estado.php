<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends  Eloquent {

   
      
    protected $table = 'tbestado';

    protected $primaryKey = 'codestado';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    
}