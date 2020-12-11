<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class Student_session_eloquent extends  Eloquent
{

    protected $table = 'student_session';

    // public $timestamps = false;


    protected $fillable = [
       'session_id',
       'student_id',
       'class_id',
       'section_id',
       'is_alumni'
    ];
}
