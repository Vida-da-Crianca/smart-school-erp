<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoice extends CI_Migration
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
            'logger' => array(
                'type' => 'TEXT',
                
                'null' => true
            ),
            'action' => array(
                'type' => 'VARCHAR',
                'constraint' => 80,
            ),

            'table' => array(
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => true
            ),
            'register_id' => array(
                'type' => 'INT',
                'constraint' => 80,
                'null' => true
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
        $this->dbforge->create_table('invoice_logs');
    }

    public function down()
    {
        $this->dbforge->drop_table('invoice_logs');
    }
}
