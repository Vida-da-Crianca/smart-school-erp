<?php
class Recibo extends Admin_Controller {

    
     function __construct()
    {
        parent::__construct();
        //$this->sch_setting_detail = $this->setting_model->getSetting();
        
        //$this->load->model('source_model');
    }   
    
 function index(){
	  
	  
	$data = array(
		'title'   => 'Sobre',
		'content' => 'Texto da página sobre',
	);

   
  }
  
  
  
  function gerar($id) {
	  
		$data['dados'] = $query = $this->db->get_where('expenses','expenses.id = '.$id);
	  
	
       $this->load->view('admin/expense/recibo', $data);
  }
  
  
}
?> 