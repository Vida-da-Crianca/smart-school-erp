<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_due_date_in_billet extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'due_date' => [
                'type' => 'date',
                'null' => true,
                'after' => 'is_active',
            ],
           
        );
        
        $this->dbforge->add_column('billets', $columns );
       
       
    }

    public function down()
    {    
        
        $this->dbforge->drop_column('billets', 'due_date');
    }
}
