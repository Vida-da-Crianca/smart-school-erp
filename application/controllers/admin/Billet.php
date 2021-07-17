<?php

use Application\Core\JsonResponse;
use Application\Core\Billet as B;
use Application\Core\Billet as CoreBillet;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Billet extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (!$this->rbac->hasPrivilege('billet_module', 'can_view')) {
            access_denied();
        }

        $this->load->model('eloquent/Fee_type_eloquent');
        $this->session->set_userdata('top_menu', 'Boleto em Lote');
        $this->session->set_userdata('sub_menu', 'billet');
        $data['title'] = 'Boleto em lote';
        $data['title_list'] = 'Boleto em lotes';

        $data['listOfSeries'] = $this->class_model->get();
        $data['listOfMotive'] = Fee_type_eloquent::get()->pluck('type', 'id')->toArray();


        $this->load->view('layout/header', $data);
        $this->load->view('admin/billet/index', $data);
        $this->load->view('layout/footer', $data);
    }


    public function listOfFees()
    {
        //$data = $this->input->post();

        // $dateStart = '2021-01-01'; //implode('-', array_reverse(explode('/', $this->input->post('start'))));
        // $dateEnd = '2021-02-28'; //implode('-', array_reverse(explode('/', $this->input->post('end'))));
       
        $dateStart =implode('-', array_reverse(explode('/', $this->input->post('start'))));
        $dateEnd = implode('-', array_reverse(explode('/', $this->input->post('end'))));
        $this->load->model(['eloquent/Student_fee_item_eloquent']);

        // $_POST['classe_id'] ='todos';
        // $_POST['motive_id'] ='todos';

        $fee_item = new Student_fee_item_eloquent;
        $total = 0;
        $data  =   $fee_item->whereBetween('due_date', [$dateStart, $dateEnd])
            ->where(function ($q) {
               
                if (strtolower($this->input->post('classe_id')) != 'todos')
                   return $q->where('class_id', $this->input->post('classe_id'));
            })
            ->where(function ($q) {
                if (strtolower($this->input->post('motive_id')) != 'todos')
                   return $q->where('feetype_id', $this->input->post('motive_id'));

              
            })
            ->with(['deposite', 'session.student','billet'])
           
            ->select('student_fee_items.*')
            ->orderBy('student_fee_items.due_date','ASC')
            ->get()
            
            
            ->filter(function ($row) {
                return !$row->deposite  && $row->billet->count() == 0;
            })
            ->filter(function ($row) {
                return $row->session->student !== null;
            })
            ->map(function($row){
                $row->amount_raw =  $row->amount;
                $row->amount = number_format($row->amount,2,',', '.');
                $due_date = (new DateTime($row->due_date));
                $row->is_valid = $due_date > (new DateTime()) ;
                $row->due_date =  $due_date->format('d/m/Y');
              
                return $row;
            })
            ->groupBy('user_id')
            ->all();

        return new JsonResponse(compact('data'));
    }

    function generate()
    {
        $this->load->model(['eloquent/Student_fee_item_eloquent', 'eloquent/Billet_eloquent']);

        $data = Student_fee_item_eloquent::whereIn('id', $this->input->post('student_fee_item_id'))->with(['session.student'])->get();
        $items = [];
        foreach ($data as $item) {
            $userId = $item->session->student->id;

            if (!isset($items[$userId])) $items[$userId] = [];

            $items[$userId][] = [
                'fee_item_id' => $item->id,
                'user_id' => $userId,
                'price' => $item->amount,
                'fee_fine' => 0,
                'fee_discount' => 0,
                'fee_amount' =>  $item->amount,
                'due_date' => $item->due_date,
                'fee_line_1' => $item->title,
                'fee_line_2' => ''

            ];
        }
        $ids = [];
      
        // return new JsonResponse(['data' => $items , 'message' => $this->lang->line('bulk_billet_success_generate')]);
        foreach ($items as $id => $dataItems) {
            $ids =  array_merge($ids, (new CoreBillet)->create($dataItems, $id, true));
        }

        return new JsonResponse(['data' => $ids , 'message' => $this->lang->line('bulk_billet_success_generate')]);

        
    }
}
