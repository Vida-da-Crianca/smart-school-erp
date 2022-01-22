<?php
class Curriculo_model extends MY_Model
{

    public function __construct()
    {
        $this->load->dbforge();
        // Adjust table cl_cv
        if(!$this->db->field_exists('foto', 'cl_curriculos')){
            $fields = array('foto' => array('type' => 'TEXT'));
            $this->dbforge->add_column('cl_curriculos', $fields);
        }

        parent::__construct();
    }

    public function getDepartment($id)
    {
        $query = $this->db->select('*')->where("is_active", "yes")->where("id", $id)->order_by('department_name','asc')->get('department');
        return $query->row_object();
    }

    public function getDesignation($id)
    {

        $query = $this->db->select('*')->where("is_active", "yes")->where("id", $id)->order_by('designation','asc')->get("staff_designation");
        return $query->row_object();
    }

    public function getWhatsapp($telefone){
        $nf = str_replace(array(" ", "(", ")", "+", "-", "55"), "", $telefone);
        return "+55{$nf}";
    }

    public function masc_tel($TEL) {
        $tam = strlen(preg_replace("/[^0-9]/", "", $TEL));
        if ($tam == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
            return "+".substr($TEL,0,$tam-11)."(".substr($TEL,$tam-11,2).")".substr($TEL,$tam-9,5)."-".substr($TEL,-4);
        }
        if ($tam == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
            return "+".substr($TEL,0,$tam-10)."(".substr($TEL,$tam-10,2).")".substr($TEL,$tam-8,4)."-".substr($TEL,-4);
        }
        if ($tam == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
            return "(".substr($TEL,0,2).")".substr($TEL,2,5)."-".substr($TEL,7,11);
        }
        if ($tam == 10) { // COM CÓDIGO DE ÁREA NACIONAL
            return "(".substr($TEL,0,2).")".substr($TEL,2,4)."-".substr($TEL,6,10);
        }
        if ($tam <= 9) { // SEM CÓDIGO DE ÁREA
            return substr($TEL,0,$tam-4)."-".substr($TEL,-4);
        }
    }

    public function calcularIdade($data){
        $idade = 0;
        $data_nascimento = date('Y-m-d', strtotime($data));
        list($anoNasc, $mesNasc, $diaNasc) = explode('-', $data_nascimento);

        $idade      = date("Y") - $anoNasc;
        if (date("m") < $mesNasc){
            $idade -= 1;
        } elseif ((date("m") == $mesNasc) && (date("d") <= $diaNasc) ){
            $idade -= 1;
        }

        return $idade;
    }

    public function uniqueId(){

        $id = random_int(1000, 100000);

        $staff_exist = $this->db->select()->from('staff')->where('id', $id)->count_all_results();
        $cl_exist = $this->db->select()->from('cl_curriculos')->where('id', $id)->count_all_results();

        if($staff_exist > 0 || $cl_exist > 0)
            return $this->uniqueId();

        return $id;


    }

    public function batchInsert($data){
        $this->db->trans_start();
        $this->db->trans_strict(false);

        $this->db->insert('cl_curriculos', $data);

        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $this->db->insert_id();
        }
    }

    public function update($id, $data){
        $this->db->trans_start();
        $this->db->trans_strict(false);

        $this->db->where('id', $id);
        $query = $this->db->update('cl_curriculos', $data);
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }

        if($query)
            return true;
        else
            return false;
    }

    public function delete($id, $foto = null){
        $this->db->trans_start();
        $this->db->trans_strict(false);

        $this->db->where('id', $id);
        $query_cv = $this->db->delete('cl_curriculos');
        $this->db->where('belong_table_id', $id);
        $query_custom_fields = $this->db->delete('custom_field_values');

        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE || $query_cv || $query_custom_fields){
            $this->db->trans_rollback();
            return false;
        }

        if($foto != null){
            if(file_exists("./uploads/cv_images/{$foto}")){
                @unlink("./uploads/cv_images/{$foto}");
            }
        }

        if($query_cv && $query_custom_fields)
            return true;

        return false;

    }

    public function getData($data){
        if(empty($data))
            return "";

        $datas = explode("/", $data);

        $day = $datas[0];
        $month = $datas[1];
        $year = $datas[2];

        return $year.'-'.$month.'-'.$day;
    }

}
