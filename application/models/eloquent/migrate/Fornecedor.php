<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends  Eloquent {

   
      
    protected $table = 'tbestoque_fornecedor';

    protected $primaryKey = 'codestoque_fornecedor';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    
   
}