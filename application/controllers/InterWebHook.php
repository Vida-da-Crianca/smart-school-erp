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
        $boletoInter = json_decode($boleto_input);

        $billets = \Billet_eloquent::with(['feeItems'])->where('status', \Billet_eloquent::PAID_PENDING)
        // ->whereBetween('due_date', ['2021-01-01','2021-01-31'])
        ->get();

        foreach ($billets->groupBy('bank_bullet_id') as $row) {
            $billet =  $row->first();

            if($billet->bank_bullet_id == $boletoInter->nossoNumero){
                $totalBillet =  $row->sum('price');

                $b = $boletoInter;


                $invoice =  \Invoice_eloquent::whereIn('bullet_id', [$row->pluck('id')->toArray()])->first();

                // if ($billet->id != 74) continue;

                // dump([$row->count(), $billet->id, $row->sum('price')]);

                // continue;
                // $b->situacao = 'PAGO';
                // dump($b->situacao);
                // $b->valorNominal =  $totalBillet - 100.00;
                $item =  $billet->feeItems()->first();
                $dateTimeExplode = explode(' ', $b->dataHoraSituacao);

                $dateStatus = new \DateTime(implode('-', array_reverse(explode('/', $dateTimeExplode[0]))));


                // continue;

                if ($b->situacao == 'PAGO') {
                    \Billet_eloquent::where('bank_bullet_id', $billet->bank_bullet_id)
                    ->update([
                        'status' => \Billet_eloquent::PAID,
                        'received_at' => $dateStatus->format('Y-m-d H:i:s'),
                    ]);
                    $body = $billet->body_json;
                    $totalReceivced = $b->valorTotalRecebimento;
                    $hasDiscount = $totalReceivced - $totalBillet;
                    $discount =  $hasDiscount > 0 ? 0 : abs(($totalReceivced / $totalBillet) - 1);
                    $fine = $hasDiscount > 0  ? (($totalReceivced - $totalBillet) / $totalBillet)  : 0;
                    $final =  0;
                    foreach ($row as $billetRow) {
                        $deposite = new \Student_deposite_eloquent;
                        $item =  $billetRow->feeItems()->first();
                        $price = $item->amount;
                        $ifine =  $fine >  0 ? $price * $fine : 0;
                        $idiscount = $discount >  0 ? $price * $discount : 0;

                        $final += ($price + $ifine) - $idiscount;

                        $depositeArray =  [
                            'fee_groups_feetype_id' => $item->feetype_id,
                            'student_fees_master_id' => $billet->user_id,
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

                        // dump($depositeArray);
                        $deposite->fill($depositeArray);
                        $deposite->save();
                        $deposite->invoice()->detach($invoice->id);
                        $deposite->invoice()->attach($invoice->id);
                        //    ; dump($deposite->id);
                        // \Invoice_eloquent::where('bank_bullet_id','=' , $billetRow->id )->update([
                        //     'student_fees_deposite_id' => $deposite->id,
                        //     // 'student_fees_deposite_id' => $deposite->id,
                        // ]);

                    }
                    // dump($final); 
                }
            }
            
        }

        return 'ok';
    }

}
