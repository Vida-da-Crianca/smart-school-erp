<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_guardian_fields_in_setting extends CI_Migration
{

    public function up()
    {
        $columns = array(
            
            'guardian_postal_code' => [
                'type' => 'int',
                'constraint' => 15,
                'default' => 1,
                'after' => 'guardian_document',
            ],
            'guardian_district' => [
                'type' => 'int',
                'constraint' => 15,
                'default' => 1,
                'after' => 'guardian_document',
            ],
            'guardian_city' => [
                'type' => 'int',
                'constraint' => 15,
                'default' => 1,
                'after' => 'guardian_document',
               
            ],
            'guardian_state' => [
                'type' => 'int',
                'constraint' => 15,
                'default' => 1,
                'after' => 'guardian_document',
            ],

           
        );
       
        $this->dbforge->add_column('sch_settings', $columns );
       
    }

    public function down()
    {  
        $columns = ['guardian_postal_code', 'guardian_city', 'guardian_state','guardian_district'];
        foreach($columns as $v){
            $this->dbforge->drop_column('sch_settings', $v );
        }
        
    }
}
