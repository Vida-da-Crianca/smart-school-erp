<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_student_fee_item extends CI_Migration
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
            'user_id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
            ),
            'feetype_id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,         
            ),
            'amount' => array(
                'type' => 'DOUBLE',
                'constraint' => '15,2',
                'default' => '0.00'
            ),
            'student_fees_deposite_id' => array(
                'type' => 'bigInt',
                'constraint' => 15,
                'null' => TRUE
            ),
            'fee_session_group_id' => [
                'type' => 'INT',
                'constraint' => 15,
            ],
            'student_session_id' => [
                'type' => 'INT',
                'constraint' => 15,
            ],
            'received_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'due_date' => array(
                'type' => 'DATE',
                
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('student_fee_items');
    }

    public function down()
    {
        $this->dbforge->drop_table('student_fee_items');
    }
}
