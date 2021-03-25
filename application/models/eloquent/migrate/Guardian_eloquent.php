<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian_eloquent extends  Eloquent {

   
      
    protected $table = 'tbresp';

    protected $primaryKey = 'codresp';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];


   
}