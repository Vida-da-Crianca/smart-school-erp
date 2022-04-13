<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\RawMessageFromArray;
use Kreait\Firebase\Messaging\MulticastSendReport;

class Firebase_model extends MY_Model {
    public function __construct() {
        // Verificar tabelas
        $this->load->dbforge();
        $this->load->library(array('Auth'));
        $this->load->helper('string');
        $this->load->model('setting_model');
        $this->_verificarTabela();
        parent::__construct();
    }

    // Função para verificar se existe a tabela de config do firebase, caso não exista, cria uma.
    private function _verificarTabela(){
        // Criar tabela de tokens
        $token_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unique' => TRUE,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ),
            'user_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => FALSE,
            ),
            'device_tokens' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($token_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('device_tokens', true);

    }

    // Função para retornar os tokens do usuário
    public function get_user_device_tokens($user_id, $type){
        $query = $this->db->select('*')->where('user_id', $user_id)->where('user_type', $type)->get('device_tokens');
        $my_tokens = $query->row_object();
        if($my_tokens && !empty($my_tokens->device_tokens))
            return json_decode($my_tokens->device_tokens);
        
        return array();
    }

    // FUnção para adicionar o token para x usuário, conforme sessão e login.
    public function add_device_token($token){

        $admin = $this->session->userdata('admin');
        $student = $this->session->userdata('student');

        if($admin){
            $user_id = $admin['id'];
            $type = "staff";
        }
        if($student){
            $user_id = $student['id'];
            $type = $student['role'];
        }

        $user_tokens = $this->get_user_device_tokens($user_id, $type);
        if(count($user_tokens) > 0){
            array_push($user_tokens, $token);
            $user_tokens = array_unique($user_tokens);
            $this->db->set('device_tokens', json_encode($user_tokens));
            $this->db->where('user_id', $user_id);
            $this->db->where('user_type', $type);
            $this->db->update('device_tokens');
        } else {
            array_push($user_tokens, $token);
            $user_tokens = array_unique($user_tokens);
            $this->db->set(array('user_id' => $user_id, 'user_type' => $type, 'device_tokens' => json_encode($user_tokens)));
            $this->db->insert('device_tokens');
        }
    }

    public function sendNotification($title, $message, $user_id, $user_type){
        $user_tokens = $this->get_user_device_tokens($user_id, $user_type);
        if($user_tokens){
            $message = new RawMessageFromArray([
                'android' => [
                    // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#androidconfig
                    'ttl' => '3600s',
                    'priority' => 'high',
                    'notification' => [
                        'title' => $title,
                        'body' => $message,
                        'icon' => 'stock_ticker_update',
                        'color' => '#f45342',
                    ],
                ],
                'apns' => [
                    // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#apnsconfig
                    'headers' => [
                        'apns-priority' => '5',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => $title,
                                'body' => $message,
                            ],
                            'badge' => 42,
                        ],
                    ],
                ],
                'webpush' => [
                    // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#webpushconfig
                    'headers' => [
                        'Urgency' => 'high',
                    ],
                    'notification' => [
                        'title' => $title,
                        'body' => $message
                    ],
                ],
            ]);

            $factory = (new Factory)->withServiceAccount(__DIR__ . '/../../erp-firebase.json');
            $messaging = $factory->createMessaging();
            $resp = $messaging->sendMulticast($message, $user_tokens);
            return TRUE;
        }
        return FALSE;
    }
}