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
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 15,
            ),
            'bullet_id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
            ),
            'price' => array(
                'type' => 'DOUBLE',
                'constraint' => '15,2',
                'default' => '0.00'
            ),
            'aliquota' => array(
                'type' => 'DOUBLE',
                'constraint' => '15,2',
                'default' => '0.00'
            ),
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'autenticidade'=> [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'body' => array(
                'type' => 'TEXT',               
                'null' => true
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => 'VALIDA'
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
             ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('invoices');
    }

    public function down()
    {
        $this->dbforge->drop_table('invoices');
    }
}
