<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_payment_id_in_invoice extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'student_fees_deposite_id' => [
                'type' => 'bigInt',
                'constraint' => 20,
                'null' => true,
                'after' => 'status',
            ],
           
        );
       
        $this->dbforge->add_column('invoices', $columns );
       
    }

    public function down()
    {
        $this->dbforge->drop_column('invoices', 'student_fees_deposite_id');
    }
}
