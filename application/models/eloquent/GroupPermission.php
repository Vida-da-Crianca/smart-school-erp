<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupPermission extends  Eloquent {

   
      
    protected $table = 'permission_group';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
         'short_code',
         'is_active',
         'name',
         'system'
        
    ];

    
    
   
}