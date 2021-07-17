<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_billet extends CI_Migration
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
            'bank_bullet_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true
            ),
            'price' => array(
                'type' => 'DOUBLE',
                'constraint' => '15,2',
                'default' => '0.00'
            ),
            'body' => array(
                'type' => 'TEXT',               
                'null' => true
            ),
            'status' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => 'AGUARDANDO PAGAMENTO'
            ),
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
            'invoice_id' => array(
                'type' => 'INT',
                'constraint' => 15,
                'null' => TRUE
            ),
            'received_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
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
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('billets');
    }

    public function down()
    {
        $this->dbforge->drop_table('billets');
    }
}
