<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_guardian_fields_in_student extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'guardian_postal_code' => [
                'type' => 'varchar',
                'constraint' => 15,
                'null' => true,
                'after' => 'guardian_document',
            ],
            'guardian_district' => [
                'type' => 'varchar',
                'constraint' => 32,
                'null' => true,
                'after' => 'guardian_document',
            ],
            'guardian_city' => [
                'type' => 'varchar',
                'constraint' => 20,
                'null' => true,
                'after' => 'guardian_document',
               
            ],
            'guardian_state' => [
                'type' => 'char',
                'constraint' => 2,
                'null' => true,
                'after' => 'guardian_document',
            ],

           
        );
       
        $this->dbforge->add_column('students', $columns );
       
    }

    public function down()
    {  
        $columns = ['guardian_postal_code', 'guardian_city', 'guardian_state','guardian_district'];
        foreach($columns as $v){
            $this->dbforge->drop_column('students', $v );
        }
        
    }
}
