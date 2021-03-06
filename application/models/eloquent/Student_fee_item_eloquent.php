<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student_fee_item_eloquent extends  Eloquent
{

    use SoftDeletes;



    protected $table = 'student_fee_items';


    protected $fillable = [
        'user_id',
        'feetype_id',
        'title',
        'amount',
        'student_fees_deposite_id',
        'fee_master_id',
        'fee_session_group_id',
        'received_at',
        'due_date',
        'student_session_id',
        'class_id'
    ];


    public function student()
    {

        get_instance()->load->model('eloquent/Student_eloquent');
        return $this->belongsTo('Student_eloquent', 'user_id', 'id');
    }

    public function session()
    {

        get_instance()->load->model('eloquent/Student_session_eloquent');
        return $this->belongsTo('Student_session_eloquent', 'student_session_id', 'id');
    }

    public function fee_type()
    {

        get_instance()->load->model('eloquent/Fee_type_eloquent');
        return $this->belongsTo('Fee_type_eloquent', 'feetype_id', 'id');
    }


    public function getAmountRealAttribute()
    {
        return number_format($this->amount, 2, ',','.');
    }

    public function deposite(){
        get_instance()->load->model('eloquent/Student_deposite_eloquent');
        return $this->hasOne('Student_deposite_eloquent', 'student_fees_id',  'id');
    }

    


    public function billet(){
        get_instance()->load->model('eloquent/Billet_eloquent');
        return $this->belongsToMany(
            'Billet_eloquent',
            'billet_student_fee_item',
            'fee_item_id',
            'billet_id'
           
        );
    }
}
