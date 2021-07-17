<?php

namespace Application\Command\Normalize;


use Packages\Commands\BaseCommand;
use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;

class DepositeAllBilletPending extends BaseCommand
{

    protected $name = 'normalize:billete-all:deposite';

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

        $billets = \Billet_eloquent::with(['feeItems'])->whereIn('status', [ \Billet_eloquent::PAID])
            ->orderBy('due_date', 'ASC')
            // ->whereBetween('due_date', ['2021-01-01', '2021-01-31'])
            ->get();

        



        foreach ($billets->groupBy('bank_bullet_id') as $row) {
            $billet =  $row->first();
            $totalBillet =  $row->sum('price');
            //  if ($billet->id != 74) continue;

            $invoice =  \Invoice_eloquent::whereIn('bullet_id', [$row->pluck('id')->toArray()])->first();

            $b = $this->CI->bank_payment_inter->find($billet->bank_bullet_id);
            $item =  $billet->feeItems()->first();
            $itemsId = $billet->feeItems()->pluck('id')->toArray();
            $dateTimeExplode = explode(' ', $b->dataHoraSituacao);
            if($billet->bank_bullet_id !== '00639157132') continue;
            $dateStatus = new \DateTime(implode('-', array_reverse(explode('/', $dateTimeExplode[0]))));
            if ($b->situacao == 'PAGO') {
                // $billet->update([
                //     'status' => \Billet_eloquent::PAID,
                //     'received_at' => $dateStatus->format('Y-m-d H:i:s'),
                // ]);
                $body = $billet->body_json;
                
                $totalReceivced = $b->valorTotalRecebimento;
                $hasDiscount = $totalReceivced - $totalBillet;
                $discount =  $hasDiscount > 0 ? 0 : abs(($totalReceivced / $totalBillet) - 1)  ;
                $fine = $hasDiscount > 0  ? ( ($totalReceivced - $totalBillet) / $totalBillet)  : 0  ;
                
                $final =  0;
                $i = 0;
                foreach ($row as $billetRow) {
                    $deposite = new \Student_deposite_eloquent;
                    $item = $billetRow->feeItems->first();
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
                            'date' => $dateStatus->format('Y-m-d '),
                            'description' => 'Collected By: Sistema automatico',
                            'amount_discount' => $idiscount,
                            'amount_fine' => $ifine,
                            'payment_mode' => 'Billet',
                            'received_by' => 'Banco Inter',
                            'inv_no' => 1,
                        ]])
                    ];

                    dump ( $depositeArray  );
                    // $deposite->fill($depositeArray);
                    // $deposite->save();
                }
            }
            // dump($final); 
        }
        // }







        return 0;
    }
}
