<?php 

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice_model extends  Eloquent {
    
    use SoftDeletes;

    protected $table = 'invoices';


    public function owner(){
        get_instance()->load->model('User_orm_model');

       

        return $this->belongsTo('User_orm_model', 'user_id', 'id');
    }
}