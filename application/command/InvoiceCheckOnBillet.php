<?php

namespace Application\Command;

use Billet_eloquent;
use Carbon\Carbon;
use Packages\Commands\BaseCommand;


class InvoiceCheckOnBillet extends BaseCommand
{

    protected $name = 'invoice:billet-check';

    protected $description = '';

    protected $CI;


    protected  $forGenerateItems = [];

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


        $dateTime = new \DateTime();
        // $second = Carbon::create($dateTime->format('Y'), $dateTime->format('m'), $dateTime->format('d'), 0, 0);
        // $first = Carbon::create($dateTime->format('Y'), $dateTime->format('m'), $dateTime->format('d'), 0, 20);

    

        $this->CI->load->model(['eloquent/Billet_eloquent', 'eloquent/Invoice_eloquent']);

        $items = \Billet_eloquent::whereIn('status', [\Billet_eloquent::PAID_PENDING, \Billet_eloquent::PAID])
            ->whereNotNull('bank_bullet_id')
            ->with(['feeItems', 'student','invoices'])
            ->whereBetween('created_at', [$dateTime->format('Y-m-01 00:00:00'),  Carbon::now()->addMonth(12)->endOfMonth(0)->format('Y-m-d 23:59:59')])
            // ->groupBy('bank_bullet_id')
            
            ->get();
        // dump([Carbon::now()->format('Y-m-01'),  Carbon::now()->endOfMonth()->format('Y-m-d')]);
        

        $data =  $items->filter(function ($row){
              return $row->invoices->count() == 0;
            })->groupBy('bank_bullet_id');

        $i = 0;
        foreach ($data as $listOfData) {

            $order = collect([]);
        
            $billetId = $listOfData->first()->id;
           
            

            $listOfData->each(function ($billet) use (&$order, $billetId) {
                $body =  $billet->body_json;
                $first = $billet->feeItems()->first();
                $discount = sprintf('- Desc. R$ %s', number_format($body->fee_discount, 2, ',', '.'));
                $order->push((object) [
                    'bullet_id' => $billetId,
                    'user_id' => $billet->student->id,
                    'due_date' => $billet->due_date,
                    'price' => $first->amount - $body->fee_discount,
                    'description' => sprintf(
                        
                        '%s - %s - R$ %s ',
                        $billet->student->full_name,
                        $first->title,
                        number_format($first->amount, 2, ',', '.'),
                        $body->fee_discount > 0 ? $discount : ''
                    )
                ]);
            });

            $dataInvoice = [
                'due_date' => $order->first()->due_date,
                'bullet_id' => $order->first()->bullet_id,
                'user_id' => $order->first()->user_id,
                'price' => $order->sum('price'),
                'description' => sprintf('Boleto - Nº %s %s%s', $listOfData->first()->bank_bullet_id, PHP_EOL, $order->implode('description', PHP_EOL)),
                'status' => \Invoice_eloquent::PENDING_CREATE
            ];
               
            
            $invoice = \Invoice_eloquent::updateOrCreate(
                ['bullet_id' => $order->first()->bullet_id],
                $dataInvoice
            );
            $listOfData->each(function ($billet) use($invoice){
                $billet->invoices()->detach([$invoice->id]);
                $billet->invoices()->attach([$invoice->id]);
            });
            

            $i += 1;
        }

        $this->text(sprintf('%s nota(s) fiscais adicionada(s) a fila para ser(em) gerada(s) ', $i) );
      
    }
}
