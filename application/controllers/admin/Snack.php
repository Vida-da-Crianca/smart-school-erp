<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Snack extends Admin_Controller
{

    public $sch_setting_detail = array();

    public function __construct()
    {
        parent::__construct();

        $this->config->load('app-config');
        $this->load->model('snack_model');
        $this->role;
    }

    public function index()
    {

        if (!$this->rbac->hasPrivilege('snack_generate', 'can_view')) {
            access_denied();
        }
        $data = array();
        $this->session->set_userdata('top_menu', 'snacks');
        $this->session->set_userdata('sub_menu', 'admin/snack');

        $this->load->model('eloquent/SnackEloquent');

        $data['snacks'] =  SnackEloquent::orderBy('name', 'asc')->get();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/snack/snack_list', $data);
        $this->load->view('layout/footer', $data);
    }

    public function create()
    {
        if (!$this->rbac->hasPrivilege('snack_generate', 'can_add')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'snacks');
        $this->session->set_userdata('sub_menu', 'admin/snack/create');
        $data = array();
        $data['snack'] = (object)['id' => null, 'name' => null, 'code' => null];
        $this->load->view('layout/header', $data);
        $this->load->view('admin/snack/snack_frm', $data);
        $this->load->view('layout/footer', $data);
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('snack_generate', 'can_add')) {
            access_denied();
        }

        $model = (object)$this->snack_model->get($id);

        $this->session->set_userdata('top_menu', 'admin/snacks');
        $data = array();
        $data['snack'] = $model;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/snack/snack_frm', $data);
        $this->load->view('layout/footer', $data);
    }


    public function store()
    {
        if (!$this->rbac->hasPrivilege('snack_generate', 'can_add')) {
            access_denied();
        }
        $data = $this->input->post();
        $this->snack_model->add($data);
        redirect('admin/snack');

    }

    public function update($id)
    {
        if (!$this->rbac->hasPrivilege('snack_generate', 'can_add')) {
            access_denied();
        }
        $data = $this->input->post();
        $this->snack_model->update($id, $data);
        redirect('admin/snack');

    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('snack_generate', 'can_delete')) {
            access_denied();
        }
        $this->snack_model->delete($id);
        redirect('admin/snack');

    }


}