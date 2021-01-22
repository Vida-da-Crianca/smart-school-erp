<?php

use Application\Core\JsonResponse;
use Application\Support\Parser;
use Spipu\Html2Pdf\Html2Pdf;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class DocumentController extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("classteacher_model");
        $this->load->model("Staff_model");
        $this->load->library('Enc_lib');

        $this->sch_setting_detail = $this->setting_model->getSetting();
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('document_generate', 'can_view')) {
            access_denied();
        }
        $data = array();
        $this->session->set_userdata('top_menu', 'documents');
        $this->session->set_userdata('sub_menu', 'admin/documents');

        $this->load->model('eloquent/Document');

        $data['documents'] =  Document::all();
        $this->load->view('layout/header', $data);
        $this->load->view('admin/document/document_list', $data);
        $this->load->view('layout/footer', $data);
    }


    public function create()
    {
        if (!$this->rbac->hasPrivilege('document_generate', 'can_add')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'documents');
        $this->session->set_userdata('sub_menu', 'admin/documents/create');
        $data = array();
        $document = (object)['id' => 0, 'title' => null, 'body' => '<b>ok</b>'];

        $data['document'] = $document;

        $this->load->model('eloquent/Document');

        $data['documents'] =  Document::all();
        $this->load->view('layout/header', $data);
        $this->load->view('admin/document/document_frm', $data);
        $this->load->view('layout/footer', $data);
    }


    public function store()
    {
        if (!$this->rbac->hasPrivilege('document_generate', 'can_add')) {
            access_denied();
        }

        $data = array();
        $this->load->model('eloquent/Document');

        $isValidate = $this->validateForm();
        if ($isValidate) {
            try {
                Document::create($this->input->post());
                return redirect('/admin/documents');
            } catch (\Exception $e) {
            }
        }
        $this->viewForm($data);
    }


    public function show($id)
    {
        if (!$this->rbac->hasPrivilege('document_generate', 'can_add')) {
            access_denied();
        }
        $data = array();

        $this->load->model('eloquent/Document');

        $data['document'] =  Document::where('id', $id)->first();
        $this->viewForm($data);
    }


    public function update($id)
    {
        if (!$this->rbac->hasPrivilege('document_generate', 'can_edit')) {
            access_denied();
        }
        $data = array();
        $this->load->model('eloquent/Document');

        $isValidate = $this->validateForm();
        if ($isValidate) {
            try {
                $document =   Document::where('id', $id)->first();
                $document->update($this->input->post());
                return redirect('/admin/documents');
            } catch (\Exception $e) {
            }
        }

        $this->viewForm($data);
    }

    public function destroy($id)
    {
      
        $this->load->model('eloquent/Document');
        $document =   Document::where('id', $id)->first();
        $document->delete();
        return new JsonResponse(['message' => 'sucess']);
    }


    public function validateForm()
    {
        $this->load->library('form_validation');
        $this->load->model('eloquent/Document');
        $this->load->config('form_validation');
        $this->form_validation->set_rules(config_item('document/create'));
        return $this->form_validation->run();
    }


    public function viewForm($data)
    {
        $this->load->view('layout/header', $data);
        $this->load->view('admin/document/document_frm', $data);
        $this->load->view('layout/footer', $data);
    }


    function preview($id, $user_id)
    {
        $this->load->model(['eloquent/Document', 'eloquent/Student_eloquent']);
        $document =   Document::where('id', $id)->first();

        $parser = new Parser();
        $page =  $parser->parse_string($document->body, Student_eloquent::where('id', $user_id)->first()->toArray());

        $html2pdf = new Html2Pdf('P', 'A4', 'pt', true, 'UTF-8', 10);
        $html2pdf->writeHTML($page);
        $html2pdf->output();
        die();
    }
}
