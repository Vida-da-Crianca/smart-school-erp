<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends  Eloquent
{



    protected $table = 'expenses';

    protected $primaryKey = 'id';

    // public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
        'exp_head_id', 'name',
        'invoice_no', 'date',
        'amount',
        'documents', "note", 'owner_id',
        'owner_type', 'is_active', 'is_deleted', 'payment_at',
        // 'created_at', 'updated_at'

    ];




}
