<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends  Eloquent {

  
    protected $table = 'sections';

    
    protected $fillable = [
       
        
    ];


    

    public function classe(){
        get_instance()->load->model('eloquent/Student_classe');
        return $this->belongsToMany(
            'Student_classe',
            'class_sections',
            'section_id',
            'class_id',
           
           
        );
    }
    

}