<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends  Eloquent {

   
      
    protected $table = 'item_supplier';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        
    ];

    
    
   
}