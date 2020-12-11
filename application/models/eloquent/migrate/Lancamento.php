<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lancamento extends  Eloquent
{



    protected $table = 'tblancamento';

    protected $primaryKey = 'codlancamento';

    protected $connection = 'mysql_2';
    protected $fillable = [];
}
