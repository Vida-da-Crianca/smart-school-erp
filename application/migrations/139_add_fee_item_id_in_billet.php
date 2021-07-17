<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_fee_item_id_in_billet extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'fee_item_id' => [
                'type' => 'int',
                'constraint' => 15,
                'null' => true,
                'after' => 'is_active',
            ],
           
        );
        
        $this->dbforge->add_column('billets', $columns );
        $columns = ['fee_groups_feetype_id', 'fee_master_id', 'fee_session_group_id'];
        foreach($columns as $v){
            $this->dbforge->drop_column('billets', $v );
        }
       
    }

    public function down()
    {    
        $columns = [
            'fee_groups_feetype_id' => array(
                'type' => 'INT',
                'constraint' => 15,
            ),
            'fee_master_id' => [
                'type' => 'INT',
                'constraint' => 15,
            ],
            'fee_session_group_id' => [
                'type' => 'INT',
                'constraint' => 15,
            ],
        ];
        $this->dbforge->add_column('billets', $columns );
        $this->dbforge->drop_column('billets', 'fee_item_id');
    }
}
