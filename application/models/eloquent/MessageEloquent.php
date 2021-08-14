<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;


class MessageEloquent extends  Eloquent {

  
      
    protected $table = 'messages';

    protected $primaryKey = 'id';

    // public $timestamps = false;

    protected $fillable = [
        'title' ,
        'send_mail'  ,
        'message',
        'is_individual'
    ];
}