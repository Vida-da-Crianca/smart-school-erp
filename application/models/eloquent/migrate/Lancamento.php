<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends  Eloquent
{



    protected $table = 'tblancamento';

    protected $primaryKey = 'codlancamento';

    protected $connection = 'mysql_2';
    protected $fillable = [];


    public function boleto(){


        get_instance()->load->model('eloquent/migrate/Boleto');
        return $this->belongsTo(
            'Boleto',
            'codboleto',
            'codboleto'
        );

    }
}
