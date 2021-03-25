<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_fee_id_in_fee_deposite extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'student_fees_id' => [
                'type' => 'bigInt',
                'constraint' => 20,
                'null' => true,
                'after' => 'fee_groups_feetype_id',
            ],
           
        );
       
        $this->dbforge->add_column('student_fees_deposite', $columns );
       
    }

    public function down()
    {
        $this->dbforge->drop_column('student_fees_deposite', 'student_fees_id');
    }
}
