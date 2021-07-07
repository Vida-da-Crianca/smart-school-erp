<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_view')) {
            access_denied();
        }
    }
    
    public function lancados(){
        try{
            
            $this->extractPostFilters();
            
            $data['results'] = $this->orcamento_item_model->getAll($this->post_filters);
            //$this->lastQuery();
            
            $data['uuid'] = $this->input->post('uuid');
            
            $this->load->view('admin/orcamento/itens-lancados',$data);
            
        } catch (\Exception $e){
            echo 'Erro: '.$e->getMessage();
        }
    }

    public function add(){
        if($this->checkAjaxSubmit()){
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_model->get((int) $this->input->post('idOrcamento'));
                
                $itemJson = json_decode($this->input->post('item'));
                
                if(!isset($itemJson->id) || !isset($itemJson->tipo) || !isset($itemJson->valor) || !isset($itemJson->descricao)|| !isset($itemJson->parcelaEscolar)){
                    throw new Exception('Item Inválido! Verifique!');
                }
                
                if((float)$itemJson->valor <= 0){
                    throw new Exception('Valor unitário do item não pode ser R$ 0,00');
                }
                
                $quantidade = (int) $this->input->post('quantidade');
                if($quantidade<=0){
                    throw new Exception('Quantidade Não pode ser 0.');
                }
                $valorItem = $quantidade * (float) $itemJson->valor;
                
                $desconto = $this->parseFloat($this->input->post('desconto'));
                if ($desconto < 0) { 
                    throw new Exception("Valor do Desconto Inválido! Verifique!");
                }
                $descontoTipo = (int) $this->input->post('descontoTipo');
                if(in_array($descontoTipo, [1,2])){
                    throw new Exception("Tipo de Desconto Inválido! Verifique!");
                }
                
                if($descontoTipo == 1){
                    $valorDesconto = ( ($itemJson->valor * $desconto) / 100 );
                }else{
                    $valorDesconto = $desconto;
                }
                $valorFinal = $valorItem - $valorDesconto;
                if($valorFinal < 0){
                    throw new Exception("Valor Total do Item Inválido!");
                }
                
                $this->orcamento_item_model->idOrcamento = $this->orcamento_model->idOrcamento;
                $this->orcamento_item_model->tipo = (int) $itemJson->tipo;
                $this->orcamento_item_model->fee_groups_feetype_id = $this->orcamento_item_model->tipo == 1 ? $itemJson->id : 0;
                $this->orcamento_item_model->item_stock_id = ($this->orcamento_item_model->tipo == 2) ? $itemJson->id : 0;
                $this->orcamento_item_model->valorUnitario = (float)$itemJson->valor;
                $this->orcamento_item_model->quantidade = $quantidade;
                $this->orcamento_item_model->valorItem = $valorItem;
                $this->orcamento_item_model->descontoTipo = $descontoTipo;
                $this->orcamento_item_model->descontoValor = $desconto;
                $this->orcamento_item_model->valorFinal = $valorFinal;
                $this->orcamento_item_model->descricao = $itemJson->descricao;
                $this->orcamento_item_model->diaVencimento = (int) $this->input->post('diaVencimento');
                $this->orcamento_item_model->parcelaEscolar = (int) $itemJson->parcelaEscolar;
                
                $this->orcamento_item_model->add();
                
                $this->orcamento_model->atualizarTotais($this->orcamento_model->idOrcamento);
                
                $this->modelTransEnd();
                
                $this->resp_status  =true;
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
        }
    }

    public function delete(){
       if($this->checkAjaxSubmit()){
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_item_model->get((int) $this->input->post('id')); 
                $this->orcamento_model->get($this->orcamento_item_model->idOrcamento);
                
                $this->orcamento_item_model->_delete('idOrcamentoitem', $this->orcamento_item_model->idOrcamentoItem);
                
                $this->orcamento_model->atualizarTotais($this->orcamento_model->idOrcamento);
                
                $this->modelTransEnd();
                
                $this->resp_status  =true;
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
        }
    }
}