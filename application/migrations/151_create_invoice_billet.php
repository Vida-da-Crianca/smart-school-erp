<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoice_billet extends CI_Migration
{
    protected $table_name = 'invoice_billet';
    public function up()
    {   
        
        $this->dbforge->add_field(array(
            
            'billet_id' => array(
                'type' => 'bigint',
                'constraint' => 15,
            ),
            'invoice_id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
            ),
           
        ));
        $this->dbforge->add_key('billet_id');
        $this->dbforge->add_key('invoice_id');
        $this->dbforge->create_table($this->table_name);
        
        $sqlReset = "ALTER TABLE `billets`
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
        ADD CONSTRAINT fk_{$this->table_name}_billet_id
        FOREIGN KEY (billet_id) REFERENCES billets(id)
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
