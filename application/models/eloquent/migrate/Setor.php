<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends  Eloquent {

   
      
    protected $table = 'tbos_setor';

    protected $primaryKey = 'codos_setor';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    
   
}