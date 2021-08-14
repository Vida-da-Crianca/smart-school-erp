<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailerEloquent extends  Eloquent {

    use SoftDeletes;
      
    protected $table = 'mailers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'to' ,
        'from'  ,
        'subject',
        'message',
        'retry' ,
        'max_retry' ,
        'sended_at',
    ];
}