<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_Documents extends CI_Migration
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('eloquent/GroupPermission');
    }

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'bigInt',
                'constraint' => 32,
                'unsigned' => TRUE,
                'auto_increment' => true

            ),
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 120

            ],
            'body' => [
                'type' => 'TEXT',

            ],
            'is_active' => [
                'type' => 'INT',
                'default' => 1
            ],

            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('documents');



        \GroupPermission::updateOrCreate([
            'short_code' => 'document_generate',

        ],  [
            'name' => 'Documentos',
            'short_code' => 'document_generate',
            'is_active' => 1
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('documents');
        \GroupPermission::where('short_code', 'document_generate')->delete();
    }
}
