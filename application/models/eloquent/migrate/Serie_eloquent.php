<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serie_eloquent extends  Eloquent {

   
      
    protected $table = 'tbserie';

    protected $primaryKey = 'codserie';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];


   
}