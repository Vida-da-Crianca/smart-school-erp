<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_sended_mail_at  extends CI_Migration
{
    protected $table = 'billets';

    public function up()
    {
        $columns = array(

            
            'sended_mail_at' => [
                'type' => 'datetime',
                'null' => true,
               
            ],

        );

        $this->dbforge->add_column($this->table, $columns);
    }

    public function down()
    {
        $columns = ['sended_mail_at'];
        foreach ($columns as $v) {
            $this->dbforge->drop_column($this->table, $v);
        }
    }
}
