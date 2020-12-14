<?php 



use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno_eloquent extends  Eloquent {

   
      
    protected $table = 'tbaluno';

    protected $primaryKey = 'codaluno';

    protected $connection = 'mysql_2';
    protected $fillable = [
       
        
    ];

    

    public function guardian(){
        get_instance()->load->model('eloquent/migrate/Guardian_eloquent');
        return $this->belongsTo(
            'Guardian_eloquent',
            'codresp_financeiro'
        );
    }


    public function mother(){
        get_instance()->load->model('eloquent/migrate/Guardian_eloquent');
        return $this->belongsTo(
            'Guardian_eloquent',
            'codresp_mae'
        )->whereIn('sexo',[0,2]);
    }

    public function father(){
        get_instance()->load->model('eloquent/migrate/Guardian_eloquent');
        return $this->belongsTo(
            'Guardian_eloquent',
            'codresp_pai'
        )->whereIn('sexo',[1]);
    }

    public function classe(){
        get_instance()->load->model('eloquent/migrate/Classe_eloquent');
        return $this->belongsTo(
            'Classe_eloquent',
            'codresp_financeiro'
        );
    }


    public function city(){
        get_instance()->load->model('eloquent/migrate/Cidade');
        return $this->hasOne(
            'Cidade',
            'codcidade',
            'codcidade'
        );
    }

    public function cityBirthDay(){
        get_instance()->load->model('eloquent/migrate/Cidade');
        return $this->hasOne(
            'Cidade',
            'codcidade',
            'nasc_codcidade'
        );
    }
   
}