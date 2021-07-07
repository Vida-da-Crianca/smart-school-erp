<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
// use mikehaertl\wkhtmlto\Pdf;
use Dompdf\Dompdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Orcamento extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->sch_setting_detail = $this->setting_model->getSetting();
        
        $this->load->model('source_model');
    }

    function index()
    {
        if (!$this->rbac->hasPrivilege('fees_type', 'can_view')) {
            access_denied();
        }
        
        $data['title'] = 'Orçamento';
        $data['title_list'] = 'Orçamentos Lista';
        
         $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'student/orcamento');
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/orcamento/index', $data);
        $this->load->view('layout/footer', $data);
    }
    
    public function lancados(){
        try{
            
            $this->extractPostFilters();
            //$this->extractFiltrosTipoData();
            
            if(!empty($this->post_filters['data1']) && !empty($this->post_filters['data2'])){
                if((int)$this->post_filters['tipoData'] == 1){
                    $this->post_filters['data1'] = $this->formatarData($this->post_filters['data1']);
                    $this->post_filters['data2'] = $this->formatarData($this->post_filters['data2']);
                }else{
                    $this->post_filters['dataNascimento1'] = $this->formatarData($this->post_filters['data1']);
                    $this->post_filters['dataNascimento2'] = $this->formatarData($this->post_filters['data2']);
                    unset($this->post_filters['data1']);
                    unset($this->post_filters['data2']);
                }
            }
            
            $data['results'] = $this->orcamento_model->getAll($this->post_filters);
            //$this->lastQuery();
            
            $data['uuid'] = $this->input->post('uuid');
           
            
            $this->load->view('admin/orcamento/lancados',$data);
            
        } catch (\Exception $e){
            echo 'Erro: '.$e->getMessage();
        }
    }
    
    public function add(){
        
        $data['action'] = $this->input->post('action');
        $id = (int) $this->input->post('id');
        
        if($this->checkAjaxSubmit()){
            
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_model->get((int) $this->input->post('codigo'));
                
                $this->form_validation->set_rules('alunoNome' ,'Nome do Aluno','trim|required');
                $this->form_validation->set_rules('alunoSobrenome','Sobrenome do Aluno', 'trim|required');
                $this->form_validation->set_rules('genero','Sexo do Aluno',  'trim|required|in_list[M,F]');
                $this->form_validation->set_rules('dataNascimento','Data de Nascimento',  'trim|required|exact_length[10]');
                $this->form_validation->set_rules('alunoNome','Nome do Aluno',  'trim|required');
                
                $paiNome = trim(ucfirst($this->input->post('paiNome')));
                $maeNome = trim(ucfirst($this->input->post('maeNome')));
                
                if(empty($paiNome) && empty($maeNome)){
                    throw new Exception('Informe o nome do Pai ou da Mãe!');
                }
                
                if (!empty($maeNome)) {
                    //$this->form_validation->set_rules('maeNome','Nome da Mãe',  'trim|required');
                    $this->form_validation->set_rules('maeTelefone','Celular da Mãe',  'trim|required|exact_length[16]');
                    $this->form_validation->set_rules('maeOcupacao','Trabalho/Ocupação da Mãe',  'trim|required');
                }
                if (!empty($paiNome)) {
                    //$this->form_validation->set_rules('paiNome','Nome do Pai',  'trim|required');
                    $this->form_validation->set_rules('paiTelefone','Celular do Pai',  'trim|required|exact_length[16]');
                    $this->form_validation->set_rules('paiOcupacao','Trabalho/Ocupação do Pai',  'trim|required');
                }
                
                $this->form_validation->set_rules('responsavelFinanceiro','Responsável Financeiro',  'trim|required|in_list[Pai,Mãe,Outro]');
                $this->form_validation->set_rules('responsavelFinanceiroNome','Nome do Responsável Financeiro',  'trim|required');
                $this->form_validation->set_rules('responsavelFinanceiroCPF','CPF do Responsável Financeiro',  'trim|required|exact_length[14]');
                $this->form_validation->set_rules('responsavelFinanceiroRelacao','Relação de Paretensco',  'trim|required');
                $this->form_validation->set_rules('responsavelFinanceiroTelefone','Celular do Responsável Financeiro',  'trim|required|exact_length[16]');
                $this->form_validation->set_rules('responsavelFinanceiroEmail','Email do Responsável Financeiro',  'trim|required|valid_email');
                $this->form_validation->set_rules('responsavelFinanceiroOcupacao','Trabalho/Ocupação do Responsável Financeiro',  'trim|required');
                
                $this->form_validation->set_rules('cep', 'CEP', 'trim|required|exact_length[9]');
                $this->form_validation->set_rules('endereco', 'Endereço', 'trim|required');
                $this->form_validation->set_rules('numero', 'Número', 'trim|required');
                $this->form_validation->set_rules('bairro', 'Bairro', 'trim|required');
                $this->form_validation->set_rules('cidade', 'Cidade', 'trim|required');
                $this->form_validation->set_rules('uf', 'Estado', 'trim|required');
                
                $this->checkFormValidationErrors();
                
                $class_id = (int) $this->input->post('class_id');
                $section_id = (int) $this->input->post('section_id');
                $source_id = (int) $this->input->post('source_id');
                if($class_id<=0){
                    throw new Exception('Turma Não Informada!');
                }
                if($section_id<=0){
                    throw new Exception('Período Não Informado!');
                }
                if($source_id<=0){
                    throw new Exception('Origem Não Informada!');
                }
                
                $itens = $this->orcamento_item_model->getAll(['idOrcamento'=>$this->orcamento_model->idOrcamento]);
                if(count($itens)<=0){
                    throw new Exception('Nenhum Item Lançado no Orçamento! Verifique!');
                }
                
                $dataNascimento = $this->tools->formatarData($this->input->post('dataNascimento'), 'br', 'us');
                if (!$this->tools->validateDate($dataNascimento, '-')) {
                    throw new Exception('Data de Nascimento Inválida!');
                }
                $dtNascimento = new DateTime($dataNascimento);
                $hoje = new DateTime();
                if($dataNascimento>$hoje){
                    throw new Exception('Data de Nascimento Inválida.');
                }
                
                $cpf = trim($this->input->post('responsavelFinanceiroCPF'));
                if(!$this->CPFValido($cpf)){
                    throw new Exception('CPF Inválido!');
                }
                
                //throw new Exception('ok!');
                
                $config = $this->db->select('session_id')->from('sch_settings')->get()->result();
                $session_id_atual = count($config)> 0 ? $config[0]->session_id : 0;
                
                //Tudo OK! gravar orcamento
                $this->orcamento_model->alunoNome = trim(ucfirst($this->input->post('alunoNome')));
                $this->orcamento_model->alunoSobrenome = trim(ucfirst($this->input->post('alunoSobrenome')));
                $this->orcamento_model->genero = trim(ucfirst($this->input->post('genero')));
                $this->orcamento_model->dataNascimento = $dataNascimento;
                $this->orcamento_model->class_id = $class_id;
                $this->orcamento_model->section_id = $section_id;
                $this->orcamento_model->session_id = $session_id_atual;
                $this->orcamento_model->maeNome = trim(ucfirst($this->input->post('maeNome')));
                $this->orcamento_model->maeTelefone = trim(ucfirst($this->input->post('maeTelefone')));
                $this->orcamento_model->maeOcupacao = trim(ucfirst($this->input->post('maeOcupacao')));
                $this->orcamento_model->paiNome = trim(ucfirst($this->input->post('paiNome')));
                $this->orcamento_model->paiTelefone = trim(ucfirst($this->input->post('paiTelefone')));
                $this->orcamento_model->paiOcupacao = trim(ucfirst($this->input->post('paiOcupacao')));
                $this->orcamento_model->responsavelFinanceiro = trim(ucfirst($this->input->post('responsavelFinanceiro')));
                $this->orcamento_model->responsavelFinanceiroNome = trim(ucfirst($this->input->post('responsavelFinanceiroNome')));
                $this->orcamento_model->responsavelFinanceiroCPF = $cpf;
                $this->orcamento_model->responsavelFinanceiroRelacao = trim(($this->input->post('responsavelFinanceiroRelacao')));
                $this->orcamento_model->responsavelFinanceiroTelefone = trim(ucfirst($this->input->post('responsavelFinanceiroTelefone')));
                $this->orcamento_model->responsavelFinanceiroEmail = trim(strtolower($this->input->post('responsavelFinanceiroEmail')));
                $this->orcamento_model->responsavelFinanceiroOcupacao = trim(ucfirst($this->input->post('responsavelFinanceiroOcupacao')));
                $this->orcamento_model->cep = $this->soNumeros(trim(($this->input->post('cep'))));
                $this->orcamento_model->endereco = trim(ucfirst($this->input->post('endereco')));
                $this->orcamento_model->numero = trim(ucfirst($this->input->post('numero')));
                $this->orcamento_model->complemento = trim(ucfirst($this->input->post('complemento')));
                $this->orcamento_model->bairro = trim(ucfirst($this->input->post('bairro')));
                $this->orcamento_model->uf = trim(strtoupper($this->input->post('uf')));
                $this->orcamento_model->cidade = trim(ucfirst($this->input->post('cidade')));
                $this->orcamento_model->observacoes = trim(($this->input->post('observacoes')));
                $this->orcamento_model->dataOrcamento = date('Y-m-d');
                $this->orcamento_model->status = 1;
                $this->orcamento_model->source_id = $source_id;
               
                
                $this->orcamento_model->_update('idOrcamento', $this->orcamento_model->idOrcamento, $this->_classToArray($this->orcamento_model, ['idOrcamento','session_id','dataOrcamento','horaOrcamento','numeroParcelas','staff_id','numeroParcelasEscolares','geradoMatricula']));
                
                $this->modelTransEnd();
                
                $textoWhats = '';
                $textoWhats .= 'Olá segue o acesso ao orçamento solicitado:%0a';
                $textoWhats .= '%0a';
                $textoWhats .= base_url('site/orcamento/').$this->orcamento_model->token;
                $textoWhats .= '%0a';
                $textoWhats .= '%0aPara mais informações, favor entrar em contato conosco!';
                            
                
                $this->resp_status  =true;
                $this->resp_msg = ['textoWhats'=>$textoWhats,'numero'=>'55'.$this->soNumeros($this->orcamento_model->responsavelFinanceiroTelefone)];
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
            
            
        }else{
            try{
                
                if($data['action'] == 'add'){
                    //Quando for cadastro de um novo orcamento, criamos um novo orcamento vazio
                    $this->orcamento_model = new Orcamento_model();
                    $this->orcamento_model->dataOrcamento = date('Y-m-d');
                    $this->orcamento_model->horaOrcamento = date('H:i:s');
                    $this->orcamento_model->dataValidade = date('Y-m-d');
                    $this->orcamento_model->dataNascimento = date('Y-m-d');
                    $this->orcamento_model->status = 0;
                    $this->orcamento_model->numeroParcelas = 1;
                    $this->orcamento_model->valorParcelaEscolar = 0;
                    $this->orcamento_model->responsavelFinanceiro = 'Outro';
                    $this->orcamento_model->token = trim(sha1(uniqid()));
                    $CI = & get_instance();
                    $this->orcamento_model->staff_id =  (int) ($CI->session->userdata('admin')['id']);
                    $this->orcamento_model->add();
                    $this->orcamento_model->idOrcamento = (int) $this->db->insert_id(); 
                    $this->orcamento_model->dataNascimento = '';
                }else{
                    //Quando for alteracao, carregamos o orcamento ja cadastrado
                    $this->orcamento_model->get($id);
                }
                
                $data['orcamento'] = $this->orcamento_model;
                $data['estados'] = $this->estados;
                
                $data['sources'] = [];
                $res =  $this->source_model->source_list();
                foreach ($res as $row){
                    $data['sources'][$row['id']] = $row['source'];
                }
               // $data['sources'] = $this->source_model->source_list();
                
                $this->load->view('admin/orcamento/add', $data);
                
            } catch (Exception $e){
               echo 'Ocorreu um erro: '. $e->getMessage(); 
            }
        }
    }
    
    
    public function output($token=null){
       try{
           
           $this->orcamento_model->getByToken(trim($token));
           $data['orcamento'] = $this->orcamento_model;
           $data['itens'] = $this->orcamento_item_model->getAll(['idOrcamento'=> $this->orcamento_model->idOrcamento]);
           
            $img = (FCPATH.'uploads/school_content/logo/'.$this->sch_setting_detail->admin_logo);
            $type = pathinfo($img, PATHINFO_EXTENSION);
            $datax = file_get_contents($img);
            
            $class = $this->class_model->get($this->orcamento_model->class_id);
            $section = $this->section_model->get($this->orcamento_model->section_id);
            $staff = $this->staff_model->get($this->orcamento_model->staff_id);
           
           $data['escola'] = [
              /* 'nome' => $this->sch_setting_detail->name,
               'email' => $this->sch_setting_detail->email,
               'telefone' => $this->sch_setting_detail->phone,
               'endereco' => $this->sch_setting_detail->address,
               'logo' => 'data:image/' . $type . ';base64,' . base64_encode($datax),*/
               'turma'=> isset($class['class']) ? $class['class'] : '---',
               'periodo'=> isset($section['section']) ? $section['section'] : '---',
               'usuario'=> isset($staff['name']) ? $staff['name'].' '.$staff['surname'] : '---'
           ];
          
           
           $page = $this->load->view('admin/orcamento/print', $data,true);
          
          // echo $page;
          // die('');
           
           $html2pdf = new Html2Pdf('P', 'A4', 'pt', true, 'UTF-8', 5);
            // $html2pdf->setDefaultFont('dejavusans');
           $html2pdf->pdf->SetDisplayMode('real');
            $html2pdf->writeHTML($page);
            $html2pdf->output('Orcamento_'.$this->orcamento_model->idOrcamento.'.pdf');
            die();
           
       } catch (\Exception $e){
          echo 'Erro: '.$e->getMessage();
       }
    }

    public function enviarEmail(){
        
        if($this->checkAjaxSubmit()){
            
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_model->get((int) $this->input->post('idOrcamento'));
                
                $email = trim(strtolower($this->input->post('email')));
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    throw new Exception('Email inválido.');
                }
                
                $this->load->library('mailer');
                
                $url = base_url().'site/orcamento/'.$this->orcamento_model->token;
                $body = 'Olá! Segue orçamento solicitado: <br />';
                $body .= "<a href='$url' target='_blank'>$url</a>";
                
                if(!$this->mailer->send_mail($email,'Orçamento',$body)){
                     throw new Exception('Erro ao enviar email. Tente novamente!');
                }
                
                $this->modelTransEnd();
                
                $this->resp_status  =true;
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
            
            
        }
    }


    /*Retorna um combobox de Turmas com base na data de nascimento do aluno*/
    public function getListaTurmasPorDataNascimento(){
         try {
			
            $dataNascimento = $this->tools->formatarData($this->input->post('dataNascimento'), 'br', 'us');
            $dtNascimento = new DateTime($dataNascimento .' 00:00:00'); 
            
            $config = $this->db->select('session_id')->from('sch_settings')->get()->result();
            $datasCorte = $this->data_corte_model->getAll(['session_id'=>count($config)>0?$config[0]->session_id : 0 ]); 
            //$this->pre($dtNascimento);
            //$this->pre($datasCorte);
            $dados = array();

            foreach ($datasCorte as $row)
            {
                $dtInicial = new DateTime($row->dataInicial.' 00:00:00');
                $dtFinal = new DateTime($row->dataFinal.' 23:59:59');
                
                 //$this->pre($dtNascimento);
                 //$this->pre($dtInicial);
                 //$this->pre($dtFinal);
                
                if($dtNascimento >= $dtInicial && $dtNascimento <= $dtFinal){
                    $dados[] = array('value'=>$row->class_id,'label'=> $row->className );
                }
                
                
            }
            
            if(count($dados)<=0){
                $dados[] = array('value'=>0,'label'=> '*** NENHUMA TURMA DISPONÍVEL ***' );
            }

            echo json_encode(array('status'=>true,'results'=>$dados));			


        }
        catch (\Exception $e)
        {
            echo json_encode(array('status'=>false));
	}
    }
    
     public function getListaPeriodosPorTurma(){
         try {
			
            $class_id = (int) $this->input->post('class_id');
           
            $dados = array();

            $res = $this->section_model->getClassBySectionAll($class_id);
            $dados[] = array('value'=>0,'label'=> 'Selecione o Período' );
            
            foreach ($res as $row)
            {
               $dados[] = array('value'=>$row['section_id'],'label'=> $row['section'] ); 
            }
            

            echo json_encode(array('status'=>true,'results'=>$dados));			


        }
        catch (\Exception $e)
        {
            echo json_encode(array('status'=>false));
	}
    }
    
    /***
     * Retorna uma lista de JSONs com os Feetypes por turma + os STOCKS para todas turmas
     */
    public function getListaItensParaOrcamentoPorTurma(){
         try {
			
            $class_id = (int) $this->input->post('class_id');
           
            $dados = array();

            //Feetypes
            $config = $this->db->select('session_id')->from('sch_settings')->get()->result();
            $session_id_atual = count($config)> 0 ? $config[0]->session_id : 0;
            
            $sql = "SELECT 
                        feetype.code AS feetypeCode,
                        feetype.type AS feetypeType,
                        IFNULL(feetype.parcelaEscolar,0) AS parcelaEscolar,
                        fee_groups_feetype.amount as amount,
                        fee_groups_feetype.id AS id 
                        FROM 
                        fee_groups_feetype 
                        JOIN feetype ON feetype.id = fee_groups_feetype.feetype_id 
                        JOIN fee_groups ON fee_groups.id = fee_groups_feetype.fee_groups_id 
                        WHERE fee_groups.class_id = $class_id  
                        AND fee_groups_feetype.session_id = $session_id_atual "
                    . "ORDER BY feetype.type ASC";
            
            $res = $this->db->query($sql)->result();
           
            foreach ($res as $row)
            {
               $dados[] = array('value'=>
                   htmlspecialchars(json_encode(array(
                   'tipo' => 1,
                   'id' => $row->id,//fee_groups_feetype.id,
                   'valor' => (float) $row->amount,
                   'descricao' => $row->feetypeType,
                   'parcelaEscolar' => (int) $row->parcelaEscolar,    
               ), JSON_HEX_QUOT | JSON_HEX_TAG)),
                  'label'=> $row->feetypeType . ' | R$ '. number_format($row->amount,2,',','.') ); 
            }
            
            //ItemStock
            $item_result = $this->itemstock_model->get();
            foreach ($item_result as $row)
            {
               $dados[] = array('value'=>
                   htmlspecialchars(json_encode(array(
                   'tipo' => 2,
                   'id' => $row['id'],//item_stock.id,
                   'valor' => (float) $row['sale_price'],
                   'descricao' =>  $row['name'],
                   'parcelaEscolar' => 0, 
               ), JSON_HEX_QUOT | JSON_HEX_TAG)),
                  'label'=> $row['name'] . ' | R$ '. number_format($row['sale_price'],2,',','.') ); 
            }
            
            usort($dados, [$this,'compByNome']);
            
            echo json_encode(array('status'=>true,'results'=>$dados));			


        }
        catch (\Exception $e)
        {
            echo json_encode(array('status'=>false));
	}
    }
    
    private function compByNome($a, $b){
        return $a['label'] > $b['label'];
    }


    public function getTotais(){
            try{
                
                $this->orcamento_model->get((int) $this->input->post('idOrcamento'));
                
                $data['orcamento'] = $this->orcamento_model;
                //$data['estados'] = $this->estados;
                
                $this->load->view('admin/orcamento/totais', $data);
                
            } catch (Exception $e){
               echo 'Ocorreu um erro: '. $e->getMessage(); 
            }
    }
    
     public function getParcelas(){
            try{
                
                $this->orcamento_model->get((int) $this->input->post('idOrcamento'));
                
                $data['orcamento'] = $this->orcamento_model;
                //$data['estados'] = $this->estados;
                
                $numeroParcelas = (int) $this->input->post('numeroParcelas');
                $this->orcamento_model->_update('idOrcamento', $this->orcamento_model->idOrcamento, ['numeroParcelas'=>$numeroParcelas]);
                
                $valorPorParcela = $this->orcamento_model->valorFinal / $numeroParcelas;
                
                echo '<br /><div class="alert text-center" style="font-size:1.2em;">'.$numeroParcelas ." Parcelas de R$ ".number_format($valorPorParcela,2,',','.'). ' cada.</div>'; 
                
                //$this->load->view('admin/orcamento/parcelas', $data);
                
            } catch (Exception $e){
               echo 'Ocorreu um erro: '. $e->getMessage(); 
            }
    }
    public function getParcelasEscolar(){
            try{
                
                $this->orcamento_model->get((int) $this->input->post('idOrcamento'));
                
                $data['orcamento'] = $this->orcamento_model;
                //$data['estados'] = $this->estados;
                
                $numeroParcelas = (int) $this->input->post('numeroParcelas');
                $this->orcamento_model->_update('idOrcamento', $this->orcamento_model->idOrcamento, ['numeroParcelasEscolares'=>$numeroParcelas]);
                if($numeroParcelas > 0){
                    $valorPorParcela = $this->orcamento_model->valorFinalParcelaEscolar / $numeroParcelas;

                    echo '<br /><div class="alert text-center" style="font-size:1.2em;">'.$numeroParcelas ." Parcelas de R$ ".number_format($valorPorParcela,2,',','.'). ' cada.</div>'; 
                }
                else{
                    echo '';
                }
                //$this->load->view('admin/orcamento/parcelas', $data);
                
            } catch (Exception $e){
               echo 'Ocorreu um erro: '. $e->getMessage(); 
            }
    }
    
     public function delete(){
       if($this->checkAjaxSubmit()){
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_model->get((int) $this->input->post('id')); 
               // $this->orcamento_model->get($this->orcamento_item_model->idOrcamento);
                
                $this->orcamento_item_model->_delete('idOrcamento', $this->orcamento_model->idOrcamento);
                $this->orcamento_model->_delete('idOrcamento', $this->orcamento_model->idOrcamento);
                
                
                //$this->orcamento_model->atualizarTotais($this->orcamento_model->idOrcamento);
                
                $this->modelTransEnd();
                
                $this->resp_status  =true;
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
        }
    }
    
    public function descontoLote(){
       if($this->checkAjaxSubmit()){
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_model->get((int) $this->input->post('id')); 
               // $this->orcamento_model->get($this->orcamento_item_model->idOrcamento);
                
                $this->orcamento_item_model->_delete('idOrcamento', $this->orcamento_model->idOrcamento);
                $this->orcamento_model->_delete('idOrcamento', $this->orcamento_model->idOrcamento);
                
                
                //$this->orcamento_model->atualizarTotais($this->orcamento_model->idOrcamento);
                
                $this->modelTransEnd();
                
                $this->resp_status  =true;
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
        }else{
            try{
                
                 $this->orcamento_model->get((int) $this->input->post('id')); 
                
                
            } catch (\Exception $e){
                echo 'Erro: '. $e->getMessage();
            }
        }
    }
    
    public function gerarMatricula(){
        if($this->checkAjaxSubmit()){
            try{
                
                $this->modelTransStart();
                
                $this->orcamento_model->get((int) $this->input->post('idOrcamento')); 
                
                if($this->orcamento_model->geradoMatricula == 1){
                    throw new Exception('Já foi gerado uma matrícula para esse orçamento');
                }
                
                
                $class_id   = $this->orcamento_model->class_id;
                $section_id =  $this->orcamento_model->section_id;

                //carregar o class_section_id
                $res = $this->db->where('class_id',$class_id)
                            ->where('section_id',$section_id)
                            ->get('class_sections')->result();
                    
                $class_section_id = (count($res)>0? $res[0]->id : 0);
                
                
                 $data = array(
                        'roll_no'             => '',
                        'mobileno'            => '',
                        'email'               => '',
                        'firstname'           => $this->orcamento_model->alunoNome,
                        'lastname'            => $this->orcamento_model->alunoSobrenome,
                        'mobileno'            => '',
                        'class_section_id'    => $class_section_id,//$this->input->post('section_id'),
                        'guardian_is'         => $this->orcamento_model->responsavelFinanceiro == 'Pai' ? 'father' : ($this->orcamento_model->responsavelFinanceiro == 'Mãe' ? 'mother' : 'other'),
                        'dob'                 => $this->orcamento_model->dataNascimento, //date('Y-m-d', strtotime($this->input->post('dob'))),
                        'current_address'     => '',
                        'permanent_address'   => '',
                        'father_name'         => $this->orcamento_model->paiNome,
                        'father_phone'        => $this->orcamento_model->paiTelefone,
                        'father_occupation'   => $this->orcamento_model->paiOcupacao,
                        'mother_name'         => $this->orcamento_model->maeNome,
                        'mother_phone'        => $this->orcamento_model->maeTelefone,
                        'mother_occupation'   => $this->orcamento_model->maeOcupacao,
			'guardian_document'   => $this->soNumeros($this->orcamento_model->responsavelFinanceiroCPF),
			'guardian_occupation' => $this->orcamento_model->responsavelFinanceiroOcupacao,
                        'guardian_email'      => $this->orcamento_model->responsavelFinanceiroEmail,
                        'gender'              => $this->orcamento_model->genero == 'M' ? 'Male' : 'Female',
                        'guardian_name'       => $this->orcamento_model->responsavelFinanceiroNome,
                        'guardian_relation'   => $this->orcamento_model->responsavelFinanceiroRelacao,
                        'guardian_phone'      => $this->orcamento_model->responsavelFinanceiroTelefone,
                        'admission_date'      => date('Y/m/d'),
                        'measurement_date'    => date('Y/m/d'),
						
                        'guardian_postal_code'    => $this->soNumeros($this->orcamento_model->cep),
                        'guardian_address'    => $this->orcamento_model->endereco,
                        'guardian_address_number'    => $this->orcamento_model->numero,
                        'guardian_district'    => $this->orcamento_model->bairro,
                        'guardian_city'    => $this->orcamento_model->cidade,
                        'guardian_state'    => $this->orcamento_model->uf,
						
                    );
                    $insert_id = $this->onlinestudent_model->add($data);
                
                
               // $this->orcamento_model->get($this->orcamento_item_model->idOrcamento);
                
                //$this->orcamento_item_model->_delete('idOrcamento', $this->orcamento_model->idOrcamento);
                $this->orcamento_model->_update('idOrcamento', $this->orcamento_model->idOrcamento,['geradoMatricula'=>1]);
                
                
                //$this->orcamento_model->atualizarTotais($this->orcamento_model->idOrcamento);
                
                $this->modelTransEnd();
                
                $this->resp_status  =true;
                $this->resp_msg = $insert_id;
                
            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
            }
            
            $this->showJSONResp();
        }
    }
    
    
}