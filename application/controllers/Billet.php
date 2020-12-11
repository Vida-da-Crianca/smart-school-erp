<?php

use Application\Core\JsonResponse;

class Billet  extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function preview()
    {
        $data = (object) [
            'name' => 'Carlos',
            'link' => '',
            'code' => '07790001161202626800806301701675384730000049800',
            'file' => '',
            'due_date' =>  new DateTime(),
            'items' => [
                (object) [
                    'name' => 'Maria Julia',
                    'billet' => '00630170167',
                    'due_date' => new DateTime(),
                    'description' => 'Parcela 1',
                    'price' => 100
                ]
            ]
        ];
        $this->load->view('mailer/billet.tpl.php', $data);
    }


    public function live($id)
    {
        try {

            $this->load->library('bank_payment_inter');
            $this->bank_payment_inter->show($id);
        } catch (Exception $e) {
            return new JsonResponse(json_decode($e->getMessage(), true), 404);
        }
    }


    public function aluno(){
        $this->load->model('eloquent/migrate/Aluno_eloquent');
        // dump(Aluno_eloquent::all());
        return new JsonResponse(Aluno_eloquent::limit(1)->with(['guardian'])->get()->toArray());
    }
}
