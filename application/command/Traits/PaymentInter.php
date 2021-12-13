<?php 
namespace Application\Command;

use Application\Core\BankInterPayment;

trait PaymentInter {
    


    public function buildOptionsStudentPayment($student)
    {
        $payment = new BankInterPayment;
        $payment->user =  $student->guardian_name;
        $payment->user_document =  $student->guardian_document;
        $payment->address = $student->guardian_address;
        $payment->address_state = $student->guardian_state;
        $payment->address_district = $student->guardian_district;
        $payment->address_city = $student->guardian_city;
        $payment->address_number = $student->guardian_address_number;
        $payment->address_postal_code = $student->guardian_postal_code;


        return $payment;
    }

    public function buildOptionsBilletPayment(&$payment, &$billet)
    {

        $payment->price = $billet->price;
        $payment->date_payment = $billet->due_date;
        $payment->description =  $billet->description;
        $payment->your_number  = $billet->custom_number;
    }


    public function push($payment, \Closure $callback)
    {
        //    $callback(['success']);    

        $this->CI->load->library(['bank_payment_inter']);
        $this->CI->bank_payment_inter->create($payment, $callback);
    }
}