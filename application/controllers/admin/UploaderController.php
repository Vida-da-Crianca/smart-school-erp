<?php

use Application\Core\JsonResponse;

class UploaderController extends CI_Controller {







    public function __construct()
    {  
           parent::__construct();

        
    }


    public function index(){

        $this->load->helper(array('form', 'url'));
        $config['upload_path']          =  ROOT_FOLDER.'/uploads/documents/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             =  1024;
        $config['encrypt_name']  = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('file'))
        {
            return new JsonResponse(['errors' =>  $this->upload->display_errors(). $config['upload_path'] , ], 422);
        }

        
        return new JsonResponse(['url' => sprintf('%s/uploads/documents/%s',base_url(),  $this->upload->data('file_name'))]);
    }


    
}