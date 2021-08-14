<?php


defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package mailer
 * @author Carlos Carvalho <contato@carlosocarvalho.com.br>
 */
class Migration_Create_mailer extends CI_Migration
{
    protected $table_name = 'mailers';
    public function up()
    {
        $this->dbforge->add_field(array(

            'id' => array(
                'type' => 'bigint',
                'constraint' => 32,
                'unsigned' => TRUE,
                'auto_increment' => true
            ),
            'subject' => array(
                'type' => 'varchar',
                'constraint' => 120,
            ),
            'from' => array(
                'type' => 'varchar',
                'constraint' => 120,
            ),
            'to' => array(
                'type' => 'varchar',
                'constraint' => 120,
            ),
            'message' => array(
                'type' => 'longtext',
            ),
            'retry' => array(
                'type' => 'int',
                'constraint' => 11,
            ),
            'max_retry' => array(
                'type' => 'int',
                'constraint' => 11,
                'default' => 3
            ),
            'sended_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($this->table_name);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->table_name);
    }
}
