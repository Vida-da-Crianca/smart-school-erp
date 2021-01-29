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



    public function student()
    {

        get_instance()->load->model('eloquent/Student_eloquent');
        return $this->belongsTo('Student_eloquent', 'student_id', 'id');
    }
}
