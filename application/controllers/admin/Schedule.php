<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Schedule extends Admin_Controller
{

    public $sch_setting_detail = array();

    public function __construct()
    {
        parent::__construct();

        $this->config->load('app-config');
        $this->load->model('schedule_model');
        $this->load->model('snack_model');
        $this->load->model('student_model');
        $this->load->model("classteacher_model");
        $this->role;
    }

    public function index()
    {

        if (!$this->rbac->hasPrivilege('schedule', 'can_view')) {
            access_denied();
        }
        $data = array();
        $this->session->set_userdata('top_menu', 'schedule');
        $this->session->set_userdata('sub_menu', 'admin/schedule');



        $data['classes'] = $this->classteacher_model->getClassFullByUser($this->session->userdata('admin')["id"]);
        $data['snacks'] = array_map(function ($item) {
            return (object)$item;
        }, $this->snack_model->all());
        $filters =  $this->input->get();
        $data['agendas'] =  count($filters) ? $this->schedule_model->list($filters) : [];

        $this->load->view('layout/header', $data);
        $this->load->view('admin/schedule/schedule_list', $data);
        $this->load->view('layout/footer', $data);
    }

    public function create()
    {
        if (!$this->rbac->hasPrivilege('schedule', 'can_add')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'snacks');
        $this->session->set_userdata('sub_menu', 'admin/schedule/create');
        $data = array();
        $data['snacks'] = array_map(function ($item) {
            return (object)$item;
        }, $this->snack_model->all());

        $data['schedule'] = (object)['id' => 0, 'name' => null];
        $data['classes'] = $this->classteacher_model->getClassFullByUser($this->session->userdata('admin')["id"]);
        $this->load->view('layout/header', $data);
        $this->load->view('admin/schedule/schedule_frm', $data);
        $this->load->view('layout/footer', $data);
    }

    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('schedule', 'can_view')) {
            access_denied();
        }

    }

    function studentsBySnackId($id)
    {
        $snackId = $id;
        $data = json_decode(file_get_contents('php://input'));

        $classTeach = (object)$this->classteacher_model->getClassTeacher($data->class_id);
        $result = $this->student_model->bySnack($snackId, $classTeach->class_id, $classTeach->section_id, $classTeach->session_id);
        echo json_encode($result);
    }

    function getScheduleOrCreate()
    {
        $data = json_decode(file_get_contents('php://input'));
        $classId = $data->class_id;
        $date = $data->date;
        $userId = $this->session->userdata('admin')["id"];
        $result = $this->schedule_model->getScheduleOrCreate($classId, $date, $userId);


        echo json_encode($result);
    }

    function saveAgenda()
    {
        $data = json_decode(file_get_contents('php://input'));
        $student = $data->student;
        $snack = $student->snack;
        $agenda = $student->agenda;
        $result = [];
        if ($snack->code == "alimentacao") {
            $payload = [
                "horario" => $agenda->alimentacao->horario,
                "comportamento" => $agenda->alimentacao->comportamento,
                "agenda_id" => $student->agenda_id,
                "snack_id" => $snack->id,
                "student_id" => $student->id,
                "created_by" => $this->session->userdata('admin')["id"],
            ];
            $result = $this->schedule_model->createAgendaBySnack("agenda_alimentacao", $payload);
        } elseif ($snack->code == "sono") {
            $payload = [
                "dormiu" => $agenda->sono->dormiu ?? date('H:i'),
                "acordou" => $agenda->sono->acordou ?? date('H:i'),
                "agenda_id" => $student->agenda_id,
                "snack_id" => $snack->id,
                "student_id" => $student->id,
                "created_by" => $this->session->userdata('admin')["id"],
            ];
            $result = $this->schedule_model->createAgendaBySnack("agenda_sono", $payload);
        } elseif ($snack->code == "evacuacao") {
            $payload = [
                "textura" => $agenda->evacuacao->textura,
                "banho" => $agenda->evacuacao->banho,
                "disposicao" => $agenda->evacuacao->disposicao,
                "agenda_id" => $student->agenda_id,
                "snack_id" => $snack->id,
                "student_id" => $student->id,
                "created_by" => $this->session->userdata('admin')["id"],
            ];
            $result = $this->schedule_model->createAgendaBySnack("agenda_evacuacao", $payload);
        }

        echo json_encode($result);
    }

    function updateAgenda()
    {
        $data = json_decode(file_get_contents('php://input'));
        $table  = "agenda_".$data->snack_code;
        $result = $this->schedule_model->updateAgendaOld($table, $data->data);
        echo json_encode($result);
    }

    function getAgendaOldData()
    {
        $data = json_decode(file_get_contents('php://input'));
        $studentId = $data->student_id;
        $agendaId = $data->agenda_id;
        $snackId = $data->snack_id;
        $table = 'agenda_'.$data->snack_code;
        $result = $this->schedule_model->getAgendaOldData($studentId, $agendaId, $snackId, $table);

        echo json_encode($result);
    }


}