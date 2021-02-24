<?php

use Application\Core\JsonResponse;
use Application\Support\Parser;
use Respect\Validation\Rules\Json;
use Spipu\Html2Pdf\Html2Pdf;
use mikehaertl\wkhtmlto\Pdf;
use Illuminate\Support\Str;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;

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
        $document = (object)['id' => 0, 'title' => null, 'body' => ''];

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
                return new JsonResponse(['message' =>  'Operação realizada com sucesso !!']);
            } catch (\Exception $e) {
                return new JsonResponse(['message' =>  $e->getMessage()], 400);
            }
        }
        return new JsonResponse(['errors' =>  $this->form_validation->error_string()], 422);
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
                return new JsonResponse(['message' =>  'Operação realizada com sucesso !!']);
            } catch (\Exception $e) {
                return new JsonResponse(['message' =>  $e->getMessage()], 400);
            }
        }

        return new JsonResponse(['errors' =>  $this->form_validation->error_string()], 422);
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
        // dump($this->sch_setting_detail);
        $student =  Student_eloquent::where('id', $user_id)->with(['session' => function ($q) {
            return $q->with(['section', 'class_item'])->where('session_id', $this->sch_setting_detail->session_id);
        }])->first();
        $data = [
            'aluno_nome' => $student->fullname,
            // 'class' => $student->session->class_item,
            'aluno_turma' => sprintf(
                '%s - %s',
                $student->session->class_item->class ?? $student->session->class_item->class,
                $student->session->section->section ??  $student->session->section->section
            ),
            'aluno_email' => $student->email,
            'guardiao_nome' => $student->guardian_name,
            'guardiao_email' => $student->guardian_email,
            'guardiao_endereco' => sprintf(
                '%s, %s - %s %s-%s',
                $student->guardian_address,
                $student->guardian_address_number,
                $student->guardian_district,
                $student->guardian_city,
                $student->guardian_state,
            ),
            'guardiao_documento' => $student->guardian_document,
            'guardiao_ocupacao' => $student->guardian_ocupation,

        ];

        $data = array_merge($data, $this->getVarsTypes($student));
     
        // ($this->getVarsTypes($student));
        // exit;
        $page =  $parser->parse_string(str_replace(['{{', '}}'], ['{', '}'], $document->body), $data);
        $page = str_replace('figure', 'div', $page);
        $page = preg_replace('/(<img\b[^>])/i', '$1 style="max-width:150px; !important;" ', $page);
        // $page = strip_tags($page, '<p><a><table><th><tbody><tr><td><thead><tfoot><img><strong><br><h1><h2><h3><h4><h5><h6><p><i><em><span>');
        $page = $this->load->view('parser/pdf', ['body' => $page], true);
        // die($page);
        // return;
        // die($page);
        // $page = strip_tags($page, '<p><a><table><th><tbody><tr><td><thead><tfoot><img><strong><br><h1><h2><h3><h4><h5><h6><p><i><em><span>');


        $html2pdf = new Html2Pdf('P', 'A4', 'pt', true, 'UTF-8', 10);
        $html2pdf->writeHTML($page);
        $html2pdf->output();


        // $pdf = new Pdf();
        // $pdf->addPage($page);
        // if (!$pdf->send('report.pdf')) {
        //     die($pdf->getError());
        //     // ... handle error here
        // }
        // // echo $pdf->toString();wkhtmltopdf --version
        die();
    }


    private function getVarsTypes($student): array
    {
        if (!$student->session) return [];
        $extenso = new NumeroPorExtenso;
        $this->load->model(['eloquent/Student_fee_item_eloquent']);
        //filter(function($row) use($student) {return $student->session->id == $row->student_session_id;})->
        $fees = Student_fee_item_eloquent::with(['fee_type'])->where('student_session_id', $student->session->id)->get()->groupBy('feetype_id');
        // dump($student->session->toArray());

        $options = [];
        // dump($fees->toArray());

        foreach ($fees as $listOfFees) {

            foreach ($listOfFees as $item) {
                preg_match_all('!\d+!', $item->title, $matches);
                // dump($matches);
                $options[sprintf('%s_@%s_valor', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = number_format($item->amount, 2, ',', '.');
                $options[sprintf('%s_@%s_valor_extenso', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = $extenso->converter($item->amount);
                $options[sprintf('%s_@%s_descricao', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = $item->title;
                $options[sprintf('%s_@%s_data', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('d/m/Y');
                $options[sprintf('%s_@%s_vencimento_dia', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('d');
                $options[sprintf('%s_@%s_vencimento_mes', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('m');
                $options[sprintf('%s_@%s_vencimento_anp', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('Y');
            }
        }

        // dump($options);

        return $options;
    }
}
