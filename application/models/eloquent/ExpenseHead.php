<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseHead extends  Eloquent {

   
      
    protected $table = 'expense_head';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // protected $connection = 'mysql';
    protected $fillable = [
      'exp_category',
      'category_last_id',
      'description',
      'is_active',
      'is_deleted'
        
    ];

    
    
   
}