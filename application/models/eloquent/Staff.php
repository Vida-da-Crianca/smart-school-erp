<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends  Eloquent {

   
      
    protected $table = 'staff';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        'employee_id' ,
        'department'  ,
        'designation',
        'lang_id',
        'name' ,
        'surname' ,
        'email',
        'dob',
        'gender',
        'bank_account_no',
        'bank_name' ,
        'bank_branch',
        'contactno',
        'account_title',
        'date_of_joining',
        'date_of_leaving',
        'is_active',
        'emergency_no',
        'work_exp',
        'address' 
        
    ];

    
    
   
}