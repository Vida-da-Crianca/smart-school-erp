<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_process_control extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
                'unsigned' => TRUE,
                'auto_increment' => true

            ),
          
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 80,
            ),

            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => 80,
            ),

            'timeout' => array(
                'type' => 'INT',
                'constraint' => 80,
                'null' => true,
                'default' =>   180
            ),
          
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
           
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('schedule_controls', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('schedule_controls');
    }
}
