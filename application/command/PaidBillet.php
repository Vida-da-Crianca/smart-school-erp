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

        foreach ($billets as $row) {
            $b = $this->CI->bank_payment_inter->find($row->bank_bullet_id);
            $item =  $row->feeItems()->first();
            $dateTimeExplode = explode(' ', $b->dataHoraSituacao);

            $dateStatus = new \DateTime(implode('-', array_reverse(explode('/', $dateTimeExplode[0]))));

            if ($b->situacao == 'PAGO') {
                $row->update(['status' => \Billet_eloquent::PAID,
                'received_at'=> $dateStatus->format('Y-m-d H:i:s'),
                ]);
                $body = $row->body_json;
                $deposite = new \Student_deposite_eloquent;
                $deposite->fill([
                    'fee_groups_feetype_id' => $item->feetype_id,
                    'student_fees_master_id' => $row->user_id,
                    'student_fees_id' => $item->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'amount_detail' => json_encode(['1' => [

                        'amount' => $row->price,
                        'date' => date('Y-m-d'),
                        'description' => 'Collected By: Sistema automatico',
                        'amount_discount' => $body->fee_discount,
                        'amount_fine' => $row->price - $b->valorNominal,
                        'payment_mode' => 'Billet',
                        'received_by' => 'Banco Inter',
                        'inv_no' => 1,
                    ]])
                ]);
                $deposite->save();
                \Invoice_eloquent::where([
                    'user_id' => $row->user_id,
                    'bullet_id' => $row->id
                ])->update([
                    'student_fees_deposite_id' => $deposite->id,
                    'student_fees_deposite_id' => $deposite->id,
                ]);
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
