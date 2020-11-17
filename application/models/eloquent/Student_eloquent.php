<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class Student_eloquent extends  Eloquent
{

    protected $table = 'students';



    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }



    public function fees(){
        
        get_instance()->load->model('eloquent/Student_fee_item_eloquent');
        return $this->hasMany('Student_fee_item_eloquent', 'user_id', 'id');
    }
}
