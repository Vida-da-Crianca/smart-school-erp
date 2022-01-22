<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Front_Controller
{
      protected $resp_status = false;
    protected $resp_msg;

    public function __construct()
    {
        parent::__construct();
        $this->load->config('form-builder');
        $this->load->config('app-config');
        $this->load->library(array('mailer', 'form_builder'));
        $this->load->model(array('frontcms_setting_model', 'complaint_Model', 'Visitors_model', 'onlinestudent_model','customfield_model','curriculo_model'));
        $this->blood_group = $this->config->item('bloodgroup');
        $this->load->library('Ajax_pagination');
        $this->load->library('module_lib');
        $this->load->helper('customfield_helper');
        $this->banner_content         = $this->config->item('ci_front_banner_content');
        $this->perPage                = 12;
        $ban_notice_type              = $this->config->item('ci_front_notice_content');
        $this->data['banner_notices'] = $this->cms_program_model->getByCategory($ban_notice_type, array('start' => 0, 'limit' => 5));
    }

    public function show_404()
    {
        $this->load->view('errors/error_message');
    }

    public function index()
    {

        $setting                     = $this->frontcms_setting_model->get();
        $this->data['active_menu']   = 'home';
        $this->data['page_side_bar'] = $setting->is_active_sidebar;
        $home_page                   = $this->config->item('ci_front_home_page_slug');
        $result                      = $this->cms_program_model->getByCategory($this->banner_content);
        $this->data['page']          = $this->cms_page_model->getBySlug($home_page);
        if (!empty($result)) {
            $this->data['banner_images'] = $this->cms_program_model->front_cms_program_photos($result[0]['id']);
        }

        $this->load_theme('home');
    }

    public function page($slug)
    {
        $page = $this->cms_page_model->getBySlug(urldecode($slug));
        if (!$page) {
            $this->data['page'] = $this->cms_page_model->getBySlug('404-page');
        } else {

            $this->data['page'] = $page;
        }

        if ($page['is_homepage']) {
            redirect('frontend');
        }
        $this->data['active_menu']       = $slug;
        $this->data['page_side_bar']     = $this->data['page']['sidebar'];
        $this->data['page_content_type'] = "";
        if (!empty($this->data['page']['category_content'])) {
            $content_array = $this->data['page']['category_content'];
            reset($content_array);
            $first_key            = key($content_array);
            $totalRec             = count($this->cms_program_model->getByCategory($content_array[$first_key]));
            $config['target']     = '#postList';
            $config['base_url']   = base_url() . 'welcome/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page']   = $this->perPage;
            $config['link_func']  = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            //get the posts data
            $this->data['page']['category_content'][$first_key] = $this->cms_program_model->getByCategory($content_array[$first_key], array('limit' => $this->perPage));

            $this->data['page_content_type'] = $content_array[$first_key];
            //load the view
        }
        $this->data['page_form'] = false;

        if (strpos($page['description'], '[form-builder:') !== false) {
            $this->data['page_form'] = true;
            $start                   = '[form-builder:';
            $end                     = ']';

            $form_name = $this->customlib->getFormString($page['description'], $start, $end);

            $form = $this->config->item($form_name);

            $this->data['form_name'] = $form_name;
            $this->data['form']      = $form;

            if (!empty($form)) {
                foreach ($form as $form_key => $form_value) {
                    if (isset($form_value['validation'])) {
                        $display_string = ucfirst(preg_replace('/[^A-Za-z0-9\-]/', ' ', $form_value['id']));
                        $this->form_validation->set_rules($form_value['id'], $display_string, $form_value['validation']);
                    }
                }
                if ($this->form_validation->run() == false) {

                } else {
                    $setting = $this->frontcms_setting_model->get();

                    $response_message = $form['email_title']['mail_response'];
                    $record           = $this->input->post();

                    if ($record['form_name'] == 'contact_us') {
                        $email     = $this->input->post('email');
                        $name      = $this->input->post('name');
                        $cont_data = array(
                            'name'    => $name . " (" . $email . ")",
                            'source'  => 'Online',
                            'email'   => $this->input->post('email'),
                            'purpose' => $this->input->post('subject'),
                            'date'    => date('Y-m-d'),
                            'note'    => $this->input->post('description') . " (Sent from online front site)",
                        );
                        $visitor_id = $this->Visitors_model->add($cont_data);
                    }

                    if ($record['form_name'] == 'complain') {
                        $complaint_data = array(
                            'complaint_type' => 'General',
                            'source'         => 'Online',
                            'name'           => $this->input->post('name'),
                            'email'          => $this->input->post('email'),
                            'contact'        => $this->input->post('contact_no'),
                            'date'           => date('Y-m-d'),
                            'description'    => $this->input->post('description'),
                        );
                        $complaint_id = $this->complaint_Model->add($complaint_data);
                    }

                    $email_subject = $record['email_title'];
                    $mail_body     = "";
                    unset($record['email_title']);
                    unset($record['submit']);
                    foreach ($record as $fetch_k_record => $fetch_v_record) {
                        $mail_body .= ucwords($fetch_k_record) . ": " . $fetch_v_record;
                        $mail_body .= "<br/>";
                    }
                    if (!empty($setting) && $setting->contact_us_email != "") {

                        $this->mailer->send_mail($setting->contact_us_email, $email_subject, $mail_body);
                    }

                    $this->session->set_flashdata('msg', $response_message);
                    redirect('page/' . $slug, 'refresh');
                }
            }
        }

        $this->load_theme('pages/page');
    }

    public function ajaxPaginationData()
    {
        $page              = $this->input->post('page');
        $page_content_type = $this->input->post('page_content_type');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $data['page_content_type'] = $page_content_type;
        //total rows count
        $totalRec = count($this->cms_program_model->getByCategory($page_content_type));
        //pagination configuration
        $config['target']     = '#postList';
        $config['base_url']   = base_url() . 'welcome/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //get the posts data
        $data['category_content'] = $this->cms_program_model->getByCategory($page_content_type, array('start' => $offset, 'limit' => $this->perPage));
        //load the view
        $this->load->view('themes/default/pages/ajax-pagination-data', $data, false);
    }

    public function read($slug)
    {

        $this->data['active_menu'] = 'home';
        $page                      = $this->cms_program_model->getBySlug($slug);

        $this->data['page_side_bar']  = $page['sidebar'];
        $this->data['featured_image'] = $page['feature_image'];
        $this->data['page']           = $page;
        $this->load_theme('pages/read');
    }

    public function getSections()
    {

        $class_id = $this->input->post('class_id');
        $data     = $this->section_model->getClassBySectionAll($class_id);
        echo json_encode($data);

    }

    public function admissionOLD()
    {
        if ($this->module_lib->hasActive('online_admission')) {
            $this->data['active_menu'] = 'online-admission';
            $page                      = array('title' => 'Matrícula Online', 'meta_title' => 'online admission form', 'meta_keyword' => 'online admission form', 'meta_description' => 'online admission form');

            $this->data['page_side_bar']  = false;
            $this->data['featured_image'] = false;
            $this->data['page']           = $page;
            ///============
            $this->data['form_admission'] = $this->setting_model->getOnlineAdmissionStatus();

            ///////===
            $genderList               = $this->customlib->getGender();
            $this->data['genderList'] = $genderList;
            $this->data['title']      = 'Add Student';
            $this->data['title_list'] = 'Recently Added Student';

            $data["student_categorize"] = 'class';
            $session                    = $this->setting_model->getCurrentSession();

            $class                   = $this->class_model->getAll();
            $this->data['classlist'] = $class;
            $userdata                = $this->customlib->getUserData();

            $category                   = $this->category_model->get();
            $this->data['categorylist'] = $category;

            $this->form_validation->set_rules('firstname', $this->lang->line('first_name'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_is', $this->lang->line('guardian'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', $this->lang->line('date_of_birth'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required|xss_clean|integer|greater_than[0]');
            $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required|xss_clean|integer|greater_than[0]');
            $this->form_validation->set_rules('guardian_name', $this->lang->line('guardian_name'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_phone', $this->lang->line('guardian_phone'), 'trim|required|xss_clean');

            $this->form_validation->set_rules('guardian_document', $this->lang->line('guardian_document'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_phone', $this->lang->line('guardian_phone'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_postal_code', $this->lang->line('guardian_postal_code'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_address_number', $this->lang->line('guardian_address_number'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_email', $this->lang->line('guardian_email'), 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('guardian_address', $this->lang->line('guardian_address'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_district', $this->lang->line('guardian_district'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_state', $this->lang->line('guardian_state'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('guardian_city', $this->lang->line('guardian_city'), 'trim|required|xss_clean');




            if ($this->form_validation->run() == false) {

                $this->load_theme('pages/admission');
            } else {
                //==============
                $document_validate = true;
                $image_validate    = $this->config->item('file_validate');

                if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {

                    $file_type         = $_FILES["document"]['type'];
                    $file_size         = $_FILES["document"]["size"];
                    $file_name         = $_FILES["document"]["name"];
                    $allowed_extension = $image_validate['allowed_extension'];
                    $ext               = pathinfo($file_name, PATHINFO_EXTENSION);
                    $allowed_mime_type = $image_validate['allowed_mime_type'];
                    if ($files = filesize($_FILES['document']['tmp_name'])) {

                        if (!in_array($file_type, $allowed_mime_type)) {
                            $this->data['error_message'] = 'File Type Not Allowed';
                            $document_validate           = false;
                        }

                        if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                            $this->data['error_message'] = 'Extension Not Allowed';
                            $document_validate           = false;
                        }
                        if ($file_size > $image_validate['upload_size']) {
                            $this->data['error_message'] = 'File should be less than' . number_format($image_validate['upload_size'] / 1048576, 2) . " MB";
                            $document_validate           = false;
                        }
                    }
                }
                //=====================
                if ($document_validate) {

                    $class_id   = $this->input->post('class_id');
                    $section_id = $this->input->post('section_id');

                    //carregar o class_section_id
                    $res = $this->db->where('class_id',$class_id)
                            ->where('section_id',$section_id)
                            ->get('class_sections')->result();

                    $class_section_id = (count($res)>0? $res[0]->id : 0);


                    $dob = explode('/',$this->input->post('dob'));
                    if(is_array($dob) && count($dob) == 3){
                        $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
                    }else{
                        $dob = date('Y-m-d');
                    }



                    $data = array(
                        'roll_no'             => $this->input->post('roll_no'),
                        'mobileno'            => $this->input->post('mobileno'),
                        'email'               => $this->input->post('email'),
                        'firstname'           => $this->input->post('firstname'),
                        'lastname'            => $this->input->post('lastname'),
                        'mobileno'            => $this->input->post('mobileno'),
                        'class_section_id'    => $class_section_id,//$this->input->post('section_id'),
                        'guardian_is'         => $this->input->post('guardian_is'),
                        'dob'                 => $dob, //date('Y-m-d', strtotime($this->input->post('dob'))),
                        'current_address'     => $this->input->post('current_address'),
                        'permanent_address'   => $this->input->post('permanent_address'),
                        'father_name'         => $this->input->post('father_name'),
                        'father_phone'        => $this->input->post('father_phone'),
                        'father_occupation'   => $this->input->post('father_occupation'),
                        'mother_name'         => $this->input->post('mother_name'),
                        'mother_phone'        => $this->input->post('mother_phone'),
                        'mother_occupation'   => $this->input->post('mother_occupation'),
			'guardian_document'	  => str_replace(array('',' ','-','_',',','-','.'),'',$this->input->post('guardian_document')),
			'guardian_occupation' => $this->input->post('guardian_occupation'),
                        'guardian_email'      => trim(strtolower($this->input->post('guardian_email'))),
                        'gender'              => $this->input->post('gender'),
                        'guardian_name'       => $this->input->post('guardian_name'),
                        'guardian_relation'   => $this->input->post('guardian_relation'),
                        'guardian_phone'      => $this->input->post('guardian_phone'),
                        'admission_date'      => date('Y/m/d'),
                        'measurement_date'    => date('Y/m/d'),

                        'guardian_postal_code'    => str_replace(array('',' ','-','_',','),'',$this->input->post('guardian_postal_code')),
                        'guardian_address'    => $this->input->post('guardian_address'),
                        'guardian_address_number'    => $this->input->post('guardian_address_number'),
                        'guardian_district'    => $this->input->post('guardian_district'),
                        'guardian_city'    => $this->input->post('guardian_city'),
                        'guardian_state'    => $this->input->post('guardian_state'),

                    );
                    if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {
                        $time     = md5($_FILES["document"]['name'] . microtime());
                        $fileInfo = pathinfo($_FILES["document"]["name"]);
                        $doc_name = $time . '.' . $fileInfo['extension'];
                        move_uploaded_file($_FILES["document"]["tmp_name"], "./uploads/student_documents/online_admission_doc/" . $doc_name);

                        $data['document'] = $doc_name;
                    }

                    $insert_id = $this->onlinestudent_model->add($data);

                    //$this->session->set_flashdata('msg', '<div class="alert alert-success">Thanks for registration. Please note your reference number ' . $insert_id . ' for further communication.</div>');

                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Obrigado por se registrar. Seu número de referência é ' . $insert_id . ' para comunicações futuras</div>');

                    redirect($_SERVER['HTTP_REFERER'], 'refresh');
                }

                $this->load_theme('pages/admission');
            }

        }
    }

    public function workwithus(){
        //Dados para view(theme/template)
        $this->data['active_menu'] = 'workwithus';
        $page = array('title' => 'Trabalhe Conosco', 'meta_title' => 'trabalahe conosco', 'meta_keyword' => 'trabalhe conosco', 'meta_description' => 'Envie seu cúrriculo para a gente!');
        $this->data['page_side_bar']  = false;
        $this->data['featured_image'] = false;
        $this->data['page'] = $page;
        $this->data['form_admission'] = $this->setting_model->getOnlineAdmissionStatus();
        $genderList = $this->customlib->getGender();
        $this->data['designationList'] = $this->staff_model->getStaffDesignation();
        $this->data['genderList'] = $genderList;
        $category = $this->category_model->get();
        $this->data['categorylist'] = $category;
        $this->data['sessions'] = [];
        $res = $this->db->get('sessions')->result();
        foreach ($res as $row){
            $ano = explode('-', $row->session);
            if((int) $ano[0] == (int)date('Y') || (int) $ano[0] == ((int)date('Y')+1)){
                $this->data['sessions'][$row->id] = (int) $ano[0];
            }
        }


        $fields = $this->customfield_model->getByBelong('staff');
        $this->data['escolaridade_id'] = 14;
        foreach($fields as $key => $value){
            if($value["name"] == "Escolaridade" && $value["belong_to"] == "staff" && $value["type"] == "checkbox"){
                $this->data['escolaridade_id'] = $value["id"];
                break;
            }
        }

        $this->load_theme('pages/workwithus');
    }

    public function workwithus_ajax(){
        if($this->input->is_ajax_request() && $this->input->post('_submit') == 'yeap'){


            try{
                $this->db->trans_begin();
                $this->config->set_item('language', 'Portugues_Brazil');
                $ok = true;

                //Validacoes de formulario
                $this->form_validation->set_rules('firstname', 'Nome Completo', 'trim|required|xss_clean');
                $this->form_validation->set_rules('gender', 'Sexo', 'trim|required|xss_clean');
                $this->form_validation->set_rules('dob', $this->lang->line('date_of_birth'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('telefone', 'Telefone', 'trim|required|xss_clean');
                $this->form_validation->set_rules('designation', 'Cargo', 'trim|required');
                $this->form_validation->set_rules('work_exp', 'Experiência', 'trim|required|xss_clean');
                $this->form_validation->set_rules('cursos', 'Cursos', 'trim|required|xss_clean');
                $this->form_validation->set_rules('outros', 'Outros', 'trim|required|xss_clean');
                $this->form_validation->set_rules('file', $this->lang->line('image'), 'callback_handle_upload');

                if($this->input->post('designation') == 'select')
                    throw new Exception('Campo Cargo é obrigatório!');

                $custom_fields = $this->customfield_model->getByBelong('staff');
                foreach ($custom_fields as $custom_fields_key => $custom_fields_value) {
                    if ($custom_fields_value['validation']) {
                        $custom_fields_id = $custom_fields_value['id'];
                        $custom_fields_name = $custom_fields_value['name'];
                        $this->form_validation->set_rules("custom_fields[staff][" . $custom_fields_id . "]", $custom_fields_name, 'trim|required');
                    }
                }


                $this->form_validation->set_rules('guardian_postal_code', 'CEP', 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_address_number', 'nº', 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_address', 'Endereço', 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_district', 'Bairro', 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_state', 'UF', 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_city', 'Cidade', 'trim|required|xss_clean');




                if ($this->form_validation->run() == FALSE){
                    throw new Exception(validation_errors());
                }


                $dob = explode('/',$this->input->post('dob'));
                if(is_array($dob) && count($dob) == 3){
                    $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
                }else{
                    $dob = date('Y-m-d');
                }

                $custom_field_post = $this->input->post("custom_fields[staff]");
                $custom_value_array = array();
                if (!empty($custom_fields_value)) {

                    foreach ($custom_field_post as $key => $value) {
                        $check_field_type = $this->input->post("custom_fields[staff][" . $key . "]");
                        $field_value = is_array($check_field_type) ? implode(",", $check_field_type) : $check_field_type;
                        $array_custom = array(
                            'belong_table_id' => 0,
                            'custom_field_id' => $key,
                            'field_value' => $field_value,
                        );
                        $custom_value_array[] = $array_custom;
                    }
                }

                $endereco_full = $this->input->post('guardian_address') . ', ' . $this->input->post('guardian_district') . ', ' . $this->input->post('guardian_city') . ', ' . $this->input->post('guardian_state');
                $data = array(
                   'id'                 => $this->curriculo_model->uniqueId(),
                   'nome'               => $this->input->post('firstname'),
                   'sexo'              => $this->input->post('gender'),
                   'data_nascimento'     => $dob,
                   'telefone'            => preg_replace("/[^0-9]/", "",$this->input->post('telefone')),
                   'cargo'               => $this->input->post('designation'),
                   'work_exp'            => $this->input->post('work_exp'),
                   'cursos'              => $this->input->post('cursos'),
                   'outros'              => $this->input->post('outros'),
                   'cep'                 => $this->input->post('guardian_postal_code'),
                   'endereco'            => $endereco_full,
                   'twitter'             => $this->input->post('twitter'),
                   'facebook'            => $this->input->post('facebook'),
                   'instagram'           => $this->input->post('instagram'),
                   'linkedin'            => $this->input->post('linkedin'),
                   'numero'              => $this->input->post('guardian_address_number'),
                   'data_envio'          => date('Y-m-d H:i:s')

                 );


                if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                    $fileInfo = pathinfo($_FILES["file"]["name"]);
                    $img_name = $data['id'] . '.' . $fileInfo['extension'];
                    if(!file_exists("./uploads/cv_images/"))
                        mkdir("./uploads/cv_images", 0777, TRUE);

                    move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/cv_images/" . $img_name);
                    $data['foto'] = $img_name;
                }

                $this->curriculo_model->batchInsert($data);
                if (!empty($custom_value_array)) {
                    $this->customfield_model->insertRecord($custom_value_array, $data['id']);
                }

                if ($this->db->trans_status() === FALSE)
                    $this->db->trans_rollback();
                else
                    $this->db->trans_commit();


                $this->resp_status  =true;
                $this->resp_msg = '<div class="alert alert-success">Cúrriculo enviado com sucesso!</div>';

            }
            catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = '<div class="alert alert-danger"><b>' . $e->getMessage() . '</b></div>';
                $this->db->trans_rollback();
            }

            echo json_encode(array('status' => $this->resp_status, 'msg' => $this->resp_msg));
            exit;
        } else {
            echo json_encode(array('status' => false, 'msg' => '<div class="alert alert-danger">Method not allowed</div>'));
            exit;
        }
    }

    public function handle_upload() {
        $image_validate = $this->config->item('image_validate');
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }

    public function admission(){

        //se o modulo de matricula online nao estiver ativo, manda pra Home
        if (!$this->module_lib->hasActive('online_admission')) {
            redirect('/');
        }


        $this->data['erros'] = null;//armazena erros extras a serem exibidos na view


         if($this->input->is_ajax_request() && $this->input->post('_submit') == 'yeap'){

            try{

                $this->db->trans_begin();

                $this->config->set_item('language', 'Portugues_Brazil');




                    $ok = true;

                    //Validacoes de formulario
                    $this->form_validation->set_rules('firstname', 'Nome Completo do(a) Aluno(a)', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('gender', 'Sexo do(a) Aluno(a)', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('dob', $this->lang->line('date_of_birth'), 'trim|required|xss_clean');
                    $this->form_validation->set_rules('class_id', 'Turma', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('section_id', 'Período', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('guardian_is', 'Responsável Financeiro', 'trim|required|xss_clean');

                    $guardian_is = trim($this->input->post('guardian_is'));

                    if($guardian_is == 'father'){
                        $this->form_validation->set_rules('father_name', 'Nome do Pai', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('father_phone', 'Telefone do Pai', 'trim|required|xss_clean');
                    }
                    if($guardian_is == 'mother'){
                        $this->form_validation->set_rules('mother_name', 'Nome da Mãe', 'trim|required|xss_clean');
                        $this->form_validation->set_rules('mother_phone', 'Telefone da Mãe', 'trim|required|xss_clean');
                    }


                    $this->form_validation->set_rules('guardian_relation', 'Relação com o Aluno', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_name', 'Nome do Responsável Financeiro', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_document', 'CPF do Responsável ', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_phone', 'Telefone do Responsável', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_email', 'Email do Responsável', 'trim|required|xss_clean|valid_email');


                    $this->form_validation->set_rules('guardian_postal_code', 'CEP', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_address_number', 'nº', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_address', 'Endereço', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_district', 'Bairro', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_state', 'UF', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('guardian_city', 'Cidade', 'trim|required|xss_clean');

                    //$this->form_validation->set_rules('image', 'Foto do Aluno', 'trim|required|xss_clean');


                    $this->form_validation->set_rules('image', 'Foto do Aluno', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('certidao_nascimento', 'Certidão de Nascimento', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('carteira_vacinacao', 'Carteira de Vacinação', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('cnh_responsavel', 'CNH do Responsável', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('comprovante_residencia', 'Comprovante de Residência', 'trim|required|xss_clean');

                    $this->form_validation->set_error_delimiters('', '');

                    if ($this->form_validation->run() == FALSE){
                        throw new Exception(validation_errors());
                    }

                     if($guardian_is == 'other'){
                        $father_name = trim($this->input->post('father_name'));
                        $mother_name = trim($this->input->post('mother_name'));
                        if(empty($father_name) && empty($mother_name)){
                            throw new Exception('Informe o Nome do Pai ou o Nome da Mãe');
                            $ok=false;
                        }
                    }





                    //Validar uploads
                    /*$image_validate  = $this->config->item('file_validate');
                    if($ok){
                        if(!$this->_validarUploadDocumentoAluno('image','Foto do(a) Aluno(a)',$image_validate)
                        || !$this->_validarUploadDocumentoAluno('certidao_nascimento','Certidão de Nascimento',$image_validate)
                        || !$this->_validarUploadDocumentoAluno('carteira_vacinacao','Carteira de Vacinação do(a) Aluno(a)',$image_validate)
                        || !$this->_validarUploadDocumentoAluno('cnh_responsavel','Carregue a CNH do Responsável',$image_validate)
                        || !$this->_validarUploadDocumentoAluno('cnh_responsavel','Comprovante de Residência',$image_validate)){
                            $ok = false;
                        }

                    }*/

                    $dir = FCPATH.'uploads/pre_upload/';
                    if(!file_exists($dir.$this->input->post('image'))){
                        throw new Exception('Foto do Aluno não encontrada! Faça o upload novamente.');
                    }
                     if(!file_exists($dir.$this->input->post('certidao_nascimento'))){
                        throw new Exception('Certidão de Nascimento não encontrada! Faça o upload novamente.');
                    }
                     if(!file_exists($dir.$this->input->post('carteira_vacinacao'))){
                        throw new Exception('Carteira de Vacinação não encontrada! Faça o upload novamente.');
                    }
                     if(!file_exists($dir.$this->input->post('cnh_responsavel'))){
                        throw new Exception('CNH do Responsável não encontrada! Faça o upload novamente.');
                    }
                     if(!file_exists($dir.$this->input->post('comprovante_residencia'))){
                        throw new Exception('Comprovante de Residência não encontrado! Faça o upload novamente.');
                    }

                   // if($ok){

                        $class_id   = $this->input->post('class_id');
                        $section_id = $this->input->post('section_id');

                        //carregar o class_section_id
                        $res = $this->db->where('class_id',$class_id)
                                    ->where('section_id',$section_id)
                                    ->get('class_sections')->result();

                        $class_section_id = (count($res)>0? $res[0]->id : 0);

                        $dob = explode('/',$this->input->post('dob'));
                        if(is_array($dob) && count($dob) == 3){
                            $dob = $dob[2].'-'.$dob[1].'-'.$dob[0];
                        }else{
                            $dob = date('Y-m-d');
                        }

                        $full_name = $this->input->post('firstname');
                        $name_parts = explode(' ', $full_name);
                        $fistname = ucfirst($name_parts[0]);
                        $lastname = '';
                        if(count($name_parts)>1){
                            $index = 0;
                            foreach ($name_parts as $partName){
                                if($index++>0){
                                    $lastname .= ucfirst($partName).' ';
                                }
                            }
                        }

                        //Cadastrar aluno
                        $data = array(
                                'roll_no'             => $this->input->post('roll_no'),
                                'mobileno'            => $this->input->post('mobileno'),
                                'email'               => $this->input->post('email'),
                                'firstname'           => $fistname,
                                'lastname'            => $lastname,
                                'mobileno'            => $this->input->post('mobileno'),
                                'class_section_id'    => $class_section_id,//$this->input->post('section_id'),
                                'guardian_is'         => $this->input->post('guardian_is'),
                                'dob'                 => $dob, //date('Y-m-d', strtotime($this->input->post('dob'))),
                                'current_address'     => $this->input->post('current_address'),
                                'permanent_address'   => $this->input->post('permanent_address'),
                                'father_name'         => $this->input->post('father_name'),
                                'father_phone'        => $this->input->post('father_phone'),
                                'father_occupation'   => $this->input->post('father_occupation'),
                                'mother_name'         => $this->input->post('mother_name'),
                                'mother_phone'        => $this->input->post('mother_phone'),
                                'mother_occupation'   => $this->input->post('mother_occupation'),
                                'guardian_document'   => preg_replace('/[^0-9]/', '', $this->input->post('guardian_document')), //str_replace(array('',' ','-','_',',','-','.'),'',$this->input->post('guardian_document')),
                                'guardian_occupation' => $this->input->post('guardian_occupation'),
                                'guardian_email'      => trim(strtolower($this->input->post('guardian_email'))),
                                'gender'              => $this->input->post('gender'),
                                'guardian_name'       => $this->input->post('guardian_name'),
                                'guardian_relation'   => $this->input->post('guardian_relation'),
                                'guardian_phone'      => $this->input->post('guardian_phone'),
                                'admission_date'      => date('Y/m/d'),
                                'measurement_date'    => date('Y/m/d'),

                                'guardian_postal_code'    => preg_replace('/[^0-9]/', '', $this->input->post('guardian_postal_code')),//str_replace(array('',' ','-','_',','),'',$this->input->post('guardian_postal_code')),
                                'guardian_address'    => $this->input->post('guardian_address'),
                                'guardian_address_number'    => $this->input->post('guardian_address_number'),
                                'guardian_district'    => $this->input->post('guardian_district'),
                                'guardian_city'    => $this->input->post('guardian_city'),
                                'guardian_state'    => $this->input->post('guardian_state'),

                                'certidao_nascimento' => $this->input->post('certidao_nascimento'),
                                'carteira_vacinacao' => $this->input->post('carteira_vacinacao'),
                                'cnh_responsavel' => $this->input->post('cnh_responsavel'),
                                'comprovante_residencia' => $this->input->post('comprovante_residencia'),
                                'session_id' => (int) $this->input->post('session_id')

                                //'student_categorize' => 'class'

                            );

                            $insert_id = $this->onlinestudent_model->add($data);

                            if($insert_id > 0){

                                //Upload os documentos
                                $documents_ok = true;

                                $uploaddir = './uploads/admission/';
                                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                                    throw new Exception('Erro ao criar diretorio de matriculas online.');
                                    $documents_ok = false;
                                }

                                if($documents_ok){
                                //    $campo = 'image';
                                    //$file_name = uniqid().strtr($_FILES[$campo]['name'],'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
                                    if(!copy($dir.$this->input->post('image'), $uploaddir.$this->input->post('image'))){
                                        $documents_ok = false;
                                        throw new Exception('Não foi possível gravar a Foto do Aluno. Por favor, tente novamente.');
                                    }else{
                                        $this->db->where('id',$insert_id);
                                        $this->db->update('online_admissions',['image'=>$this->input->post('image')]);
                                    }
                                }

                                /*if($documents_ok){
                                        $campo = 'certidao_nascimento';
                                        $file_name = uniqid().strtr($_FILES[$campo]['name'],'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
                                        if(!@move_uploaded_file($_FILES[$campo]["tmp_name"], $uploaddir.$file_name)){
                                            $documents_ok = false;
                                            $this->data['erros'][] = 'Não foi possível gravar a Certidão de Nascimento. Por favor, tente novamente.';
                                        }else{
                                            $this->db->where('id',$insert_id);
                                            $this->db->update('online_admissions',['certidao_nascimento'=>$file_name]);
                                        }
                                }


                                if($documents_ok){
                                    $campo = 'carteira_vacinacao';
                                    $file_name = uniqid().strtr($_FILES[$campo]['name'],'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
                                    if(!@move_uploaded_file($_FILES[$campo]["tmp_name"], $uploaddir.$file_name)){
                                        $documents_ok = false;
                                        $this->data['erros'][] = 'Não foi possível gravar a Carteira de Vacinação. Por favor, tente novamente.';
                                    }else{
                                        $this->db->where('id',$insert_id);
                                        $this->db->update('online_admissions',['carteira_vacinacao'=>$file_name]);
                                    }
                                }

                                if($documents_ok){
                                    $campo = 'cnh_responsavel';
                                    $file_name = uniqid().strtr($_FILES[$campo]['name'],'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
                                    if(!@move_uploaded_file($_FILES[$campo]["tmp_name"], $uploaddir.$file_name)){
                                        $documents_ok = false;
                                        $this->data['erros'][] = 'Não foi possível gravar a CNH do Responsável. Por favor, tente novamente.';
                                    }else{
                                        $this->db->where('id',$insert_id);
                                        $this->db->update('online_admissions',['cnh_responsavel'=>$file_name]);
                                    }
                                }

                                if($documents_ok){
                                    $campo = 'comprovante_residencia';
                                    $file_name = uniqid().strtr($_FILES[$campo]['name'],'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
                                    if(!@move_uploaded_file($_FILES[$campo]["tmp_name"], $uploaddir.$file_name)){
                                        $documents_ok = false;
                                        $this->data['erros'][] = 'Não foi possível gravar o Comprovante de Residência. Por favor, tente novamente.';
                                    }else{
                                        $this->db->where('id',$insert_id);
                                        $this->db->update('online_admissions',['comprovante_residencia'=>$file_name]);
                                    }
                                }*/

                                if($documents_ok){
                                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Obrigado por se registrar. Seu número de referência é ' . $insert_id . ' para comunicações futuras</div>');
                                    //redirect($_SERVER['HTTP_REFERER'], 'refresh');
                                }else{
                                    //rollback
                                    $this->db->where('id',$insert_id);
                                    $this->db->delete('online_admissions');
                                }


                            }//cadastrado
                            else{
                               throw new Exception('Ocorreu um erro ao criar a matrícula. Por Favor, tente novamente.');
                            }

                   // }


       // }// deu submit no form



                if ($this->db->trans_status() === FALSE)
                    $this->db->trans_rollback();
                else
                    $this->db->trans_commit();

                $this->resp_status  =true;
                $this->resp_msg = '';

            } catch (\Exception $e){
                $this->resp_status  =false;
                $this->resp_msg = $e->getMessage();
                  $this->db->trans_rollback();
            }

             echo json_encode(array('status' => $this->resp_status, 'msg' => $this->resp_msg));
             exit;


        }


        //Dados para view(theme/template)
        $this->data['active_menu'] = 'online-admission';
        $page = array('title' => 'Matrícula Online', 'meta_title' => 'matricula online', 'meta_keyword' => 'matricula online cadastro', 'meta_description' => 'Faça a Matrícula Online!');
        $this->data['page_side_bar']  = false;
        $this->data['featured_image'] = false;
        $this->data['page'] = $page;
        $this->data['form_admission'] = $this->setting_model->getOnlineAdmissionStatus();
        $genderList = $this->customlib->getGender();
        $this->data['genderList'] = $genderList;
        $category = $this->category_model->get();
        $this->data['categorylist'] = $category;
        $this->data['sessions'] = [];
        $res = $this->db->get('sessions')->result();
        foreach ($res as $row){
            $ano = explode('-', $row->session);
            if((int) $ano[0] == (int)date('Y') || (int) $ano[0] == ((int)date('Y')+1)){
                $this->data['sessions'][$row->id] = (int) $ano[0];
            }
        }


        $this->load_theme('pages/admission');

    }

    private function _validarUploadDocumentoAluno($arquivo,$campo,$image_validate){
        $document_validate = true;
        $file_type         = $_FILES[$arquivo]['type'];
        $file_size         = $_FILES[$arquivo]["size"];
        $file_name         = $_FILES[$arquivo]["name"];
        $allowed_extension = $image_validate['allowed_extension'];
        $ext               = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_mime_type = $image_validate['allowed_mime_type'];
        if ($files = filesize($_FILES[$arquivo]['tmp_name'])) {

            if (!in_array($file_type, $allowed_mime_type)) {
                throw new Exception('O tipo do arquivo de '.$campo.' não é válido! Selecione outro arquivo.');
                $document_validate           = false;
            }

            if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                throw new Exception('Extensão do arquivo de '.$campo.' não permitida.');
                $document_validate           = false;
            }
            if ($file_size > $image_validate['upload_size']) {
                throw new Exception('O arquivo de '.$campo.' deve ser menor que:' . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                $document_validate           = false;
            }
        }
        return $document_validate;
    }

    private function _uploadDocumentoAluno($arquivo,$titulo,$insert_id){
        if (isset($_FILES[$arquivo]) && !empty($_FILES[$arquivo]['name'])) {
            $uploaddir = './uploads/admission/' . $insert_id . '/';
            if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                die("Error creating folder $uploaddir");
            }
            $file_name   = $_FILES[$arquivo]['name'];
            $exp         = explode(' ', $file_name);
            $imp         = implode('_', $exp);
            $img_name    = $uploaddir . uniqid().strtr($imp,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
            return move_uploaded_file($_FILES[$arquivo]["tmp_name"], $img_name);
            //$data_img = array('student_id' => $insert_id, 'title' => $first_title, 'doc' => $imp);
            //return $this->student_model->adddoc($data_img);
        }
        return false;
    }



    /*Retorna um combobox de Turmas com base na data de nascimento do aluno #alterado*/
    public function getListaTurmasPorDataNascimento(){
         try {

            $dataNascimento = $this->tools->formatarData($this->input->post('dataNascimento'), 'br', 'us');
            $dtNascimento = new DateTime($dataNascimento .' 00:00:00');
            $session_id = (int) $this->input->post('session_id');

           //$config = $this->db->select('session_id')->from('sch_settings')->get()->result();
            //$datasCorte = $this->data_corte_model->getAll(['session_id'=>count($config)>0?$config[0]->session_id : 0 ]);
            $datasCorte = $this->data_corte_model->getAll(['session_id'=>$session_id]);
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
                $dados[] = array('value'=>'','label'=> '*** Escolha uma Turma ***' );
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
            $dados[] = array('value'=>'','label'=> 'Selecione o Período' );

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



}
