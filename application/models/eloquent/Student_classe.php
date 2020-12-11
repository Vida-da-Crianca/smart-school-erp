<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student_classe extends  Eloquent {

  
    protected $table = 'classes';

    
    protected $fillable = [
       
        
    ];


    

    public function section(){
        get_instance()->load->model('eloquent/Section');
        return $this->belongsToMany(
            'Section',
            'class_sections`',
            'class_id',
            'section_id',
            
           
           
        );
    }
    

}