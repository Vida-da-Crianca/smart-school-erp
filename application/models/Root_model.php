<?php
class Root_model extends CI_Model
{
	/* campos comuns a todas as classes */
			
	protected $table;
		
	private $erro = null;
	public function getErro()
	{
		return $this->erro;
	}
	public function setErro($msg)
	{
		$this->erro = $msg;
	}
	
	public function __construct()
	{
		parent::__construct();
                
                ini_set('pcre.backtrack_limit',1000000); 
                ini_set('pcre.recursion_limit',1000000);
	}
	
	/***
	 * Carrega uma tabela do banco de dados e 'liga' os seus campos com os atributos de uma classe
	 * @param $class String Nome da Classe
	 * @param Spk_field StrigChave Primaria para Filtro
	 * @param $pk_value Valor da Chave Primaria
	 * @msg_erro Strin
	 */
	public function bindFieldsFromDB($class,$pk_field,$pk_value,$msg_erro)
	{
		$this->db->where($pk_field,$pk_value);
		
		$res = $this->db->get($this->table)->result();
	
		if(count($res) > 0)
		{
			foreach ($res[0] as $key => $value)
			{			
				if(property_exists($class, $key))
					$this->$key = $value;
			}
		}
		else
			throw new Exception($msg_erro);
		
	}
        
        public function bindMultiplesFieldsFromDB($class,$fields,$msg_erro)
	{
                foreach ($fields as $key => $field){    
                    $this->db->where($key,$field);
                }
		
		$res = $this->db->get($this->table)->result();
	
		if(count($res) > 0)
		{
			foreach ($res[0] as $key => $value)
			{			
				if(property_exists($class, $key))
					$this->$key = $value;
			}
		}
		else
			throw new Exception($msg_erro);
		
	}
    
    
    public function _bindFieldsFromDB($class, $loja, $pk_field,$pk_value,$msg_erro)
	{
		$this->db->where('loja', $loja);
		$this->db->where($pk_field,$pk_value);
	
		$res = $this->db->get($this->table)->result();
        
       	
		if(count($res) > 0)
		{
			foreach ($res[0] as $key => $value)
			{
				if(property_exists($class, $key))
					$this->$key = $value;
			}
		}
		else
			throw new Exception($msg_erro);
	
	
	}
	
	public function search()
	{
		return $this->db->get($this->table)->result();
	}
	
	/***
	 * Recupera o valor de um campo específico
	 * @param $field string O campo a ser recuperado
	 * @param $filter_label string O campo a ser filtrado ex: codigo, id
	 * @param $filter_value mixed O valor a ser aplicado em $filter_label
	 * @return mixed O valor do campo solicitado ou null caso não encontrado 
	 */	
	public function getFieldValue($field,$filter_label,$filter_value=null)
	{	
		try 
		{
			$this->db->select($field);
			$this->db->from($this->table);
			
                        if(!is_array($filter_label)){
                            $this->db->where("$filter_label" , $filter_value);
                        }else{
                            foreach ($filter_label as $filter){
                                  
                                $this->db->where($filter[0] , $filter[1]);
                               
                            }
                        }
			
			$res = $this->db->get()->result();
												
			return ( count($res) > 0 ) ? $res[0]->$field : null;
		}
		catch (Exception $e)
		{
			log_e('getFieldValue: ' . $e->getMessage());	
			return null;
		}
	}
	
	/***
	 * Gera um array [CHAVE]=>VALOR 
	 * @param string $field_key O campo 'CHAVE' 
	 * @param string $field_show O campo 'VALOR'
	 * @param string|null $first Se presente então o primeiro elemento do array (chave/posição 0) será o valor desse parâmetro
	 * @param $enc_key boolean|null Indica se deve-se ou não encriptar a 'CHAVE'
	 * @param array|null $filters Se presente, deve ser um array [campo_a_ser_filtrado]=>valor_aplicado_nesse_campo. Ex array('codigo'=>4587). Aplica um filtro na query de consulta.
	 * @return array Array com os valores encontrados
	 */
	public function listForComboBox($field_key, $field_show, $first = null, $enc_key = null, $filters = null, $order_by = null,$filtroEmpresa = null)
	{
		$values = array();
		
		if($first){
			$values[($enc_key) ? $this->tools->encode(0) : 0] = $first;
                }

		$this->db->select("$field_key , $field_show");
		$this->db->from($this->table);
		
                if($filtroEmpresa){
                    $this->db->where('idEmpresa', (int) $this->tools->decode($this->session->idEmpresa));
                }
                
		if(is_array($filters)){
			foreach ($filters as $key => $value){
               
                if(is_array($value) && count($value) > 0)
                    $this->db->where_in("$key", $value);
                else
                    $this->db->where("$key", "$value");
            }
        }
		
		if(is_array($order_by))
			foreach ($order_by as $key => $value)
				$this->db->order_by("$key", "$value");
		
		try
		{
			
			$res = $this->db->get()->result();
			
			
			if(count($res) > 0 )
			{
				foreach ($res as $row)
					$values[ ($enc_key) ? $this->tools->encode($row->$field_key) :  $row->$field_key ] = $row->$field_show;
			}
			else
				$values[0] = 'Nenhum Registro Encontrado';
		}
		catch (Exception $e)
		{
			log_e('listForComboBox: ' . $e->getMessage());
			return null;
		}
			
		
		return $values;
	}
	
	/***
	 * Verifica se um determinado valor ja esta cadastrado na tabela
	 * @param $fields Array Campos a serem valdados FORMATO: ([0]=>array('field'=>array('campo','valor'),'exclude'=>array('campo_exclude','valor_exclude'),'msg'=>'String'))
	 * @return boolean
	 */
	public function validate_fields($fields = array())
	{	
		$this->erro = null;
		
		if(is_array($fields))
			foreach ($fields as $field)
			{
				$this->db->where($field['field'][0],$field['field'][1]);
				
				if(isset($field['and_where']))
					$this->db->where($field['and_where'][0],$field['and_where'][1]);
				
				if(isset($field['and_where_to']))
					$this->db->where($field['and_where_to'][0],$field['and_where_to'][1]);
				
				if( !is_null($field['exclude']))
					$this->db->where($field['exclude'][0] . ' !=', $field['exclude'][1]);
				
				$res = $this->db->get($this->table)->result();
				
				
				
				if( count($res) > 0 )
				{
					$this->erro = $field['msg'];
					return false;
				}
			}
			
		return true;
	}
	
	
	
	public function executeQUERY($table=null)
	{	
            if($table)
                $res = $this->db->get($table);
            else
                $res = $this->db->get();

            if(!$res)
            {
                $e = $this->db->error();   
                throw new Exception('Erro na Pesquisa: '.$e['message']);
            }

            return $res->result();
	}
    
    
    public function extractErroMsg($erro)
    {
        if(!strpos($erro, '#45000#'))
           return $erro;
        
        $err = explode('#45000#', $erro);
        
        return isset($err[1]) ? $err[1] : 'Erro de Banco de Dados!';
    }
    
    
    public function _update($field, $id, $dados)
    {
				
       $this->db->where($field, $id);
		
	if(!$this->db->update($this->table, $dados))
        {
            $e = $this->db->error();   
            throw new Exception('Erro ao Alterar Registro! '.$this->extractErroMsg ($e['message']));
        }
    }
    
    public function _updateArr($wheres, $dados)
	{
				
		foreach ($wheres as $campo => $valor){
                    $this->db->where($campo, $valor);
                }
		
		if(!$this->db->update($this->table, $dados))
        {
            $e = $this->db->error();   
			throw new Exception('Erro ao Alterar Registro! '.$this->extractErroMsg ($e['message']));
        }
	}
    
        public function _delete($field, $id)
	{
            if(!is_array($id)){		
                $this->db->where($field, $id);
            }
            else {
                 $this->db->where_in($field, $id);
            }
		
            if(!$this->db->delete($this->table))
            {
                $e = $this->db->error();   
                            throw new Exception('Erro ao Excluir Registro! '.$this->extractErroMsg ($e['message']));
            }
	}
    
     public function _deleteArr($wheres)
	{
			
        foreach ($wheres as $campo => $valor){
            $this->db->where($campo, $valor);
        }
        
		if(!$this->db->delete($this->table))
        {
            $e = $this->db->error();   
			throw new Exception('Erro ao Excluir Registro! '.$this->extractErroMsg ($e['message']));
        }
        
    }
    
    
    public function _rawQuery($sql){
        
        $query = $this->db->query($sql);
        
        if(!$query)
        {
            $e = $this->db->error();   
		throw new Exception('Erro na Pesquisa: '.$e['message']);
        }
        
        return $query->result_object();
        
        
    }
	
    
     protected function _filter($campo, $valor = null, $int = null)
    {
      
        if(is_array($valor) && count($valor) > 0)
        {
            $this->db->where_in($campo,$valor);
        }
        else
        {
            if($int){
                
               if($valor != 0){
                    if($valor != null)
                         $this->db->where($campo, ((int)$valor) );
                }
                
            }else{
                if(!empty($valor) && $valor != null)
                     $this->db->where($campo, $valor );
            }
        }
       
    }
    
    protected function _filterLike($campo, $valor = null)
    {
       
            if(!empty($valor) && $valor != null)
                $this->db->like( $campo, $valor );
        
    }
    
    public function _rawQueryUpdate($sql){
        
        $query = $this->db->query($sql);
        
        if(!$query)
        {
            $e = $this->db->error();   
		throw new Exception('Erro na Pesquisa: '.$e['message']);
        }
        
        
    }
    
    
      public function _updateValorTotalCampo($campo, $acao='+', $valor, $where, $whereValue){
            
            $sql = "UPDATE ".$this->table." "
                    . "SET $campo = ($campo $acao=$valor) "
                    . "WHERE $where = $whereValue";
            
            $this->_rawQueryUpdate($sql);
            
        }
	
	
	
}
