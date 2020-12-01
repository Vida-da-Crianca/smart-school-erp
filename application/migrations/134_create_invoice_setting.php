<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoice_setting extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'value'=> [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ]
        ));
        $this->dbforge->add_key('label', TRUE);
        $this->dbforge->create_table('invoice_settings');
    }

    public function down()
    {
        $this->dbforge->drop_table('invoice_settings');
    }
}
