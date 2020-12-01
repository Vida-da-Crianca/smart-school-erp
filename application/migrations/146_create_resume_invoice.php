<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_resume_invoice extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'total' => [
                'type' => 'DOUBLE',
                'constraint' => '15,2',
            ],
            'due_date'=> [
                'type' => 'DATE',
            ]
        ));
        $this->dbforge->add_key('due_date', TRUE);
        $this->dbforge->create_table('invoice_resume');
    }

    public function down()
    {
        $this->dbforge->drop_table('invoice_resume');
    }
}
