<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class Fee_group_eloquent extends  Eloquent
{

    protected $table = 'fee_groups';



    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        'name' ,
        'is_system'  ,
        'description',
        'is_active',
        'created_at',
      
        
    ];

    
}
