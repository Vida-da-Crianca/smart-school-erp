<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_fee_moura_in_payment  extends CI_Migration
{
    protected $table = 'payment_settings';

    public function up()
    {
        $columns = array(

            'pay_fine' => [
                'type' => 'varchar',
                'constraint' => 15,
                'null' => true,
                'after' => 'paytm_website',
            ],
            'pay_moura' => [
                'type' => 'varchar',
                'constraint' => 10,
                'null' => true,
                'after' => 'paytm_website',
            ],

        );

        $this->dbforge->add_column($this->table, $columns);
    }

    public function down()
    {
        $columns = ['pay_moura', 'pay_fine'];
        foreach ($columns as $v) {
            $this->dbforge->drop_column($this->table, $v);
        }
    }
}
