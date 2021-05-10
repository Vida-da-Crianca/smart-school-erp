<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasseSection extends  Eloquent {

  
    protected $table = 'class_sections';

    
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