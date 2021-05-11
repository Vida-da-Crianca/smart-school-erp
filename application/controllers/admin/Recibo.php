<?php
class Recibo extends Admin_Controller {

 function index(){
	  
	  
	$data = array(
		'title'   => 'Recibo',
		'content' => 'Gerador de Recibo',
	);

   
  }
  
  
  
  function gerar($id) {
	  
		$data['dados'] = $query = $this->db->get_where('expenses','expenses.id = '.$id);
	  
	
       $this->load->view('admin/expense/recibo', $data);
  }
  
  
}
?> 
