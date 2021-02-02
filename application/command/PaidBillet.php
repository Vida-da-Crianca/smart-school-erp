<?php

namespace Application\Command;


use Packages\Commands\BaseCommand;
use Illuminate\Database\Capsule\Manager as DB;


class PaidBillet extends BaseCommand
{

    protected $name = 'billet:paid';

    protected $description = '';

    protected $CI;

    public function __construct($CI)
    {
        $this->CI = $CI;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);
    }

    protected function start()
    {

        $this->CI->load->library('bank_payment_inter');
        $this->CI->load->model(['eloquent/Billet_eloquent',  'eloquent/Invoice_eloquent', 'eloquent/Student_deposite_eloquent']);

        $billets = \Billet_eloquent::with(['feeItems'])->where('status', \Billet_eloquent::PAID_PENDING)->get();

        foreach ($billets->groupBy('bank_bullet_id') as $row) {
            $billet =  $row->first();
            $totalBillet =  $row->sum('price');

            $b = $this->CI->bank_payment_inter->find($billet->bank_bullet_id);

            // if ($billet->id != 74) continue;

            // dump([$row->count(), $billet->id, $row->sum('price')]);

            // continue;
            // $b->situacao = 'PAGO';
            // $b->valorNominal =  $totalBillet - 100.00;
            $item =  $billet->feeItems()->first();
            $dateTimeExplode = explode(' ', $b->dataHoraSituacao);

            $dateStatus = new \DateTime(implode('-', array_reverse(explode('/', $dateTimeExplode[0]))));


            // continue;
            
            if ($b->situacao == 'PAGO') {
                $billet->update([
                    'status' => \Billet_eloquent::PAID,
                    'received_at' => $dateStatus->format('Y-m-d H:i:s'),
                ]);
                $body = $billet->body_json;
                
                $hasDiscount = $b->valorNominal - $totalBillet;
                $discount =  $hasDiscount > 0 ? 0 : abs(($b->valorNominal / $totalBillet) - 1)  ;
                $fine = $hasDiscount > 0  ? ( ($b->valorNominal - $totalBillet) / $totalBillet)  : 0  ;
                // dump( $b->valorNominal);
                // dump($fine);
                // dump($discount);
               
               
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
                        'created_at' => date('Y-m-d H:i:s'),
                        'amount_detail' => json_encode(['1' => [

                            'amount' => $price,
                            'date' => date('Y-m-d'),
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
                //    ; dump($deposite->id);
                    // \Invoice_eloquent::where('bank_bullet_id','=' , $billetRow->id )->update([
                    //     'student_fees_deposite_id' => $billetRow->id,
                    //     // 'student_fees_deposite_id' => $deposite->id,
                    // ]);

                }
                // dump($final); 
            }
        }

        // try {
        //     echo "\nBaixando boleto\n";
        //     $bank->baixaBoleto('00616514891', INTER_BAIXA_DEVOLUCAO);
        //     echo "Boleto Baixado";
        // } catch ( BancoInterException $e ) {
        //     echo "\n\n".$e->getMessage();
        //     echo "\n\nCabeçalhos: \n";
        //     echo $e->reply->header;
        //     echo "\n\nConteúdo: \n";
        //     echo $e->reply->body;
        // }
        return 0;
    }
}
