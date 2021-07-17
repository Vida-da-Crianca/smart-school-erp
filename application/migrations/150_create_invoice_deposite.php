<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoice_deposite extends CI_Migration
{
    protected $table_name = 'invoice_deposite';
    public function up()
    {
        $this->dbforge->add_field(array(
            
            'deposite_id' => array(
                'type' => 'bigint',
                'constraint' => 15,
            ),
            'invoice_id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
            ),
           
        ));
        $this->dbforge->add_key('deposite_id');
        $this->dbforge->add_key('invoice_id');
        $this->dbforge->create_table($this->table_name);
        
        $sqlReset = "ALTER TABLE `student_fees_deposite`
        CHANGE `id` `id` bigint NOT NULL AUTO_INCREMENT FIRST; ";
        $this->db->query($sqlReset);

        $sqlReset2 = "ALTER TABLE `invoices`
        CHANGE `id` `id` bigint NOT NULL AUTO_INCREMENT FIRST; ";
        $this->db->query($sqlReset);
        $this->db->query($sqlReset2);
        $sql = "
        ALTER TABLE {$this->table_name}
        ADD CONSTRAINT fk_{$this->table_name}_invoice_id
        FOREIGN KEY (invoice_id) REFERENCES invoices(id) 
        ON UPDATE CASCADE
        ON DELETE CASCADE;
        ";
        $sql2 = "
        ALTER TABLE {$this->table_name}
        ADD CONSTRAINT fk_{$this->table_name}_deposite_id
        FOREIGN KEY (deposite_id) REFERENCES student_fees_deposite(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE;
        ";

        $this->db->query($sql);
        $this->db->query($sql2);
    }

    public function down()
    {   
        $sqlReset = "ALTER TABLE `invoice_deposite`
        CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST;";
    
        // $this->db->query("ALTER TABLE `billet_deposite` DROP FOREIGN KEY('fk_".$this->table_name."_billet_id')");
        // $this->db->query($sqlReset);
        $this->dbforge->drop_table($this->table_name);
    }
}
