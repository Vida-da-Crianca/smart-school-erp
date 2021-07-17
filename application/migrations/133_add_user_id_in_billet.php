<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_user_id_in_billet extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'user_id' => [
                'type' => 'int',
                'constraint' => 15,
                'after' => 'id',
            ],
           
        );
       
        $this->dbforge->add_column('billets', $columns );
       
    }

    public function down()
    {
        $this->dbforge->drop_column('billets', 'user_id');
    }
}
