<?php 


use \Illuminate\Database\Eloquent\Model as Eloquent;

class User_orm_model extends  Eloquent {
      
    protected $table = 'users';




    public function student(){

        get_instance()->load->model('Student_orm');
        
        return $this->hasOne('Student_orm', 'parent_id', 'id');
    }

}