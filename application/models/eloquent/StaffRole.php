<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffRole extends  Eloquent {

   
      
    protected $table = 'staff_roles';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        'role_id' ,
        'staff_id'  ,
        'is_active',
       
        
    ];

    
    
   
}