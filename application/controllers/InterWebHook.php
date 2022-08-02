<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Billet_eloquent;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class InterWebhook extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['eloquent/Billet_eloquent',  'eloquent/Invoice_eloquent', 'eloquent/Student_deposite_eloquent']);
    }

    public function baixaBoleto(){
        
        $boleto_input = trim(file_get_contents('php://input'));

        try{

            $boletoInter = json_decode($boleto_input);

            // Apenas se for boleto pago.
            if(@$boletoInter->situacao == 'PAGO'){

                $nosso_numero = $boletoInter->nossoNumero;
                $boletos = \Billet_eloquent::with(['feeItems'])->where('bank_bullet_id', $nosso_numero)->where('status', \Billet_eloquent::PAID_PENDING)->groupBy('bank_bullet_id')->get();

                $boleto = $boletos->first();
                $total = $boletos->sum('price');

                $invoice =  \Invoice_eloquent::whereIn('bullet_id', [$boletos->pluck('id')->toArray()])->first();

                $item = $boleto->feeItems()->first();
                $dateTimeExplode = explode(' ', $boletoInter->dataHoraSituacao);
                $dateStatus = new \DateTime(implode('-', array_reverse(explode('/', $dateTimeExplode[0]))));

                // Atualizar boleto no bd
                \Billet_eloquent::where('bank_bullet_id', $boleto->bank_bullet_id)
                    ->update([
                        'status' => \Billet_eloquent::PAID,
                        'received_at' => $dateStatus->format('Y-m-d H:i:s')
                    ]);
                
                $body = $boleto->body_json;
                $totalReceived = $boletoInter->valorTotalRecebimento;
                $hasDiscount = $totalReceived - $total;
                $discount =  $hasDiscount > 0 ? 0 : abs(($totalReceived / $total) - 1);
                $fine = $hasDiscount > 0  ? (($totalReceived - $total) / $total)  : 0;
                $final =  0;

                foreach($boletos as $billetRow){
                    $deposite = new \Student_deposite_eloquent;
                    $item =  $billetRow->feeItems()->first();
                    $price = $item->amount;
                    $ifine =  $fine >  0 ? $price * $fine : 0;
                    $idiscount = $discount >  0 ? $price * $discount : 0;

                    $final += ($price + $ifine) - $idiscount;

                    $depositeArray =  [
                        'fee_groups_feetype_id' => $item->feetype_id,
                        'student_fees_master_id' => $boleto->user_id,
                        'student_fees_id' => $item->id,
                        'created_at' => $dateStatus->format('Y-m-d H:i:s'),
                        'amount_detail' => json_encode(['1' => [

                            'amount' => $price,
                            'date' => $dateStatus->format('Y-m-d'),
                            'description' => 'Collected By: Sistema automatico',
                            'amount_discount' => $idiscount,
                            'amount_fine' => $ifine,
                            'payment_mode' => 'Billet',
                            'received_by' => 'Banco Inter',
                            'inv_no' => 1,
                        ]])
                    ];

                    $deposite->fill($depositeArray);
                    $deposite->save();
                    $deposite->invoice()->detach($invoice->id);
                    $deposite->invoice()->attach($invoice->id);
                    
                }
                
                
            }

        }catch(Exception $e){

        }

        echo "Request finalizada.";


    }
    

}
