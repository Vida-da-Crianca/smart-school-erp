<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student_deposite_eloquent extends  Eloquent {

    
    protected $table = 'student_fees_deposite';
    protected $fillable = [
        'fee_groups_feetype_id',
        'student_fees_master_id',
        'is_active',
        'amount_detail'
    ];


    public function student(){

        get_instance()->load->model('Student_orm');
        return $this->hasOne('Student_orm', 'parent_id', 'id');
    }

}