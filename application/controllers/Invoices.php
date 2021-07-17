<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invoices extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
    }

    

    public function index() {
       
        if (!$this->rbac->hasPrivilege('invoice_setting', 'can_view')) {
            access_denied();
        }
        $app_ver = $this->config->item('app_ver');

        $this->session->set_userdata('top_menu', 'Invoice Settings');
        $this->session->set_userdata('sub_menu', 'invoices');
        $data['title'] = 'Invoice List';
        $data['app_ver'] = $app_ver;
        // $setting_result         = $this->setting_model->get();
        // $data['settinglist']    = $setting_result;
        $timezoneList = $this->customlib->timezone_list();
        $data['title'] = 'School Setting';
        $session_result = $this->session_model->get();
        $language_result = $this->language_model->getEnable_languages();

        $data['sessionlist'] = $session_result;
        $month_list = $this->customlib->getMonthList();
        $data['languagelist'] = $language_result;
        $data['timezoneList'] = $timezoneList;
        $data['monthList'] = $month_list;
        $dateFormat = $this->customlib->getDateFormat();
        $currency = $this->customlib->getCurrency();
        $data['dateFormatList'] = $dateFormat;
        $data['currencyList'] = $currency;
        $digit = $this->customlib->getDigits();
        $data['digitList'] = $digit;
        $currencyPlace = $this->customlib->getCurrencyPlace();
        $data['currencyPlace'] = $currencyPlace;
        $this->load->model('eloquent/Invoice_setting_eloquent');
        $data['result'] = Invoice_setting_eloquent::all();
        
        $this->load->view('layout/header', $data);
        $this->load->view('invoice/index', $data);
        $this->load->view('layout/footer', $data);
    }

   
    public function onSave() {

        if (!$this->rbac->hasPrivilege('general_setting', 'can_edit')) {
            access_denied();
        }
        $auto_staff_id = false;
        $this->load->model('eloquent/Invoice_setting_eloquent');
        //$this->form_validation->set_rules('sch_session_id', $this->lang->line('session'), 'trim|required|xss_clean');

         foreach($this->input->post()  as $key => $value){
             Invoice_setting_eloquent::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
                
            );
         }



         dump('ok');
        
        
    }
    
}
