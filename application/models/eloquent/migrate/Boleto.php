<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boleto extends  Eloquent {

   
      
    protected $table = 'tbboleto';

    protected $primaryKey = 'codboleto';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    
   
}