<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departament extends  Eloquent {

   
      
    protected $table = 'department';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
         'department_name',
         'is_active',
         'departament_slug_name'
        
    ];

    
    
   
}