<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student_deposite_eloquent extends  Eloquent {

    
    protected $table = 'student_fees_deposite';

    public $timestamps = false;

    protected $fillable = [
        'fee_groups_feetype_id',
        'student_fees_master_id',
        'is_active',
        'amount_detail',
        'student_fees_id',
        'created_at'
    ];


    public function student(){

        get_instance()->load->model('eloquent/Student_eloquent');
        return $this->hasOne('Student_eloquent', 'id','student_fees_master_id');
    }


    public function feeGroupType(){
        get_instance()->load->model('eloquent/Fee_group_type_eloquent');
        return $this->belongsTo('Fee_group_type_eloquent', 'fee_groups_feetype_id', 'id');
    }

    public function feeItem(){
        get_instance()->load->model('eloquent/Student_fee_item_eloquent');
        return $this->belongsTo('Student_fee_item_eloquent', 'student_fees_id', 'id');
    }

    public function getDetailAttribute(){
        return (object) json_decode($this->amount_detail, true)[1];
    }

    // public function invoice(){
    //     get_instance()->load->model('eloquent/Invoice_eloquent');
    //     return $this->belongsTo('Invoice_eloquent','id', 'student_fees_deposite_id');
    // }


    public function invoice(){
        // get_instance()->load->model('eloquent/Student_fee_item_eloquent');
        get_instance()->load->model('eloquent/Invoice_eloquent');
        return $this->belongsToMany(
            'Invoice_eloquent',
            'invoice_deposite',
            'deposite_id',
            'invoice_id',
           
           
        );
    }




}