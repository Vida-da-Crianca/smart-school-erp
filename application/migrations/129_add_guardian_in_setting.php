<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_guardian_in_setting extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'guardian_document' => [
                'type' => 'int',
                'constraint' => 15,
                'default' => 1,
                'after' => 'guardian_email',
            ],
           
        );
       
        $this->dbforge->add_column('sch_settings', $columns );
       
    }

    public function down()
    {
        $this->dbforge->drop_column('sch_settings', 'guardian_document');
    }
}
