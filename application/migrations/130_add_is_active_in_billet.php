<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_is_active_in_billet extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'is_active' => [
                'type' => 'int',
                'constraint' => 15,
                'default' => 1,
                'after' => 'status',
            ],
           
        );
       
        $this->dbforge->add_column('billets', $columns );
       
    }

    public function down()
    {
        $this->dbforge->drop_column('billets', 'is_active');
    }
}
