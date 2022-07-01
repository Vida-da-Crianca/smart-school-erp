<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Application\Support\Parser;

class Mailgateway
{

    private $_CI;

    public function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->model('setting_model');
        $this->_CI->load->model('studentfeemaster_model');
        $this->_CI->load->model('student_model');
        $this->_CI->load->model('teacher_model');
        $this->_CI->load->model('librarian_model');
        $this->_CI->load->model('accountant_model');
        $this->_CI->load->library('mailer');
        $this->_CI->mailer;
        $this->sch_setting = $this->_CI->setting_model->get();
        $this->sch_setting_detail = $this->_CI->setting_model->getSetting();
    }

    public function sentMail($sender_details, $template, $subject)
    {
        $msg = $this->getContent($sender_details, $template);

        $send_to = $sender_details->guardian_email;
        if (!empty($this->_CI->mail_config) && $send_to != "") {

            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function sentRegisterMail($id, $send_to, $template)
    {

        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Matrícula Efetivada";

            $msg = $this->getStudentRegistrationContent($id, $template);

            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function sendLoginCredential($chk_mail_sms, $sender_details, $template)
    {
        $msg = $this->getLoginCredentialContent($sender_details['credential_for'], $sender_details, $template);
        $send_to = $sender_details['email'];
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Login Credential";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function sentAddFeeMail($detail, $template)
    {
        $send_to = $detail->email;
        $msg = $this->getAddFeeContent($detail, $template);
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Fees Received";

            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function sentExamResultMail($detail, $template)
    {

        $msg = $this->getStudentResultContent($detail, $template);
        $send_to = $detail['guardian_email'];
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Exam Result";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function sentExamResultMailStudent($detail, $template)
    {

        $msg = $this->getStudentResultContent($detail, $template);
        $send_to = $detail['email'];
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Exam Result";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function sentHomeworkStudentMail($detail, $template)
    {

        if (!empty($this->_CI->mail_config)) {
            foreach ($detail as $student_key => $student_value) {
                $send_to = $student_key;
                if ($send_to != "") {
                    $msg = $this->getHomeworkStudentContent($detail[$student_key], $template);
                    $subject = "HomeWork Notice";
                    $this->_CI->mailer->send_mail($send_to, $subject, $msg);
                }
            }
        }
    }

    public function sentOnlineClassStudentMail($detail, $template)
    {

        if (!empty($this->_CI->mail_config)) {
            foreach ($detail as $student_key => $student_value) {
                $send_to = $student_key;
                if ($send_to != "") {
                    $msg = $this->getOnlineClassStudentContent($detail[$student_key], $template);

                    $subject = "Online Class";
                    $this->_CI->mailer->send_mail($send_to, $subject, $msg);
                }
            }
        }
    }

    public function sentOnlineMeetingStaffMail($detail, $template)
    {

        if (!empty($this->_CI->mail_config)) {
            foreach ($detail as $staff_key => $staff_value) {
                $send_to = $staff_key;
                if ($send_to != "") {
                    $msg = $this->getOnlineMeetingStaffContent($detail[$staff_key], $template);

                    $subject = "Online Meeting";
                    $this->_CI->mailer->send_mail($send_to, $subject, $msg);
                }
            }
        }
    }

    public function sentAbsentStudentMail($detail, $template)
    {

        $send_to = $detail['guardian_email'];
        $msg = $this->getAbsentStudentContent($detail, $template);
        if (!empty($this->_CI->mail_config) && $send_to != "") {
            $subject = "Absent Notice";
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    public function getAddFeeContent($data, $template)
    {
        $currency_symbol = $this->sch_setting[0]['currency_symbol'];
        $school_name = $this->sch_setting[0]['name'];
        $invoice_data = json_decode($data->invoice);
        $data->invoice_id = $invoice_data->invoice_id;
        $data->sub_invoice_id = $invoice_data->sub_invoice_id;
        $fee = $this->_CI->studentfeemaster_model->getFeeByInvoice($data->invoice_id, $data->sub_invoice_id);
        $a = json_decode($fee->amount_detail);
        $record = $a->{$data->sub_invoice_id};
        $fee_amount = number_format((($record->amount + $record->amount_fine)), 2, '.', ',');
        $data->firstname = $fee->firstname;
        $data->lastname = $fee->lastname;
        $data->class = $fee->class;
        $data->section = $fee->section;
        $data->fee_amount = $currency_symbol . $fee_amount;

        foreach ($data as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $template = $this->parseGlobalVariable($data->student_id, $template);

        return $template;
    }

    public function getHomeworkStudentContent($student_detail, $template)
    {

        foreach ($student_detail as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $template = $this->parseGlobalVariable($student_detail['student_id'], $template);

        return $template;
    }

    public function getOnlineClassStudentContent($student_detail, $template)
    {

        foreach ($student_detail as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        return $template;
    }

    public function getOnlineMeetingStaffContent($student_detail, $template)
    {

        foreach ($student_detail as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        return $template;
    }

    public function getAbsentStudentContent($student_detail, $template)
    {

        $session_name = $this->_CI->setting_model->getCurrentSessionName();

        $student_detail['current_session_name'] = $session_name;

        foreach ($student_detail as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $template = $this->parseGlobalVariable($student_detail['student_id'], $template);

        return $template;

        return $template;
    }

    public function getStudentRegistrationContent($id, $template)
    {

        $session_name = $this->_CI->setting_model->getCurrentSessionName();
        $student = $this->_CI->student_model->get($id);

        $student['current_session_name'] = $session_name;
        foreach ($student as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        $template = $this->parseGlobalVariable($id, $template);
        return $template;
    }

    public function getLoginCredentialContent($credential_for, $sender_details, $template)
    {

        if ($credential_for == "student") {
            $student = $this->_CI->student_model->get($sender_details['id']);
            $sender_details['url'] = site_url('site/userlogin');
            $sender_details['display_name'] = $student['firstname'] . " " . $student['lastname'];
        } elseif ($credential_for == "parent") {
            $parent = $this->_CI->student_model->get($sender_details['id']);
            $sender_details['url'] = site_url('site/userlogin');
            $sender_details['display_name'] = $parent['guardian_name'];
        } elseif ($credential_for == "staff") {
            $staff = $this->_CI->staff_model->get($sender_details['id']);
            $sender_details['url'] = site_url('site/login');
            $sender_details['display_name'] = $staff['name'];
        }

        foreach ($sender_details as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        if ($credential_for == "student" || $credential_for == "parent") {
            $template = $this->parseGlobalVariable($sender_details['id'], $template);
        }

        return $template;
    }

    public function getStudentResultContent($student_result_detail, $template)
    {

        foreach ($student_result_detail as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        $template = $this->parseGlobalVariable($student_result_detail['student_id'], $template);

        return $template;
    }

    public function getContent($sender_details, $template)
    {

        foreach ($sender_details as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        if (isset($sender_details['student_id'])) {
            $template = $this->parseGlobalVariable($sender_details['student_id'], $template);

        }

        return $template;
    }

    public function sentMailToAlumni($sender_details)
    {
        $send_to = $sender_details['email'];
        $subject = $sender_details['subject'];
        $msg = "Event From " . $sender_details['from_date'] . " To " . $sender_details['to_date'] . "<br><br>" .
            $sender_details['body'];

        if ($send_to != "") {
            $this->_CI->mailer->send_mail($send_to, $subject, $msg);
        }
    }

    private function getVarsTypes($student): array
    {
        if (!$student->session) return [];
        $extenso = new NumeroPorExtenso;
        //filter(function($row) use($student) {return $student->session->id == $row->student_session_id;})->
        $fees = Student_fee_item_eloquent::with(['fee_type'])->where('student_session_id', $student->session->id)->get()->groupBy('feetype_id');
        // dump($student->session->toArray());

        $options = [];
        if (!$fees) return $options;
        // dump($fees->toArray());

        foreach ($fees as $listOfFees) {
            $qty = $listOfFees->count();
            $options[sprintf('%s_quantidade', Str::slug($listOfFees->first()->fee_type->type, '_'))] = $qty;
            $options[sprintf('%s_quantidade_extenso', Str::slug($listOfFees->first()->fee_type->type, '_'))] = NumberExtensil::converte($qty, false);
            foreach ($listOfFees as $item) {
                preg_match_all('!\d+!', $item->title, $matches);
                // dump($matches);
                $options[sprintf('%s_@%s_valor', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = number_format($item->amount, 2, ',', '.');
                $options[sprintf('%s_@%s_valor_extenso', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = $extenso->converter($item->amount);
                $options[sprintf('%s_@%s_descricao', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = $item->title;
                $options[sprintf('%s_@%s_data', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('d/m/Y');
                $options[sprintf('%s_@%s_vencimento_dia', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('d');
                $options[sprintf('%s_@%s_vencimento_dia_extenso', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = NumberExtensil::converte((new \DateTime($item->due_date))->format('d'), false);
                $options[sprintf('%s_@%s_vencimento_mes', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('m');
                $options[sprintf('%s_@%s_vencimento_anp', Str::slug($item->fee_type->type, '_'), current($matches)[0])] = (new \DateTime($item->due_date))->format('Y');


            }
        }

        // dump($options);

        return $options;
    }

    private function parseGlobalVariable($id, $template)
    {

        $student = Student_eloquent::where('id', $id)->with(['session' => function ($q) {
            return $q->with(['section', 'class_item'])->where('session_id', $this->sch_setting_detail->session_id);
        }])->first();
        $parser = new Parser();
        $now = new \DateTime();
        $data = [
            'aluno_nome' => $student->fullname,
            // 'class' => $student->session->class_item,
            'aluno_turma' => sprintf(
                '%s - %s',
                $student->session->class_item->class ?? $student->session->class_item->class,
                $student->session->section->section ?? $student->session->section->section
            ),

            'aluno_email' => $student->email,
            'guardiao_nome' => utf8_decode($student->guardian_name),
            'guardiao_email' => $student->guardian_email,
            'guardiao_logradouro' => ($student->guardian_address),
            'guardiao_logradouro_numero' => $student->guardian_address_number,
            'guardiao_logradouro_bairro' => utf8_decode($student->guardian_district),
            'guardiao_logradouro_cidade' => utf8_decode($student->guardian_city),
            'guardiao_logradouro_estado' => $student->guardian_state,
            'guardiao_logradouro_cep' => mask($student->guardian_postal_code, '#####-###'),
            'guardiao_documento' => mask($student->guardian_document, '###.###.###-##'),
            'guardiao_ocupacao' => $student->guardian_ocupation,
            'mes_atual_extenso' => get_month($now),
            'mes_atual_numero' => $now->format('m'),
            'dia_atual' => $now->format('d'),
            'ano_atual' => $now->format('Y'),

        ];

        $data = array_merge($data, $this->getVarsTypes($student));
        $template = $parser->parse_string(str_replace(['{{', '}}'], ['{', '}'], $template), $data);
        return $template;
    }

}
