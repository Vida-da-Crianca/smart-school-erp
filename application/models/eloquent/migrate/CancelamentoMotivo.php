<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelamentoMotivo extends  Eloquent {

   
      
    protected $table = 'tbmotivocancelamento';

    protected $primaryKey = 'codmotivocancelamento';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];


    

    
}