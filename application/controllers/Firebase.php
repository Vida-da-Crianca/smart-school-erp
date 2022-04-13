<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Firebase extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model(array('firebase_model'));
        $this->load->library(array('Auth'));
    }

    // Retorna o script para o lado do cliente
    public function user_firebase_script(){
        $this->load->view("firebase/notificacao");
    }

    // Salvar o token.
    public function ajax_salvar_token(){

        if($this->session->userdata('student') || $this->session->userdata('admin')){
            if($this->input->post('token')){
                $this->firebase_model->add_device_token($this->input->post('token'));
                echo json_encode(['success' => true]);
                return;
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('erro' => 'Unauthorized.')));
        return;
    }
}


?>