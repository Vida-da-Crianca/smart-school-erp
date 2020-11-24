<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_drop_fee_item_id_billet extends CI_Migration
{

    public function up()
    {
        
        $this->dbforge->drop_column('billets', 'fee_item_id' );
       
    }

    public function down()
    {  
        
        
    }
}
