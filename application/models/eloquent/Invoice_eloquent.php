<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice_eloquent extends  Eloquent
{

    use SoftDeletes;

    const PENDING_CREATE = 'NAO GERADA';

    const PENDING_DELETE = 'AGUARDANDO CANCELAMENTO';

    const DELETED = 'CANCELADA';

    const VALID = 'VALIDA';


    protected $table = 'invoices';


    protected $fillable = [
        'body',
        'price',
        'status',
        'student_fees_deposite_id',
        'aliquota',
        'invoice_number',
        'autenticidade',
        'user_id',
        'bullet_id',
        'due_date'
    ];


    public function student()
    {

        get_instance()->load->model('eloquent/Student_eloquent');
        return $this->belongsTo('Student_eloquent', 'user_id', 'id');
    }

    public function feeStudentDeposite()
    {
        get_instance()->load->model('eloquent/Student_deposite_eloquent');
        return $this->belongsTo('Student_deposite_eloquent', 'student_fees_deposite_id', 'id');
    }
    public function billet(){
        get_instance()->load->model('eloquent/Billet_eloquent');
        return $this->belongsTo('Billet_eloquent', 'bullet_id', 'id');
    }

   

    public function scopeValid($query)
    {
        return $query->where('status', self::VALID);
    }

    public function scopeForGenerate($query)
    {
        return $query->where('status', self::PENDING_CREATE)
            ->where(function ($q) {
                return $q->where('invoice_number', '=', '')
                    ->orWhereNull('invoice_number');
            })
            ->where('price', '>', '0');
    }

    public function scopeForDelete($query)
    {
        return $query->where('status', self::PENDING_DELETE)
            ->where('price', '>', '0');
    }
}
