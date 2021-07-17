<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_billet_deposite extends CI_Migration
{
    protected $table_name = 'billet_student_fee_item';
    public function up()
    {
        $this->dbforge->add_field(array(
            
            'fee_item_id' => array(
                'type' => 'bigint',
                'constraint' => 15,
            ),
            'billet_id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
            ),
           
        ));
        $this->dbforge->add_key('fee_item_id');
        $this->dbforge->add_key('billet_id');
        $this->dbforge->create_table($this->table_name);
        
        $sqlReset = "ALTER TABLE `billets`
        CHANGE `id` `id` bigint NOT NULL AUTO_INCREMENT FIRST; ";
        $this->db->query($sqlReset);

        $sqlReset2 = "ALTER TABLE `student_fee_items`
        CHANGE `id` `id` bigint NOT NULL AUTO_INCREMENT FIRST; ";
        $this->db->query($sqlReset);
        $this->db->query($sqlReset2);
        $sql = "
        ALTER TABLE {$this->table_name}
        ADD CONSTRAINT fk_{$this->table_name}_billet_id
        FOREIGN KEY (billet_id) REFERENCES billets(id) 
        ON UPDATE CASCADE
        ON DELETE CASCADE;
        ";
        $sql2 = "
        ALTER TABLE {$this->table_name}
        ADD CONSTRAINT fk_{$this->table_name}_fee_item_id
        FOREIGN KEY (fee_item_id) REFERENCES student_fee_items(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE;
        ";

        $this->db->query($sql);
        $this->db->query($sql2);
    }

    public function down()
    {   
        $sqlReset = "ALTER TABLE `billets`
        CHANGE `id` `id` bigint unsigned NOT NULL AUTO_INCREMENT FIRST;";
    
        // $this->db->query("ALTER TABLE `billet_deposite` DROP FOREIGN KEY('fk_".$this->table_name."_billet_id')");
        // $this->db->query($sqlReset);
        $this->dbforge->drop_table($this->table_name);
    }
}
