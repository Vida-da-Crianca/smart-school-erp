
<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_class_id_in_student_fee_item extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'class_id' => [
                'type' => 'bigInt',
                'constraint' => 20,
                'null' => true,
                'after' => 'feetype_id',
            ],
           
        );
       
        $this->dbforge->add_column('student_fee_items', $columns );
       
    }

    public function down()
    {
        $this->dbforge->drop_column('student_fee_items', 'class_id');
    }
}
