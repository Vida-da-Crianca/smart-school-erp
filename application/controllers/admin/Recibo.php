<?php
class Recibo extends CI_Controller {
	
	function gerar($id)
	{
		$data['dados'] = $query = $this->db->get_where('expenses','expenses.id = '.$id);
		$this->load->view('admin/expense/recibo', $data);
	}
}
