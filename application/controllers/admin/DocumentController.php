<?php

use Application\Core\JsonResponse;
use Application\Support\NumberExtensil;
use Application\Support\Parser;
use Respect\Validation\Rules\Json;
use Spipu\Html2Pdf\Html2Pdf;
// use mikehaertl\wkhtmlto\Pdf;
use Illuminate\Support\Str;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;
use Dompdf\Dompdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;


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

        $data['documents'] =  Document::orderBy('title', 'asc')->get();
        
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
 
        $student =  Student_eloquent::where('id', $user_id)->with(['session' => function ($q) {
            return $q->with(['section', 'class_item'])->where('session_id', $this->sch_setting_detail->session_id);
        }])->first();

        $now = new \DateTime();
        $data = [
            'aluno_nome' => $student->fullname,
            // 'class' => $student->session->class_item,
            'aluno_turma' => sprintf(
                '%s - %s',
                $student->session->class_item->class ?? $student->session->class_item->class,
                $student->session->section->section ??  $student->session->section->section
            ),
            
            'aluno_email' => $student->email,
            'guardiao_nome' =>  utf8_decode($student->guardian_name),
            'guardiao_email' => $student->guardian_email,
            'guardiao_logradouro' => ($student->guardian_address),
            'guardiao_logradouro_numero' =>  $student->guardian_address_number,
            'guardiao_logradouro_bairro' =>  utf8_decode($student->guardian_district),
            'guardiao_logradouro_cidade' =>  utf8_decode($student->guardian_city),
            'guardiao_logradouro_estado' =>  $student->guardian_state,
            'guardiao_logradouro_cep' =>   mask($student->guardian_postal_code, '#####-###'),
            'guardiao_documento' =>  mask($student->guardian_document,'###.###.###-##'),
            'guardiao_ocupacao' => $student->guardian_ocupation,
            'mes_atual_extenso' => get_month($now),
            'mes_atual_numero' => $now->format('m'),
            'dia_atual' => $now->format('d'),
            'ano_atual' => $now->format('Y'),

        ];
       
        $data = array_merge($data, $this->getVarsTypes($student));
        $page =  $parser->parse_string(str_replace(['{{', '}}'], ['{', '}'], $document->body), $data);
        $page = str_replace('figure', 'div', $page);
    
        $page = $this->load->view('parser/pdf', ['body' => $page], true);
        // dump($data);
        // echo $page;     
        // return;
        try {

            $html2pdf = new Html2Pdf('P', 'A4', 'pt', true, 'UTF-8', [7,7,7,8]);
            // $html2pdf->setDefaultFont('dejavusans');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($page);
            $html2pdf->output();
            die();
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    
     function previewMultiple($id, $_users_arr)
    {
        $this->load->model(['eloquent/Document', 'eloquent/Student_eloquent']);
        $document =   Document::where('id', $id)->first();

        $parser = new Parser();
 
        $allPages = '';
        
        $users_arr = explode('-',$_users_arr);
        
        foreach($users_arr as $user_id){
        
                $student =  Student_eloquent::where('id', $user_id)->with(['session' => function ($q) {
                    return $q->with(['section', 'class_item'])->where('session_id', $this->sch_setting_detail->session_id);
                }])->first();

                $now = new \DateTime();
                $data = [
                    'aluno_nome' => $student->fullname,
                    // 'class' => $student->session->class_item,
                    'aluno_turma' => sprintf(
                        '%s - %s',
                        $student->session->class_item->class ?? $student->session->class_item->class,
                        $student->session->section->section ??  $student->session->section->section
                    ),

                    'aluno_email' => $student->email,
                    'guardiao_nome' =>  utf8_decode($student->guardian_name),
                    'guardiao_email' => $student->guardian_email,
                    'guardiao_logradouro' => ($student->guardian_address),
                    'guardiao_logradouro_numero' =>  $student->guardian_address_number,
                    'guardiao_logradouro_bairro' =>  utf8_decode($student->guardian_district),
                    'guardiao_logradouro_cidade' =>  utf8_decode($student->guardian_city),
                    'guardiao_logradouro_estado' =>  $student->guardian_state,
                    'guardiao_logradouro_cep' =>   mask($student->guardian_postal_code, '#####-###'),
                    'guardiao_documento' =>  mask($student->guardian_document,'###.###.###-##'),
                    'guardiao_ocupacao' => $student->guardian_ocupation,
                    'mes_atual_extenso' => get_month($now),
                    'mes_atual_numero' => $now->format('m'),
                    'dia_atual' => $now->format('d'),
                    'ano_atual' => $now->format('Y'),

                ];

                $data = array_merge($data, $this->getVarsTypes($student));
                $page =  $parser->parse_string(str_replace(['{{', '}}'], ['{', '}'], $document->body), $data);
                $page = str_replace('figure', 'div', $page);

                //$page = ;
               
                $allPages .= $page;
                
                 
                $allPages .=' <div style="page-break-after:always; clear:both"></div>
';
        }
        // dump($data);
        // echo $allPages;  
        // die('');
        // return;
        try {

            $html2pdf = new Html2Pdf('P', 'A4', 'pt', true, 'UTF-8', [7,7,7,8]);
            // $html2pdf->setDefaultFont('dejavusans');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($this->load->view('parser/pdf', ['body' => $allPages], true));    
            //$html2pdf->
            $html2pdf->output();
            die();
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
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
        if (!$fees) return $options;
        // dump($fees->toArray());

        foreach ($fees as $listOfFees) {
            $qty = $listOfFees->count();
            $options[sprintf('%s_quantidade', Str::slug($listOfFees->first()->fee_type->type, '_'))] = $qty;
            $options[sprintf('%s_quantidade_extenso', Str::slug($listOfFees->first()->fee_type->type, '_'))] = NumberExtensil::converte($qty, false);
            foreach ($listOfFees as $item) {
                preg_match_all('!\d+!', $item->title, $matches);
                // dump($matches);
                $options[sprintf('%s_@%s_valor', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = number_format($item->amount, 2, ',', '.');
                $options[sprintf('%s_@%s_valor_extenso', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = $extenso->converter($item->amount);
                $options[sprintf('%s_@%s_descricao', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = $item->title;
                $options[sprintf('%s_@%s_data', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('d/m/Y');
                $options[sprintf('%s_@%s_vencimento_dia', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('d');
                $options[sprintf('%s_@%s_vencimento_dia_extenso', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = NumberExtensil::converte( (new \DateTime($item->due_date))->format('d'), false);
                $options[sprintf('%s_@%s_vencimento_mes', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('m');
                $options[sprintf('%s_@%s_vencimento_anp', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('Y');

                
            }
        }

        // dump($options);

        return $options;
    }
}
