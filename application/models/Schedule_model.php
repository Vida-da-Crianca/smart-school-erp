<?php

class Schedule_model extends CI_Model
{
    public static $evacuacao = [
        1 => "Normal",
        2 => "Pastoso",
        3 => "Semipastoso",
    ];

    public static $comportamento = [
        1 => "Regular",
        2 => "Ótimo",
        3 => "Recusou",
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
        return $this->db->insert($table, $data);
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

    public function list($filters)
    {
        $this->db->select("agendas.*, students.firstname, students.lastname, snacks.name as snack, snacks.id as snack_id")
            ->from('agendas')
            ->join('agenda_alimentacao', 'agendas.id = agenda_alimentacao.agenda_id', 'left')
            ->join('agenda_evacuacao', 'agendas.id = agenda_evacuacao.agenda_id', 'left')
            ->join('agenda_sono', 'agendas.id = agenda_sono.agenda_id', 'left')
            ->join('students', 'students.id = COALESCE(agenda_alimentacao.student_id, agenda_evacuacao.student_id, agenda_sono.student_id)', 'left')
            ->join('snacks', 'snacks.id = COALESCE(agenda_alimentacao.snack_id, agenda_evacuacao.snack_id, agenda_sono.snack_id)', 'left');
        $query = $this->db->get();
        $item = $query->result_array();
        return $item;
    }

    public function getAgendaOldData($studentId, $agendaId, $snackId, $table)
    {
        $this->db->select($table.'.*')
            ->from($table)
            ->where("student_id", $studentId)
            ->where("snack_id", $snackId)
            ->where("agenda_id", $agendaId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateAgendaOld($table, $data)
    {
        $this->db->where('id', $data->id);
        return $this->db->update($table, (array)$data);
    }

    public function getScheduleOrCreate($classTeacherId, $date, $staffId)
    {
        $this->db->select('agendas.*')
            ->from('agendas')
            ->where("class_teacher_id", $classTeacherId)
            ->where("date", $date)
            ->where("created_by", $staffId);
        $query = $this->db->get();
        $data = $query->row_array();
        if (!$data) {
            $lastId = $this->add([
                "date" => $date,
                "created_by" => $staffId,
                "class_teacher_id" => $classTeacherId,
            ]);
            $data = $this->get($lastId);
        }
        return $data;
    }


}

?>