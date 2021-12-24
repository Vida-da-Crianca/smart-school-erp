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
        date_default_timezone_set('America/Sao_Paulo');
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

        $teacherIsAdmin = isset($this->session->userdata('admin')['roles']['Super Admin']) ? null : $this->session->userdata('admin')["id"];

        $data['students'] = $this->student_model->getStudentsByTeacher($teacherIsAdmin);
        $data['snacks'] = array_map(function ($item) {
            return (object)$item;
        }, $this->snack_model->all());
        $filters = $this->input->get();
        $data['agendas'] = count($filters) ? $this->schedule_model->list($filters) : [];

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

    public function view($agendaId, $studentId)
    {
        if (!$this->rbac->hasPrivilege('schedule', 'can_view')) {
            access_denied();
        }
        $agenda = $this->schedule_model->get($agendaId);
        $student = $this->student_model->get($studentId);
        $content =  array();
        $data = array();
        foreach (Snack_model::$tipos as $key => $tipo) {
            $items = $this->schedule_model->getAgendaOldData($studentId, $agendaId, 'agenda_' . $key);
            if (count($items)) {
                $content[$key] = $items;
            }
        }
        $agenda["content"] =  $content;
        $data["agenda"] = $agenda;
        $data["student"] = $student;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/schedule/schedule_view', $data);
        $this->load->view('layout/footer', $data);

    }

    function studentsBySnackId($id)
    {
        $snackId = $id;
        $data = json_decode(file_get_contents('php://input'));
        $classIds = [];
        $sectionIds =  [];
        $sessionIds = [];
        foreach ($data->class_id as $classId){
            $classTeacher = (object)$this->classteacher_model->getClassTeacher($classId);
            $classIds[] =  $classTeacher->class_id;
            $sectionIds[] =  $classTeacher->section_id;
            $sessionIds[] =  $classTeacher->session_id;
        }
        $result = $this->student_model->bySnackTeacher($snackId, $this->session->userdata('admin')["id"], $classIds, $sectionIds, $sessionIds);
        echo json_encode($result);
    }

    function getScheduleOrCreate()
    {
        $data = json_decode(file_get_contents('php://input'));
        $date = $data->date;
        $userId = $this->session->userdata('admin')["id"];
        $result = $this->schedule_model->getScheduleOrCreate($date, $userId);


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
                "created_at" => date('Y-m-d H:i:s'),

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
                "created_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->schedule_model->createAgendaBySnack("agenda_sono", $payload);
        } elseif ($snack->code == "evacuacao") {
            $payload = [
                "textura" => $agenda->evacuacao->textura,
                "agenda_id" => $student->agenda_id,
                "snack_id" => $snack->id,
                "student_id" => $student->id,
                "created_by" => $this->session->userdata('admin')["id"],
                "created_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->schedule_model->createAgendaBySnack("agenda_evacuacao", $payload);
        } elseif ($snack->code == "banho") {
            $payload = [
                "value" => $agenda->banho->value,
                "agenda_id" => $student->agenda_id,
                "snack_id" => $snack->id,
                "student_id" => $student->id,
                "created_by" => $this->session->userdata('admin')["id"],
                "created_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->schedule_model->createAgendaBySnack("agenda_banho", $payload);
        }

        echo json_encode($result);
    }

    function updateAgenda()
    {
        $data = json_decode(file_get_contents('php://input'));
        $table = "agenda_" . $data->snack_code;
        $result = $this->schedule_model->updateAgendaOld($table, $data->data);
        echo json_encode($result);
    }

    function getAgendaOldData()
    {
        $data = json_decode(file_get_contents('php://input'));
        $studentId = $data->student_id;
        $agendaId = $data->agenda_id;
        $snackId = $data->snack_id;
        $table = 'agenda_' . $data->snack_code;
        $result = $this->schedule_model->getAgendaOldData($studentId, $agendaId, $table, $snackId,);

        echo json_encode($result);
    }


}