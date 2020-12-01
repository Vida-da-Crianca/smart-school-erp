<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;



class Invoice_setting_eloquent extends  Eloquent {

   
    protected $table = 'invoice_settings';

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public $incrementing = false;
    
    public $timestamps = false;
    
    protected $fillable = [
        'key',
        'value',
       
    ];


   

}