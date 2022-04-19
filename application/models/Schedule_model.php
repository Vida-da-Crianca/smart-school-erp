<?php

class Schedule_model extends CI_Model
{
    public static $evacuacao = [
        1 => "Normal",
        2 => "Pastoso",
        3 => "Semipastoso",
        4 => "Nenhuma",
    ];

    public static $comportamento = [
        1 => "Ótimo",
        2 => "Bom",
        3 => "Regular",
        4 => "Rejeitou",
    ];

    public static $disposicao = [
        1 => "Normal",
        2 => "Agitado",
        3 => "Quieto",
    ];
    public static $boolean = [
        1 => "Sim",
        2 => "Não",
    ];

    public function __construct(){
        $this->load->dbforge();
        $this->load->model('firebase_model');
        $this->load->model('student_model');
        $this->recados_recentes_tabela();
        parent::__construct();
    }

    private function recados_recentes_tabela(){

        // Fixar agenda de sono
        $fix_sono = array(
            'acordou' => array(
                'type' => 'time',
                'null' => TRUE
            ),
            'dormiu' => array(
                'type' => 'time',
                'null' => TRUE
            )
        );
        $this->dbforge->modify_column('agenda_sono', $fix_sono);

        $campos = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unique' => TRUE,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'student_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ),
            'internal_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ),
            'agenda_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ),
            'tabela' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ),
        );

        $this->dbforge->add_field($campos);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('recados_recentes', true);
    }


    public function add($data)
    {
        return $this->db->insert('agendas', $data);
    }

    public function createAgendaBySnack($table, $data)
    {
        // Bloqueio hora do sono
        $dataPost = (object)$data;
        if($dataPost->snack_id == (5 || 6 || 7 || 12 || 13)){
            $data_agora = date('Y-m-d');
            $data_horarios = $this->db->query("SELECT * FROM agenda_sono WHERE student_id = '{$dataPost->student_id}' AND created_at >= '{$data_agora} 00:00:00' AND created_at <= '{$data_agora} 23:59:59'")->result_object();
            
            if($data_horarios){

                foreach($data_horarios as $data_result){
                    if(!empty($data_result->dormiu) && !empty($data_result->acordou) && isset($dataPost->horario)){
                        if($dataPost->horario >= $data_result->dormiu && $dataPost->horario <= $data_result->acordou){
                            $resp['status'] = false;
                            $resp['msg'] = 'Não é permitido cadastrar refeição no horario que o aluno estava dormindo.';
                            return $resp;
                        }
                    }

                    if(!empty($data_result->dormiu) && empty($data_result->acordou)){
                        if($dataPost->horario >= $data_result->dormiu){
                            $resp['status'] = false;
                            $resp['msg'] = 'Não é permitido cadastrar refeição no horario que o aluno esta dormindo.';
                            return $resp;
                        }
                    }
                }
            }
        }

        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function updateAgendaBySnack($id, $table, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    public function delete($id)
    {
        $this->db->where("id", $id)->delete("snacks");
    }

    public function get($id)
    {
        $this->db->select('agendas.*')
            ->from('agendas')->where('id', $id);
        $query = $this->db->get();
        $item = $query->row_array();
        return $item;

    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('snacks', $data);

    }

    public function list($filters, $groupBy = null)
    {
        $groupBy = $groupBy ?: 'student, snack_id, agendas.date';

        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->db->select("agendas.*, students.firstname, students.lastname, snacks.name as snack, snacks.id as snack_id, COALESCE(agenda_alimentacao.student_id, agenda_evacuacao.student_id, agenda_sono.student_id) as student")
            ->from('agendas')
            ->join('agenda_alimentacao', 'agendas.id = agenda_alimentacao.agenda_id', 'left')
            ->join('agenda_evacuacao', 'agendas.id = agenda_evacuacao.agenda_id', 'left')
            ->join('agenda_sono', 'agendas.id = agenda_sono.agenda_id', 'left')
            ->join('students', 'students.id = COALESCE(agenda_alimentacao.student_id, agenda_evacuacao.student_id, agenda_sono.student_id)', 'left')
            ->join('snacks', 'snacks.id = COALESCE(agenda_alimentacao.snack_id, agenda_evacuacao.snack_id, agenda_sono.snack_id)', 'left')
            ->group_by($groupBy);

        if (isset($filters['class_id']) && $filters['class_id']) {
            $this->db->where('agendas.class_teacher_id', $filters['class_id']);
        }
        if (isset($filters['date_start']) && $filters['date_start']) {
            $this->db->where('agendas.date >=', $filters['date_start']);
        }
        if (isset($filters['date_end']) && $filters['date_end']) {
            $this->db->where('agendas.date <=', $filters['date_end']);
        }
        if (isset($filters['snack_id']) && $filters['snack_id']) {
            $this->db->where('snacks.id', $filters['snack_id']);
        }

        if (isset($filters['student_id']) && $filters['student_id']) {
            $this->db->where('students.id', $filters['student_id']);
        }


        $query = $this->db->get();
        $item = $query->result_array();
        return $item;
    }

    public function getAgendaOldData($studentId, $agendaId, $table, $snackId = null)
    {
        $query = $this->db->select($table . '.*')
            ->from($table)
            ->where("student_id", $studentId);
        if ($snackId) {
            $query->where("snack_id", $snackId);
        }
        $query->where("agenda_id", $agendaId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRecados($id, $professor = false){
        
        if($professor)
            $this->db->select('*')->from('recados_recentes')->where('created_by', $id);
        else
            $this->db->select('*')->from('recados_recentes')->where('student_id', $id)->where('created_by', 0);
        
        $recados = $this->db->get();
        $recados = $recados->result_object();

        $retorna = array();

        if($recados){
            foreach($recados as $recado){
                $data = $this->db->query("SELECT * FROM {$recado->tabela} WHERE id = {$recado->internal_id}")->result_array();
                if($data){
                    
                    if(!empty($data[0]['message']) && !empty($data[0]['message_parent'])){
                        $this->db->delete('recados_recentes', array('id' => $recado->id));
                        continue;
                    }
                    
                    $data['tabela'] = $recado->tabela;
                    $data['internal_id'] = $recado->id;
                    $data['estudante'] = $this->student_model->get($recado->student_id);
                    array_push($retorna, $data);
                }
            }
        }

        return $retorna;
    }

    public function ajaxRecados($data){
        if(!isset($data['data']) || empty($data['data']))
            return ['result' => false, 'msg' => 'Parametrôs incorretos.'];
        if(count($data['data']) <= 0)
            return ['result' => false, 'msg' => 'Parametrôs incorretos.'];
        foreach($data['data'] as $recado){
            $this->db->delete('recados_recentes', array('id' => $recado['internal_id']));
            if(isset($recado['message']))
                $this->updateAgendaOld($recado['tabela'], (object)array('id' => $recado['id'], 'message' => $recado['message']));
            if(isset($recado['message_parent']))
                $this->updateAgendaOld($recado['tabela'], (object)array('id' => $recado['id'], 'message_parent' => $recado['message_parent']));
        }

        return ['result' => true];
    }



    public function updateAgendaOld($table, $data)
    {
        // Notificação
        $this->db->select('*')->from($table)->where('id', $data->id);
        $agenda_dados = $this->db->get();
        $agenda_dados = $agenda_dados->row_object();

        if(isset($data->dormiu) && isset($data->acordou)){
            if($data->dormiu > $data->acordou || $data->acordou < $data->dormiu){
                $resp['status'] = false;
                $resp['msg'] = 'O campo dormiu não pode ser maior que o campo acordou.<br>O campo acordou não pode ser menor que o campo dormiu.';
                return $resp; 
            }
        }
        // Bloqueio agenda
        if(isset($data->snack_id) && $data->snack_id == (5 || 6 || 7 || 12 || 13)){

            $data_agora = date('Y-m-d');
            $data_result = $this->db->query("SELECT * FROM agenda_sono WHERE student_id = '{$data->student_id}' AND created_at >= '{$data_agora} 00:00:00' AND created_at <= '{$data_agora} 23:59:59' ORDER BY created_at DESC")->row_object();

            if($data_result){

                if(!empty($data_result->dormiu) && !empty($data_result->acordou) && isset($data->horario)){
                    if($data->horario >= $data_result->dormiu && $data->horario <= $data_result->acordou){
                        $resp['status'] = false;
                        $resp['msg'] = 'Não é permitido cadastrar refeição no horario que o aluno estava dormindo.';
                        return $resp;
                    }
                }

                if(!empty($data_result->dormiu) && empty($data_result->acordou) && isset($data->horario)){
                    if($data->horario >= $data_result->dormiu){
                        $resp['status'] = false;
                        $resp['msg'] = 'Não é permitido cadastrar refeição no horario que o aluno esta dormindo.';
                        return $resp;
                    }
                }
            }
        }

        if(isset($agenda_dados->student_id)){
            $aluno = $this->db->query("SELECT firstname, lastname, parent_id FROM students WHERE id = '{$agenda_dados->student_id}' LIMIT 1")->row_object();

            if(isset($agenda_dados->message_parent) && isset($agenda_dados->message) && !empty($agenda_dados->message_parent) && !empty($agenda_dados->message)){

            } else {
                // Enviar notificação para o professor.
                if(isset($data->message_parent) && $agenda_dados->message_parent != $data->message_parent && !empty($data->message_parent)){
                    // Inserir recado na lista de recados
                    $this->db->insert('recados_recentes', array(
                        'student_id' => $agenda_dados->student_id,
                        'internal_id' => $data->id,
                        'agenda_id' => $agenda_dados->agenda_id,
                        'tabela' => $table,
                        'created_by' => $agenda_dados->created_by
                    ));
                    $user = $this->session->userdata('student')['username'];
                    $url_action = base_url() . "admin/schedule/view/{$agenda_dados->agenda_id}/{$agenda_dados->student_id}";
                    $this->firebase_model->sendNotification("Novo recado de {$user}", "Você recebeu um novo recado na agenda do(a) aluno(a) {$aluno->firstname} {$aluno->lastname}.\nRecado: {$data->message_parent}", $url_action, $agenda_dados->created_by, 'staff');
            
                }

                // Enviar notificação para o responsável
                else if(isset($data->message) && $agenda_dados->message != $data->message && !empty($data->message)){
                    // Inserir recado na lista de recados
                    $this->db->insert('recados_recentes', array(
                        'student_id' => $agenda_dados->student_id,
                        'internal_id' => $data->id,
                        'agenda_id' => $agenda_dados->agenda_id,
                        'tabela' => $table,
                        'created_by' => 0
                    ));
                    $user = $this->session->userdata('admin')['username'];
                    $url_action = base_url() . "user/user/scheduleShow/{$agenda_dados->agenda_id}/{$agenda_dados->student_id}";
                    $this->firebase_model->sendNotification("Novo recado do professor {$user}", "Você recebeu um novo recado do(a) professor(a) na agenda do(a) seu(sua) filh(a) {$aluno->firstname}.\nRecado: {$data->message}", $url_action, $aluno->parent_id, 'parent');
                }
            }
        }
        
        $this->db->where('id', $data->id);
        $update = $this->db->update($table, (array)$data);
        if($update)
            $resp['status'] = true;
        else
            $resp['status'] = false;

        return $resp;
        
    }

    public function getScheduleOrCreate($date, $staffId)
    {
        $this->db->select('agendas.*')
            ->from('agendas')
            ->where("date", $date)
            ->where("created_by", $staffId);
        $query = $this->db->get();
        $data = $query->row_array();
        if (!$data) {
            $lastId = $this->add([
                "date" => $date,
                "created_by" => $staffId,
            ]);
            $data = $this->get($lastId);
        }
        return $data;
    }
}

?>