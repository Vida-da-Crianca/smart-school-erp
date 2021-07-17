<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Email_setting_eloquent extends  Eloquent {

  
    protected $table = 'email_config';
 
    
    public $timestamps = false;
    
    protected $fillable = [
        'email_type',
        'smtp_server',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'ssl_tls',
        'is_active',
       
        
    ];
    
    /**
     * local scope for get all is active
     *
     * @param [type] $q
     * @return void
     */
    public function scopeIsActive($q){
         return $q->where('is_active','yes');
    }
}