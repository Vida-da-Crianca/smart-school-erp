<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_corte extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {   
         if (!$this->rbac->hasPrivilege('class', 'can_view')) {
            access_denied();
        }
        
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'data_corte/index');
        $data['title'] = 'Datas de Corte';
        $data['title_list'] = 'Datas de Corte Lista';
        
        if((int) $this->input->post('_submit') == 1){
            $this->form_validation->set_rules('session_id','Sessão','trim|required');
            $this->form_validation->set_rules('dataInicial','Data Inicial','trim|required|exact_length[10]');
            $this->form_validation->set_rules('dataFinal','Data Final','trim|required|exact_length[10]');
            $this->form_validation->set_rules('class_id','Turma','trim|required');

            if ($this->form_validation->run() == FALSE) {
                 $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">'.(validation_errors()).'</div>');
            } else {

                try{
                    $this->data_corte_model->session_id = (int) $this->input->post('session_id');
                    $this->data_corte_model->dataInicial = $this->tools->formatarData($this->input->post('dataInicial'), 'br', 'us');
                    $this->data_corte_model->dataFinal = $this->tools->formatarData($this->input->post('dataFinal'), 'br', 'us');
                    $this->data_corte_model->class_id = (int) $this->input->post('class_id');

                    $this->data_corte_model->validar();
                    $this->data_corte_model->add();

                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('success_message').'</div>');


                } catch (\Exception $e){
                   
                     $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">'.($e->getMessage()).'</div>');

                }

                //redirect('data_corte');

            }
        }
        
        $sessionList = [];
       // $this->load->model('session_model');
        $sessions = $this->session_model->getAllSession();
        foreach ($sessions as $row){
            $sessionList[$row['id']] = $row['session'];
        }
        $data['sessionList'] = $sessionList;
        
        $classList = [];
        $classes = $this->class_model->getAll();
        foreach ($classes as $row){
            $classList[$row['id']] = $row['class'];
        }
        $data['classList'] = $classList;
        
        $data['dataCorteList'] = $this->data_corte_model->getAll([]);
        
        $config = $this->db->select('session_id')->from('sch_settings')->get()->result();
        $data['session_id_atual'] = count($config)> 0 ? $config[0]->session_id : 0;
        
        $this->load->view('layout/header', $data);
        $this->load->view('admin/data_corte/dataCorteList', $data);
        $this->load->view('layout/footer', $data);
    }
    
    function delete($id) {
        if (!$this->rbac->hasPrivilege('class', 'can_delete')) {
            access_denied();
        }
        $this->data_corte_model->_delete('idDataCorte', (int)$id);
        redirect('admin/data_corte');
    }
}