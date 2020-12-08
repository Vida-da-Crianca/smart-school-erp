<?php 

namespace Application\Core;

use Application\Core\Contracts\BilletCollectionContract;
use Illuminate\Database\Capsule\Manager as DB;

class Billet {
    

    public function create( $data, $user_id, $forceId = false){
        $defaultStatus = \Billet_eloquent::PAID_PENDING ;
        $CI = get_instance();
        $CI->load->model(['eloquent/Billet_eloquent', 'eloquent/Student_deposite_eloquent']);
        $CI->load->library('bank_payment_inter');
        
        $student = (object) $CI->student_model->getByStudentSession( $user_id );
        $errors = [];
        $listOfIds = [];
        foreach ($data as $values) {
            // if (\Student_deposite_eloquent::where('student_fees_id', $values['  '])->count() > 0) continue;
            // if (
            //     \Billet_eloquent::where('fee_item_id', $values['fee_item_id'])
            //     ->count() > 0
            // ) continue;

            $billet = new \Billet_eloquent;
            $billet->body = json_encode($values);
            $billet->price = ($values['fee_amount'] + $values['fee_fine']) - $values['fee_discount'];
            $billet->user_id = $forceId  ? $user_id : $student->id;
            // $billet->fill($values);
            $billet->due_date = $values['due_date'];
            $billet->status = $defaultStatus;
            //create billet
            $billet->save();
            $billet->feeItems()->detach();
            $billet->feeItems()->attach($values['fee_item_id']);
            $listOfIds[] = $billet->id;
            // $billet->received_at = date('Y-m-d H:i:s');
            
            // $payment = new BankInterPayment;
            // $payment->user =  $student->guardian_name;
            // $payment->user_document =  $student->guardian_document;
            // $payment->price = $billet->price;
            // $payment->address = $student->guardian_address;
            // $payment->address_state = $student->guardian_state;
            // $payment->address_district = $student->guardian_district;
            // $payment->address_city = $student->guardian_city;
            // $payment->address_number = $student->guardian_address_number;
            // $payment->address_postal_code = $student->guardian_postal_code;
            // $payment->date_payment = $values['fee_date_payment'];
            // $payment->your_number =  str_pad($billet->id, 10, "0", STR_PAD_LEFT);
            // $payment->description = implode(PHP_EOL, [$values['fee_line_1'], $values['fee_line_2']]);
            //  $errors[] = $payment;
            // $this->bank_payment_inter->create($payment, function ($opt) use (&$billet, &$errors) {
            //     if (!$opt->success) {
            //         $errors[] = sprintf('%s - %s', $opt->status, (string) $opt->body);
            //         return false;
            //     }
            //     $billet->bank_bullet_id = $opt->billet->number;
            //     $billet->save();
            //     DB::commit();
            // });
        }

        return($listOfIds);
    }


   



    
}