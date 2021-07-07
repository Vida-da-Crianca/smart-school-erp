<?php

class Orcamento_model extends Root_model
{
    
    var $idOrcamento;
    var $alunoNome;
    var $alunoSobrenome;
    var $genero;
    var $dataNascimento;
    var $maeNome;
    var $maeTelefone;
    var $maeOcupacao;
    var $paiNome;
    var $paiTelefone;
    var $paiOcupacao;
    var $responsavelFinanceiro;
    var $responsavelFinanceiroCPF;
    var $responsavelFinanceiroNome;
    var $responsavelFinanceiroRelacao;
    var $responsavelFinanceiroTelefone;
    var $responsavelFinanceiroOcupacao;
    var $responsavelFinanceiroEmail;
    var $cep;
    var $endereco;
    var $numero;
    var $bairro;
    var $cidade;
    var $uf;
    var $complemento;
    var $dataOrcamento;
    var $horaOrcamento;
    var $dataValidade;
    var $session_id;
    var $class_id;
    var $section_id;
    var $observacoes;
    var $status;
    var $quantidadeItens;
    var $valorItens;
    var $valorDesconto;
    var $valorFinal;
    
    var $quantidadeItensParcelaEscolar;
    var $valorItensParcelaEscolar;
    var $valorDescontoParcelaEscolar;
    var $valorFinalParcelaEscolar;
    var $numeroParcelasEscolares;
    
    var $numeroParcelas;
    var $valorParcelaEscolar;
    
    var $token;
    var $staff_id;
    var $source_id;
    var $geradoMatricula;
    
    
    public function __construct()
    { 
        parent::__construct();
	$this->table = "orcamento";
    }
    
    public function get($id)
    { 
	parent::bindFieldsFromDB( 'Orcamento_model' , 'idOrcamento',$id, 'Erro ao Carregar Orçamento. Verifique!');
    }
    
    public function getByToken($token)
    { 
	parent::bindFieldsFromDB( 'Orcamento_model' , 'token',$token, 'Orçamento nao encontrado!');
    }
    
    public function getAll( $filters = null )
    { 
        if(is_array($filters))
            extract($filters);
        
        $this->db->select('orcamento.*,'
                . 'DATE_FORMAT( orcamento.dataOrcamento , "%d/%m/%Y") AS dataOrcamentoBr,'
                . 'DATE_FORMAT( orcamento.dataValidade , "%d/%m/%Y") AS dataValidadeBr,'
                . 'DATE_FORMAT( orcamento.dataNascimento , "%d/%m/%Y") AS dataNascimentoBr,')
                ->from('orcamento');
                /*->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left')
                ->join('Orcamento','Orcamento.id = Orcamento.id ','left');*/
        
        $this->_filter('orcamento.idOrcamento', isset($idOrcamento) ? $idOrcamento : 0, true);
        if(isset($nome) && !empty($nome)){
            $this->db->where("( orcamento.alunoNome LIKE '%$nome%' OR orcamento.alunoSobrenome LIKE '%$nome%' OR orcamento.responsavelFinanceiroNome LIKE '%$nome%' OR orcamento.responsavelFinanceiroTelefone LIKE '%$nome%' OR orcamento.responsavelFinanceiroEmail LIKE '%$nome%' OR orcamento.maeNome LIKE '%$nome%' OR orcamento.paiNome LIKE '%$nome%')");
        }
        
        if(isset($telefone) && !empty($telefone)){
            $this->db->where("( orcamento.responsavelFinanceiroTelefone LIKE '%$telefone%')");
        }
        
        if(isset($data1) && !empty($data1) && isset($data2) && !empty($data2)){
            $this->db->where("orcamento.dataOrcamento BETWEEN '$data1' AND '$data2'");
        }
        
        if(isset($dataNascimento1) && !empty($dataNascimento1) && isset($dataNascimento2) && !empty($dataNascimento2)){
            $this->db->where("orcamento.dataNascimento BETWEEN '$dataNascimento1' AND '$dataNascimento2'");
        }
        
        $this->db->where('orcamento.status !=','0');//nao listamos os inciados e nao salvos
        
        if(isset($order_by) && is_array($order_by)){
            foreach ($order_by as $field => $direction){
                $this->db->order_by($field,$direction);
            }
        }else{
            $this->db->order_by('orcamento.dataOrcamento','DESC');
            $this->db->order_by('orcamento.idOrcamento','DESC');
        }
        
        
        return $this->executeQUERY();
                
    }
    
    
    public function validar($update=null){
            
        $this->db->where('nome',$this->nome);

        if($update){
            $this->db->where('idOrcamento !=',$this->idVendedor);
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
            throw new Exception('Erro ao Gravar Orçamento!'.$this->extractErroMsg ($e['message']));
        }
    }
    
    public function atualizarTotais($idOrcamento){
        
        $sql = "UPDATE orcamento SET quantidadeItens = ( SELECT sum(orcamento_item.quantidade) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 0 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET valorItens = ( SELECT sum(orcamento_item.valorItem) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 0 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET valorDesconto = ( SELECT sum(orcamento_item.descontoValor) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 0 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET valorFinal = ( SELECT sum(orcamento_item.valorFinal) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 0 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET quantidadeItensParcelaEscolar = ( SELECT sum(orcamento_item.quantidade) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 1 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET valorItensParcelaEscolar = ( SELECT sum(orcamento_item.valorItem) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 1 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET valorDescontoParcelaEscolar = ( SELECT sum(orcamento_item.descontoValor) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 1 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        $this->db->query($sql);
        
        $sql = "UPDATE orcamento SET valorFinalParcelaEscolar = ( SELECT sum(orcamento_item.valorFinal) FROM orcamento_item WHERE orcamento_item.idOrcamento = $idOrcamento AND IFNULL(orcamento_item.parcelaEscolar,0) = 1 LIMIT 1 ) "
                . "WHERE idOrcamento = $idOrcamento LIMIT 1";
        
        
        $this->db->query($sql);
        
    }
    
}
