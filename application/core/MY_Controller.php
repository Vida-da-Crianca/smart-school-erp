<?php

define('THEMES_DIR', 'themes');
define('BASE_URI', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

class MY_Controller extends CI_Controller {

    protected $langs = array();

    public function __construct() {

        parent::__construct();
        $this->config->load('license');
        $this->load->helper('language');
        $this->load->library('auth');
        $this->load->library('module_lib');
        $this->load->library('pushnotification');
        $this->load->library('jsonlib');
        $this->load->helper(array('directory', 'customfield', 'custom'));
        $this->load->model(array('setting_model', 'customfield_model', 'onlinestudent_model', 'houselist_model', 'onlineexam_model', 'onlineexamquestion_model', 'onlineexamresult_model', 'examstudent_model', 'admitcard_model', 'marksheet_model', 'chatuser_model', 'examgroupstudent_model', 'examgroup_model', 'batchsubject_model'));

        if ($this->session->has_userdata('admin')) {

            $admin = $this->session->userdata('admin');
            $language = ($admin['language']['language']);
        } else if ($this->session->has_userdata('student')) {

            $student = $this->session->userdata('student');
            $language = ($student['language']['language']);
        } else {
            $this->school_details = $this->setting_model->getSchoolDetail();
            $language = ($this->school_details->language);
        }

        $this->config->set_item('language', strtotime($language));
        $lang_array = array('form_validation_lang');
        $map = directory_map(APPPATH . "./language/" . $language . "/app_files");
        foreach ($map as $lang_key => $lang_value) {
            $lang_array[] = 'app_files/' . str_replace(".php", "", $lang_value);
        }

        $this->load->language($lang_array, $language);
    }

}

class Admin_Controller extends MY_Controller {

    protected $aaaa = false;

    protected $resp_status;
    protected $resp_msg;

    protected $post_filters;

    protected $estados;


    public function __construct() {
        parent::__construct();


        $this->auth->is_logged_in();
        $this->check_license();
        $this->load->library('rbac');
        $this->config->load('app-config');
        $this->load->model(array('batchsubject_model', 'examgroup_model', 'examsubject_model', 'examgroupstudent_model', 'feereminder_model'));

        $this->config->load('ci-blog');
        $this->config->load('custom_filed-config');

        $this->estados['AC'] = 'AC';
        $this->estados['AL'] = 'AL';
        $this->estados['AP'] = 'AP';
        $this->estados['AM'] = 'AM';
        $this->estados['BA'] = 'BA';
        $this->estados['CE'] = 'CE';
        $this->estados['DF'] = 'DF';
        $this->estados['ES'] = 'ES';
        $this->estados['GO'] = 'GO';
        $this->estados['MA'] = 'MA';
        $this->estados['MT'] = 'MT';
        $this->estados['MS'] = 'MS';
        $this->estados['MG'] = 'MG';
        $this->estados['PA'] = 'PA';
        $this->estados['PB'] = 'PB';
        $this->estados['PR'] = 'PR';
        $this->estados['PE'] = 'PE';
        $this->estados['PI'] = 'PI';
        $this->estados['RJ'] = 'RJ';
        $this->estados['RN'] = 'RN';
        $this->estados['RS'] = 'RS';
        $this->estados['RO'] = 'RO';
        $this->estados['RR'] = 'RR';
        $this->estados['SC'] = 'SC';
        $this->estados['SP'] = 'SP';
        $this->estados['SE'] = 'SE';
        $this->estados['TO'] = 'TO';

    }


    public function _validarClassSectionVagas($class_id,$section_id){
         //Verficar se o section em questao é integral
        $resSection = $this->db->where('id',$section_id)->get('sections')->result();
        $peridoSelecionadoIntegral = (count($resSection)>0 ? ((int)$resSection[0]->full_time == 1) : false);

        //Carregar todos alunos matriculas na TURMA... sem especificar o PERIODO
        $alunosMatriculados = $this->student_model->searchByClassSection($class_id);

        //1º - verificar quantos alunos ja tem matriculados no periodo selecionado
        //sendo que contabilizamos tambems as matriculas de periodo INTEGRAL

        $quantidadeAlunosMatriculadosPorPeriodo = [];
        $quantidadeAlunosMatriculadosPeriodoIntegral = 0;
        $periodosNome = [];
        foreach ($alunosMatriculados as $aluno){

           $periodo = (int)$aluno['section_id'];
           if(!isset($quantidadeAlunosMatriculadosPorPeriodo[$periodo])){
                $quantidadeAlunosMatriculadosPorPeriodo[$periodo] = 0;
           }
           $quantidadeAlunosMatriculadosPorPeriodo[$periodo]++;

           if((int)$aluno['full_time'] == 1){
               $quantidadeAlunosMatriculadosPeriodoIntegral++;
           }

           $periodosNome[$periodo] = $aluno['section'];

        }

         //Quantidade de vagas disponiveis por PERIODO e na classe toda
        $vagasPorPeriodo = [];
        $vagasTotalTurma = 0;
        $res = $this->db->where('class_id',$class_id)->get('class_sections')->result();
        foreach ($res as $row){

            if(!isset($vagasPorPeriodo[$row->section_id])){
                $vagasPorPeriodo[$row->section_id] = (int)$row->limit;
            }

            $vagasTotalTurma += $row->limit;
        }



        //Agora de acordo com o tipo do periodo selecionado calculamos de uma maneira:
        if(isset($quantidadeAlunosMatriculadosPorPeriodo[$section_id]) && isset($vagasPorPeriodo[$section_id])){
            if(($quantidadeAlunosMatriculadosPorPeriodo[$section_id] + (!$peridoSelecionadoIntegral ? $quantidadeAlunosMatriculadosPeriodoIntegral :  0) + 1 ) > $vagasPorPeriodo[$section_id]){
                throw new Exception('Não Há Mais Vagas Disponíveis Nessa Turma/Período!');
            }
        }


        if($peridoSelecionadoIntegral){

            //Se o periodo selecionado FOR INTEGRAL
            //temos que validar tambem se nos outros periodos
            //tem vagas disponiveis
            foreach ($quantidadeAlunosMatriculadosPorPeriodo as $periodo => $qtd){
                if($periodo != $section_id){

                    if(isset($vagasPorPeriodo[$periodo])){
                        if(($qtd+1) > $vagasPorPeriodo[$periodo]){
                            throw new Exception('Um dos períodos['.(isset($periodosNome[$periodo]) ? $periodosNome[$periodo] : '').'] da turma não tem mais vagas disponíveis! Como esta é uma matrícula integral, deve haver pelo menos uma vaga disponível em todos os outros períodos da turma.');
                        }
                    }
                }
            }
        }
    }


    public function check_license() {

        $license = $this->config->item('SSLK');

        if (!empty($license)) {

            $regex = "/^[A-Z0-9]{6}-[A-Z0-9]{6}-[A-Z0-9]{6}-/";

            if (preg_match($regex, $license)) {
                $valid_string = $this->aes->validchk('encrypt', base_url());

                if (strpos($license, $valid_string) !== false) {

                    true; //valid
                } else {
                    $this->update_ss_routine();
                }
            } else {

                $this->update_ss_routine();
            }
        }
    }

    public function update_ss_routine() {

        // $license = $this->config->item('SSLK');
        // $fname = APPPATH . 'config/license.php';
        // $update_handle = fopen($fname, "r");
        // $content = fread($update_handle, filesize($fname));
        // $file_contents = str_replace('$config[\'SSLK\'] = \'' . $license . '\'', '$config[\'SSLK\'] = \'\'', $content);
        // $update_handle = fopen($fname, 'w') or die("can't open file");


        // if (fwrite($update_handle, $file_contents)) {

        // }
        // fclose($update_handle);

        $this->config->set_item('SSLK', getenv('LICENSE_APP', ''));
    }

    protected function lastQuery()
    {
        echo $this->db->last_query() . '<br />';
    }

    protected function dump($var)
    {
        var_dump($var);
    }

    protected function pre($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    protected function checkAjaxSubmit()
    {
        $this->resp_status = false;

        return $this->input->is_ajax_request() && $this->input->post('_submit') == 'yeap';
    }

    protected function showJSONResp()
    {
        echo json_encode(array('status' => $this->resp_status, 'msg' => $this->resp_msg));
        exit;
    }

     protected function extractPostFilters()
    {
        $this->post_filters = array();

        $posts = $this->input->post();

        foreach ($posts as $key => $value)
        {
            //if (!empty($value))
            {
                $this->post_filters[$key] = $value;
            }
        }
    }

    protected function extractPostFields()
    {
        $this->post_fields = array();

        $posts = $this->input->post();

        foreach ($posts as $key => $value)
        {
            if (!empty($value))
            {
                $this->post_fields[$key] = $value;
            }
        }
    }

    protected function parseFloat($str)
    {
        return (float) str_replace(array('.', ','), array('', '.'), $str);
    }

    protected function modelTransStart()
    {
        $this->db->trans_begin();
    }

    protected function modelTransEnd()
    {
        if ($this->db->trans_status() === FALSE)
            $this->db->trans_rollback();
        else
            $this->db->trans_commit();
    }

    protected function formatarData($data)
    {
        if (!empty($data))
        {
            return $this->tools->formatarData($data, 'br', 'usa');
        }
        else
            return '';
    }
    protected function extractFiltrosTipoData()
    {
        try
        {
            if(!empty($this->post_filters['data1']) && !empty($this->post_filters['data2'])){
                $this->post_filters['data1'] = $this->formatarData($this->post_filters['data1']);
                $this->post_filters['data2'] = $this->formatarData($this->post_filters['data2']);
            }
        }
        catch (Exception $ex)
        {
            throw new Exception('Erro ao formatar FILTROS de DATAS');
        }
    }

    protected function extractFieldFromArray($arr, $field)
    {
        try
        {

            $tmp = array();

            foreach ($arr as $row)
            {
                if (isset($row->$field))
                    $tmp[] = $row->$field;
            }

            return $tmp;
        }
        catch (Exception $ex)
        {
            throw new Exception('Erro ao extrair IDs do Array');
        }
    }

     public function _classToArray($objClass, $exclude = null)
    {
        $results = array();

        if (is_object($objClass))
        {



            $vars = get_object_vars($objClass);

            if (is_array($exclude) && count($exclude) > 0)
            {

                foreach ($vars as $key => $value)
                {
                    if (!in_array($key, $exclude))
                    {
                        $results[$key] = $value;
                    }
                }
            }
            else
            {
                $results = $vars;
            }
        }

        return $results;
    }

    protected function soNumeros($str){
        return preg_replace('/[^0-9]/', '', $str);
    }

    function CPFValido($cpf)
	{
		// Verifiva se o número digitado contém todos os digitos
		$cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

		// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
		if (strlen($cpf) != 11 ||
				$cpf == '00000000000' ||
				$cpf == '11111111111' ||
				$cpf == '22222222222' ||
				$cpf == '33333333333' ||
				$cpf == '44444444444' ||
				$cpf == '55555555555' ||
				$cpf == '66666666666' ||
				$cpf == '77777777777' ||
				$cpf == '88888888888' ||
				$cpf == '99999999999') {
			return FALSE;
		} else {
			// Calcula os números para verificar se o CPF é verdadeiro
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}

				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return FALSE;
				}
			}
			return TRUE;
		}
	}


    protected function checkFormValidationErrors()
    {
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE)
            throw new Exception(validation_errors());
    }






}

class Student_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('studentmodule_lib');
        $this->config->load('app-config');
        $this->auth->is_logged_in_user('student');
    }

}

class Public_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

}

class Parent_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in_user('parent');
        $this->config->load('app-config');
        $this->load->library('parentmodule_lib');
    }

}

class Front_Controller extends CI_Controller {

    protected $data = array();
    protected $school_details = array();
    protected $parent_menu = '';
    protected $page_title = '';
    protected $theme_path = '';
    protected $front_setting = '';

    public function __construct() {

        parent::__construct();

        $this->check_installation();

        if ($this->config->item('installed') == true) {

            $this->db->reconnect();
        }
        $this->load->helper('language');
        $this->school_details = $this->setting_model->getSchoolDetail();

        $this->load->model('frontcms_setting_model');

        $this->front_setting = $this->frontcms_setting_model->get();

        if (!$this->front_setting) {

            redirect('site/userlogin');
        } else {

            if (!$this->front_setting->is_active_front_cms) {

                redirect('site/userlogin');
            }
        }

        $this->theme_path = $this->front_setting->theme;
//================
        $language = ($this->school_details->language);
        $this->load->helper('directory');
        $lang_array = array('form_validation_lang');
        $map = directory_map(APPPATH . "./language/" . $language . "/app_files");
        foreach ($map as $lang_key => $lang_value) {
            $lang_array[] = 'app_files/' . str_replace(".php", "", $lang_value);
        }

        $this->load->language($lang_array, $language);
//===============

        $this->load->config('ci-blog');
    }

    protected function load_theme($content = null, $layout = true) {

        $this->data['main_menus'] = '';
        $this->data['school_setting'] = $this->school_details;
        $this->data['front_setting'] = $this->front_setting;
        $menu_list = $this->cms_menu_model->getBySlug('main-menu');

        $footer_menu_list = $this->cms_menu_model->getBySlug('bottom-menu');
        if (count($menu_list) > 0) {
            $this->data['main_menus'] = $this->cms_menuitems_model->getMenus($menu_list['id']);
        }

        if (count($footer_menu_list) > 0) {
            $this->data['footer_menus'] = $this->cms_menuitems_model->getMenus($footer_menu_list['id']);
        }
        $this->data['header'] = $this->load->view('themes/' . $this->theme_path . '/header', $this->data, true);

        $this->data['slider'] = $this->load->view('themes/' . $this->theme_path . '/home_slider', $this->data, true);

        $this->data['footer'] = $this->load->view('themes/' . $this->theme_path . '/footer', $this->data, true);

        $this->base_assets_url = 'backend/' . THEMES_DIR . '/' . $this->theme_path . '/';

        $this->data['base_assets_url'] = BASE_URI . $this->base_assets_url;

        // if ($layout == true) {
        $this->data['content'] = (is_null($content)) ? '' : $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/' . $content, $this->data, true);
        $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/layout', $this->data);
        // } else {
        //     $this->load->view(THEMES_DIR . '/' . $this->config->item('ci_blog_theme') . '/' . $content, $this->data);
        // }
    }

    protected function load_theme_form($content = null, $layout = true) {

        $this->data['main_menus'] = '';
        $this->data['school_setting'] = $this->school_details;
        $this->data['front_setting'] = $this->front_setting;
        $menu_list = $this->cms_menu_model->getBySlug('main-menu');
        $footer_menu_list = $this->cms_menu_model->getBySlug('bottom-menu');
        if (count($menu_list > 0)) {
            $this->data['main_menus'] = $this->cms_menuitems_model->getMenus($menu_list['id']);
        }

        if (count($footer_menu_list > 0)) {
            $this->data['footer_menus'] = $this->cms_menuitems_model->getMenus($footer_menu_list['id']);
        }
        $this->data['header'] = $this->load->view('themes/' . $this->theme_path . '/header', $this->data, true);

        $this->data['slider'] = $this->load->view('themes/' . $this->theme_path . '/home_slider', $this->data, true);

        $this->data['footer'] = $this->load->view('themes/' . $this->theme_path . '/footer', $this->data, true);

        $this->base_assets_url = 'backend/' . THEMES_DIR . '/' . $this->theme_path . '/';

        $this->data['base_assets_url'] = BASE_URI . $this->base_assets_url;

        // if ($layout == true) {
        $this->data['content'] = (is_null($content)) ? '' : $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/' . $content, $this->data, true);
        $this->load->view(THEMES_DIR . '/' . $this->theme_path . '/layout', $this->data);
        // } else {
        //     $this->load->view(THEMES_DIR . '/' . $this->config->item('ci_blog_theme') . '/' . $content, $this->data);
        // }
    }

    private function check_installation() {

        if ($this->uri->segment(1) !== 'install') {
            $this->load->config('migration');
            if ($this->config->item('installed') == false && $this->config->item('migration_enabled') == false) {
                redirect(base_url() . 'install/start');
            } else {
                if (is_dir(APPPATH . 'controllers/install')) {
                    echo '<h3>Delete the install folder from application/controllers/install</h3>';
                    die;
                }
            }
        }
    }

}
