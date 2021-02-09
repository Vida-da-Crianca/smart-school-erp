<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class Mailer
{

    public $mail_config;
    private $sch_setting;

    protected $isDebug = 0;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('emailconfig_model');
        $this->CI->mail_config = $this->CI->emailconfig_model->getActiveEmail();
        $this->CI->load->model('setting_model');
        $this->sch_setting = $this->CI->setting_model->get();
    }

    public function setDebug($mode){
        $this->isDebug = $mode;
        return $this;
    }

    public function send_mail($toemail, $subject, $body, $FILES = array(), $cc = "")
    {

        $mail          = new \PHPMailer\PHPMailer\PHPMailer;
        $mail->CharSet = 'UTF-8';
        $school_name   = $this->sch_setting[0]['name'];
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];

        if ($this->CI->mail_config->email_type == "smtp") {
          

            $mail->IsSMTP();
            $mail->SMTPDebug = $this->isDebug;  
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = $this->CI->mail_config->ssl_tls;
            $mail->Host       = $this->CI->mail_config->smtp_server;
            $mail->Port       = $this->CI->mail_config->smtp_port;
            $mail->Username   = $this->CI->mail_config->smtp_username;
            $mail->Password   = $this->CI->mail_config->smtp_password;

            
        }
        $mail->SetFrom('financeiro@eeividadecrianca.com.br', $school_name);
        // $mail->SetFrom($this->CI->mail_config->smtp_username, $school_name);
        // $mail->AddReplyTo($this->CI->mail_config->smtp_username, $this->CI->mail_config->smtp_username);
        if (!empty($FILES)) {
            if (isset($_FILES['files']) && !empty($_FILES['files'])) {
                $no_files = count($_FILES["files"]['name']);
                for ($i = 0; $i < $no_files; $i++) {
                    if ($_FILES["files"]["error"][$i] > 0) {
                        echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    } else {
                        $file_tmp  = $_FILES["files"]["tmp_name"][$i];
                        $file_name = $_FILES["files"]["name"][$i];
                        $mail->AddAttachment($file_tmp, $file_name);
                    }
                }
            }
        }
        if ($cc != "") {

            $mail->AddCC($cc);
        }
        $mail->isHTML(true);   
       
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $body;
        $mail->AddAddress($toemail);
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

}
