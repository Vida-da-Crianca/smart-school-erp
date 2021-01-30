<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_description_in_invoice extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'description' => [
                'type' => 'text',
                'null' => true,
                'after' => 'student_fees_deposite_id',
            ],
           
        );
        
        $this->dbforge->add_column('invoices', $columns );
        
       
    }

    public function down()
    {    
       
        $this->dbforge->drop_column('invoices', 'description');
    }
}
