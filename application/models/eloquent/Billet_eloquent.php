<?php

use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billet_eloquent extends  Eloquent {

    use SoftDeletes;

    const PAID_PENDING = 'AGUARDANDO PAGAMENTO';
    const FOR_CREATE = 'NAO_GERADO';
    
    const PAID = 'PAGO';
      
    protected $table = 'billets';

    
    protected $fillable = [
        'body',
        'price',
        'status',
        'fee_groups_feetype_id',
        'invoice_id',
        'received_at',
        'fee_session_group_id',
        'fee_master_id',
        'user_id',
        'due_date',
        'custom_number'
        
    ];


    public function student()
    {

        get_instance()->load->model('eloquent/Student_eloquent');
        return $this->belongsTo('Student_eloquent', 'user_id', 'id');
    }

    public function feeItems(){
        get_instance()->load->model('eloquent/Student_fee_item_eloquent');
        return $this->belongsToMany(
            'Student_fee_item_eloquent',
            'billet_student_fee_item',
            'billet_id',
            'fee_item_id',
           
           
        );
    }

    public function item(){
        get_instance()->load->model('eloquent/Student_fee_item_eloquent');
        return $this->belongsTo(
            'Student_fee_item_eloquent',
            'billet_student_fee_item',
            'billet_id',
            'fee_item_id',
           
           
        );
    }

    
    public function invoice(){
        get_instance()->load->model('eloquent/Invoice_eloquent');
        return $this->hasMany(
            'Invoice_eloquent',
            'bullet_id',
            'id'
        );
    }
    public function invoices(){
        // get_instance()->load->model('eloquent/Student_fee_item_eloquent');
        get_instance()->load->model('eloquent/Invoice_eloquent');
        return $this->belongsToMany(
            'Invoice_eloquent',
            'invoice_billet',
            'billet_id',
            'invoice_id',
            'sended_mail_at'
        );
    }


    public function getBodyJsonAttribute(){
        return json_decode($this->body);
    }



    public function scopeIsOld($query)
    {
        return $query->where('status', self::PAID_PENDING)
             ->whereNotNull('bank_bullet_id')
             ->where('due_date','<=', Carbon::now()->subDay(3));
    }
}