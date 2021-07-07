<?php

class Data_corte_model extends Root_model
{
    
    var $idDataCorte;
    var $session_id;
    var $dataInicial;
    var $dataFinal;
    var $class_id;
    public function __construct()
    { 
        parent::__construct();
	$this->table = "data_corte";
    }
    
    public function get($id)
    { 
	parent::bindFieldsFromDB( 'Data_corte_model' , 'idDataCorte',$id, 'Erro ao Carregar Data de Corte. Verifique!');
    }
    
    public function getAll( $filters = null )
    { 
        if(is_array($filters))
            extract($filters);
        
        $this->db->select('data_corte.*,'
                . 'DATE_FORMAT( data_corte.dataInicial , "%d/%m/%Y") AS dataInicialBr,'
                . 'DATE_FORMAT( data_corte.dataFinal , "%d/%m/%Y") AS dataFinalBr,'
                . 'sessions.session AS sessionName,'
                . 'classes.class AS className')
                ->from('data_corte')
                ->join('sessions','sessions.id = data_corte.session_id ','left')
                ->join('classes','classes.id = data_corte.class_id ','left');
        
        $this->_filter('data_corte.idDataCorte', isset($idDataCorte) ? $idDataCorte : 0, true);
        $this->_filter('data_corte.session_id', isset($session_id) ? $session_id : 0, true);
        $this->_filter('data_corte.class_id', isset($class_id) ? $class_id : 0, true);
        
        if(isset($data1) && !empty($data1) && isset($data2) && !empty($data2)){
            $this->db->where("data_corte.dataInicial BETWEEN '$data1' AND '$data2'");
        }
        
        //$this->db->where('data_corte.campo !=','');
        
        if(isset($order_by) && is_array($order_by)){
            foreach ($order_by as $field => $direction){
                $this->db->order_by($field,$direction);
            }
        }else{
            $this->db->order_by('sessions.session','ASC');
            $this->db->order_by('data_corte.dataInicial','ASC');
        }
        
        
        return $this->executeQUERY();
                
    }
    
    
    public function validar($update=null){
            
        $this->db->where('session_id',$this->session_id);
        $this->db->where('class_id',$this->class_id);

        $res = $this->db->get($this->table)->result();

        if(count($res)>0){

            throw new Exception('Data de Corte já Definida para Essa Turma Nessa Sessão! Verifique!');
        }
            
            
    }
    
    public function add()
    { 
        if(!$this->db->insert($this->table, $this))
        { 
            $e = $this->db->error();
            throw new Exception('Erro ao Gravar Data de Corte!'.$this->extractErroMsg ($e['message']));
        }
    }
    
}
