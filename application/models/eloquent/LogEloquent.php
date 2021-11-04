<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogEloquent extends  Eloquent
{

  


    protected $table = 'invoice_logs';


    protected $fillable = [
        'logger',
        'table',
        'register_id',
        'action'
      
    ];


}
