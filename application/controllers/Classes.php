<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classes extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (!$this->rbac->hasPrivilege('class', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'classes/index');
        $data['title'] = 'Add Class';
        $data['title_list'] = 'Class List';

        $this->form_validation->set_rules(
                'class', $this->lang->line('class'), array(
            'required',
            array('class_exists', array($this->class_model, 'class_exists'))
                )
        );
        $this->form_validation->set_rules('sections[]', $this->lang->line('section'), 'trim|required|xss_clean');

        /*$this->form_validation->set_rules(
                'limit', 'Limite de Alunos', 'trim|greater_than[0]');*/
        
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            
            
            
            $sectionsOk = true;
            
            $sections = $this->input->post('sections');
            $sectionsToSave = [];
            if(!is_array($sections)|| count($sections)<=0){
               $sectionsOk = false;
               $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Marque Pelo Menos 1 Período!</div>');
            }else{
                foreach ($sections as $section){
                    $limit = (int) $this->input->post('limit_'.$section);
                    if($limit<=0){
                        $sectionsOk = false;
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Limite de Alunos Inválida!</div>');
                        break;
                    }
                    $sectionsToSave[] = ['value'=>$section,'limit'=>(int) $limit];
                }
                
            }
            
            if($sectionsOk){
                $class = $this->input->post('class');
                $class_array = array(
                    'class' => $this->input->post('class'),
                    'limit' => (int) $this->input->post('limit')
                );

                $this->classsection_model->add($class_array, $sectionsToSave);
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('success_message').'</div>');
                redirect('classes');
            }
        }
        $vehicle_result = $this->section_model->get();
        $data['vehiclelist'] = $vehicle_result;

        $vehroute_result = $this->classsection_model->getByID();

        $data['vehroutelist'] = $vehroute_result;

        $this->load->view('layout/header', $data);
        $this->load->view('class/classList', $data);
        $this->load->view('layout/footer', $data);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('class', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->class_model->remove($id);
        redirect('classes');
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('class', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'classes/index');
        $data['title'] = 'Edit Class';
        $data['id'] = $id;
        $vehroute = $this->classsection_model->getByID($id);
        $data['vehroute'] = $vehroute;
        $data['title_list'] = 'Fees Master List';

        $this->form_validation->set_rules(
                'class', $this->lang->line('class'), array(
            'required',
            array('class_exists', array($this->class_model, 'class_exists'))
                )
        );
        $this->form_validation->set_rules('sections[]', $this->lang->line('sections'), 'trim|required|xss_clean');
        

        if ($this->form_validation->run() == FALSE) {
            $vehicle_result = $this->section_model->get();
            $data['vehiclelist'] = $vehicle_result;
            $routeList = $this->route_model->get();
            $data['routelist'] = $routeList;
            $vehroute_result = $this->classsection_model->getByID();

            $data['vehroutelist'] = $vehroute_result;
            $this->load->view('layout/header', $data);
            $this->load->view('class/classEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $sectionsOk = true;
            $sections = $this->input->post('sections');
            $prev_sections = $this->input->post('prev_sections');
            $route_id = $this->input->post('route_id');
            $class_id = $this->input->post('pre_class_id');
            
            $sectionsToSave = [];
            if(!is_array($sections)|| count($sections)<=0){
               $sectionsOk = false;
               $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Marque Pelo Menos 1 Período!</div>');
            }else{
                foreach ($sections as $section){
                    $limit = (int) $this->input->post('limit_'.$section);
                    if($limit<=0){
                        $sectionsOk = false;
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Limite de Alunos Inválida!</div>');
                        break;
                    }
                    $sectionsToSave[] = ['value'=>$section,'limit'=>(int) $limit];
                }
                
            }
            
            if($sectionsOk){
            
                    if (!isset($prev_sections)) {
                        $prev_sections = array();
                    }
                    $add_result = array_diff($sections, $prev_sections);
                    $delete_result = array_diff($prev_sections, $sections);

                    if (!empty($add_result)) {
                        $vehicle_batch_array = array();
                        $class_array = array(
                            'id' => $class_id,
                            'class' => $this->input->post('class'),
                             'limit' => (int) $this->input->post('limit')
                        );
                        foreach ($add_result as $vec_add_key => $vec_add_value) {

                            $vehicle_batch_array[] = ['value'=>$vec_add_value,'limit'=>(int) $this->input->post('limit_'.$vec_add_value)];
                        }
                        $this->classsection_model->add($class_array, $vehicle_batch_array);
                    } else {
                        $class_array = array(
                            'id' => $class_id,
                            'class' => $this->input->post('class'),
                            'limit' => (int) $this->input->post('limit')
                        );
                        $this->classsection_model->update($class_array);
                    }
                    
                    //mesmo tendo um arrray de add novos
                    //temos que fazer o processo para os ja relacionados
                    //pois pode ter sido alterado o limite de alunos
                    $class_array = array(
                        'id' => $class_id,
                        'class' => $this->input->post('class'),
                        'limit' => (int) $this->input->post('limit')
                    );
                    $vehicle_batch_array = [];
                    foreach ($sections as $vec_add_value) {

                        $vehicle_batch_array[] = ['value'=>$vec_add_value,'limit'=>(int) $this->input->post('limit_'.$vec_add_value)];
                    }
                   
                    $this->classsection_model->add($class_array, $vehicle_batch_array);

                    if (!empty($delete_result)) {
                        $classsection_delete_array = array();
                        foreach ($delete_result as $vec_delete_key => $vec_delete_value) {

                            $classsection_delete_array[] = $vec_delete_value;
                        }

                        $this->classsection_model->remove($class_id, $classsection_delete_array);
                    }

                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">'.$this->lang->line('update_message').'</div>');
                    redirect('classes/index');
            }
        }
    }

    public function get_section($id){
        $data['sections']=$this->class_model->get_section($id);
        $this->load->view('class/_section_list',$data);


    }

}

?>