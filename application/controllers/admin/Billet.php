<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Billet extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (!$this->rbac->hasPrivilege('billet_module', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Boleto em Lote');
        $this->session->set_userdata('sub_menu', 'billet');
        $data['title'] = 'Boleto em lote';
        $data['title_list'] = 'Boleto em lotes';

        $this->load->view('layout/header', $data);
        $this->load->view('admin/billet/index', $data);
        $this->load->view('layout/footer', $data);
    }


}