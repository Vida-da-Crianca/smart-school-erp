<?php

class Schedule_model extends CI_Model
{
    public static $evacuacao = [
        1 => "Normal",
        2 => "Pastoso",
        3 => "Semipastoso",
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


    public function add($data)
    {
        return $this->db->insert('agendas', $data);
    }

    public function createAgendaBySnack($table, $data)
    {
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

    public function updateAgendaOld($table, $data)
    {
        $this->db->where('id', $data->id);
        return $this->db->update($table, (array)$data);
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