<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_due_date_in_invoice extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'due_date' => [
                'type' => 'date',
                'null' => true,
                'after' => 'status',
            ],
           
        );
        
        $this->dbforge->add_column('invoices', $columns );
       
       
    }

    public function down()
    {    
        
        $this->dbforge->drop_column('invoices', 'due_date');
    }
}
