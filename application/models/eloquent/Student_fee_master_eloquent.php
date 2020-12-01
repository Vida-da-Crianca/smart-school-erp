<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class Student_fee_master_eloquent extends  Eloquent
{

    protected $table = 'student_fees_master';

    public $timestamps = false;


    protected $fillable = [
     'is_system', 'student_session_id', 'fee_session_group_id','amount','is_active'
    ];
}
