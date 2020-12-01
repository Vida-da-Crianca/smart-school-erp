<?php


use \Illuminate\Database\Eloquent\Model as Eloquent;

class Fee_group_type_eloquent extends  Eloquent
{

    protected $table = 'fee_groups_feetype';


    public function feeGroup(){
        get_instance()->load->model('eloquent/Fee_group_eloquent');
        return $this->belongsTo('Fee_group_eloquent', 'fee_groups_id', 'id');
    }

    
}
