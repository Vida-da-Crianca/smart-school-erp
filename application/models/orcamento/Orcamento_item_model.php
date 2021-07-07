<?php
class Orcamento_item_model extends Root_model
{
    
    var $idOrcamentoItem;
    var $idOrcamento;
    var $tipo; // 1 = FEES (taxas) 2 STOCK (itens)
    var $fee_groups_feetype_id;
    var $item_stock_id;
    var $valorUnitario;
    var $quantidade;
    var $valorItem;
    var $descontoTipo;
    var $descontoValor;
    var $valorFinal;
    var $obs;
    var $descricao;
    var $diaVencimento;
    var $parcelaEscolar;
    
    public function __construct()
    { 
        parent::__construct();
	$this->table = "orcamento_item";
    }
    
    public function get($id)
    { 
	parent::bindFieldsFromDB( 'Orcamento_item_model' , 'idOrcamentoItem',$id, 'Erro ao Carregar Orcamento_item. Verifique!');
    }
    
    public function getAll( $filters = null )
    { 
        if(is_array($filters))
            extract($filters);
        
        $this->db->select('orcamento_item.*')
                ->from('orcamento_item');
        
        $this->_filter('orcamento_item.idOrcamentoItem', isset($idOrcamentoItem) ? $idOrcamentoItem : 0, true);
        $this->_filter('orcamento_item.idOrcamento', isset($idOrcamento) ? $idOrcamento : 0, true);
        $this->_filterLike('orcamento_item.descricao', isset($descricao) ? $descricao :null);
        
        //if(isset($data1) && !empty($data1) && isset($data2) && !empty($data2)){
        //    $this->db->where("orcamento_item.data BETWEEN '$data1' AND '$data2'");
        //}
        
        //$this->db->where('orcamento_item.campo !=','');
        
        if(isset($order_by) && is_array($order_by)){
            foreach ($order_by as $field => $direction){
                $this->db->order_by($field,$direction);
            }
        }else{
            $this->db->order_by('orcamento_item.idOrcamentoItem','ASC');
        }
        
        
        return $this->executeQUERY();
                
    }
    
    
    public function validar($update=null){
            
        $this->db->where('nome',$this->nome);

        if($update){
            $this->db->where('idOrcamentoItem !=',$this->idVendedor);
        }
        $res = $this->db->get($this->table)->result();

        if(count($res)>0){

            throw new Exception('Nome já Cadastrado! Verifique!');
        }
            
            
    }
    
    public function add()
    { 
        if(!$this->db->insert($this->table, $this))
        { 
            $e = $this->db->error();
            throw new Exception('Erro ao Gravar Orcamento_item!'.$this->extractErroMsg ($e['message']));
        }
    }
    
}
