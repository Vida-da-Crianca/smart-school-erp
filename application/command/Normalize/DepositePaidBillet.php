<?php

namespace Application\Command\Normalize;


use Packages\Commands\BaseCommand;
use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;

class DepositePaidBillet extends BaseCommand
{

    protected $name = 'normalize:billete:deposite';

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

        $billets = \Billet_eloquent::with(['feeItems'])->where('status', \Billet_eloquent::PAID)
            ->orderBy('due_date', 'ASC')
            // ->whereBetween('due_date', ['2021-01-01', '2021-01-31'])
            ->get();

        \Student_deposite_eloquent
            ::where('amount_detail', 'like', '%Billet%')
            ->delete();

        foreach ($billets->groupBy('bank_bullet_id') as $row) {
            $billet =  $row->first();
            $totalBillet =  $row->sum('price');
            //  if ($billet->id != 74) continue;

            $invoice =  \Invoice_eloquent::whereIn('bullet_id', [$row->pluck('id')->toArray()])->first();

            $b = $this->CI->bank_payment_inter->find($billet->bank_bullet_id);
            $item =  $billet->feeItems()->first();
            $itemsId = $billet->feeItems()->pluck('id')->toArray();
            $dateTimeExplode = explode(' ', $b->dataHoraSituacao);

            $dateStatus = new \DateTime(implode('-', array_reverse(explode('/', $dateTimeExplode[0]))));

            // $billet->update([
            //     'status' => \Billet_eloquent::PAID,
            //     'received_at' => $dateStatus->format('Y-m-d H:i:s'),
            // ]);
            $body = $billet->body_json;

            $hasDiscount = $b->valorNominal - $totalBillet;
            $discount =  $hasDiscount > 0 ? 0 : abs(($b->valorNominal / $totalBillet) - 1);
            $fine = $hasDiscount > 0  ? (($b->valorNominal - $totalBillet) / $totalBillet)  : 0;

            $final =  0;
            $i = 0;
            foreach ($row as $billetRow) {
                // dump($billetRow->id);
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
                    'created_at' => (new Carbon($billetRow->due_date))->format('Y-m-d H:i:s'),
                    'amount_detail' => json_encode(['1' => [
                        'amount' => $price,
                        'date' => (new Carbon($billetRow->due_date))->format('Y-m-d'),
                        'description' => 'Collected By: Sistema automatico',
                        'amount_discount' => $idiscount,
                        'amount_fine' => $ifine,
                        'payment_mode' => 'Billet',
                        'received_by' => 'Banco Inter',
                        'inv_no' => 1,
                    ]])
                ];

                // dump ( $depositeArray  );
                $deposite->fill($depositeArray);
                $deposite->save();
            }
            // dump($final); 
        }



        // $billets = \Billet_eloquent::with(['feeItems'])->where('status', \Billet_eloquent::PAID)
        // ->orderBy('due_date', 'ASC')->get();

        // foreach ($billets->groupBy('bank_bullet_id') as $row){
        //     $invoice =  \Invoice_eloquent::whereIn('bullet_id', $row->pluck('id')->toArray())->first();

        //     dump($row->pluck('id')->toArray(), $invoice->id);
        // }

        \Student_deposite_eloquent::with(['feeItem.billet.invoices'])->get()->each(function ($deposite) {
            if (!$deposite->feeItem->billet) {
                return;
            }

            $billet = $deposite->feeItem->billet->pluck('id');

            if ($billet->count()  == 0) return;

            // $groupBy =  $deposite->feeItem->billet->groupBy('bank_bullet_id')->toArray();
            if (!($deposite->feeItem->billet->first()->invoices)) return;
            $invoice = $deposite->feeItem->billet->first()->invoices->first();
            // dump($invoice->toArray());
            $deposite->invoice()->detach($invoice->id);
            $deposite->invoice()->attach($invoice->id);

            // foreach()
            // $invoice =  \Invoice_eloquent::withTrashed()->whereIn('bullet_id', $b)
            // ->where('status', 'VALIDA')
            // ->first();

            // dump($invoice->invoice_number, $b);
            return;

            // if (!$invoice->id) return;

            // $deposite->invoice()->detach($invoice->id);
            // $deposite->invoice()->attach($invoice->id);
        });
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
