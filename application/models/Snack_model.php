<?php

class Snack_model extends CI_Model
{

    public function add($data)
    {
        $this->db->insert('snacks', $data);
    }

    public function delete($id)
    {
        $this->db->where("id", $id)->delete("snacks");
    }

    public function get($id)
    {
        $this->db->select('snacks.*')
            ->from('snacks')->where('id', $id);
        $query = $this->db->get();
        $item = $query->row_array();
        return $item;

    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('snacks', $data);

    }

    public function all(){
        $this->db->select('snacks.*')
            ->from('snacks');
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>