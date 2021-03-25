<?php



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends  Eloquent
{

    use SoftDeletes;

    protected $table = 'documents';


    protected $fillable = [
        'body',
        'title',
        'is_active',
    ];


   
}
