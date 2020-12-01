<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;



class Invoice_resume_eloquent extends  Eloquent {

   
    protected $table = 'invoice_resume';

    protected $primaryKey = 'due_date';

    protected $keyType = 'date';

    public $incrementing = false;
    
    public $timestamps = false;
    
    protected $fillable = [
        'due_date',
        'total',
       
    ];


   

}