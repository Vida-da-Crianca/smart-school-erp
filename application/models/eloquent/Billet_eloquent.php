<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billet_eloquent extends  Eloquent {

    use SoftDeletes;
      
    protected $table = 'billets';

    
    protected $fillable = [
        'body',
        'price',
        'status',
        'fee_groups_feetype_id',
        'invoice_id',
        'received_at',
        'fee_session_group_id',
        'fee_master_id'
    ];


    public function student(){

        get_instance()->load->model('Student_orm');
        return $this->hasOne('Student_orm', 'parent_id', 'id');
    }

}