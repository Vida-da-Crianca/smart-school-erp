<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_custom_number_in_billet extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'custom_number' => [
                'type' => 'varchar',
                'constraint' => 16,
                'null' => true,
                'after' => 'id',
            ],
           
        );
        
        $this->dbforge->add_column('billets', $columns );
       
       
    }

    public function down()
    {    
        
        $this->dbforge->drop_column('billets', 'custom_number');
    }
}
