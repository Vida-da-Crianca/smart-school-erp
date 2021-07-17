<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_address_number_for_guardian extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'guardian_address_number' => [
                'type' => 'varchar',
                'constraint' => 20,
                'default' => 'S/N',
                'after' => 'guardian_address',
            ],
            

           
        );
       
        $this->dbforge->add_column('sch_settings', $columns );
        $this->dbforge->add_column('students', $columns );
       
    }

    public function down()
    {  
        $columns = ['guardian_address_number'];
        foreach($columns as $v){
            $this->dbforge->drop_column('sch_settings', $v );
            $this->dbforge->drop_column('students', $v );
        }
        
    }
}
