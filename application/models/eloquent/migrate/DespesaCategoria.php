<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class DespesaCategoria extends  Eloquent {

   
      
    protected $table = 'tbmovimento';

    protected $primaryKey = 'codmovimento';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    
   
}