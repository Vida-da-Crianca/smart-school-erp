<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_guardian_student extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'guardian_document' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'after' => 'guardian_email',
            ],
            'mother_document' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'after' => 'mother_phone',
            ],
            'father_document' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'after' => 'father_phone',
            ],
            
        );
       
        $this->dbforge->add_column('students', $columns );
       
    }

    public function down()
    {
        $columns = ['father_document' , 'mother_document', 'guardian_document'];
        foreach($columns as $v){
            $this->dbforge->drop_column('students', $v );
        }
        
    }
}
