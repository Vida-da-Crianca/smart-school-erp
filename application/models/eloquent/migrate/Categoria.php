<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends  Eloquent {

   
      
    protected $table = 'tbcentro_custo_cat';

    protected $primaryKey = 'codcategoria';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];
    

   
   
}