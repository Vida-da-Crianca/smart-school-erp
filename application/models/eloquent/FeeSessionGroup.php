<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class FeeSessionGroup extends  Eloquent
{

    protected $table = 'fee_session_groups';



    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        'fee_groups_id' ,
        'session_id'  ,
        'is_active',
        'created_at',
      
        
    ];

    
}
