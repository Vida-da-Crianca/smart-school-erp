<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class Student_orm extends  Eloquent
{

    protected $table = 'students';



    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
