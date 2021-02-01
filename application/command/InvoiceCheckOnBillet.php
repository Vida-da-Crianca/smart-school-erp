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
            ->with(['feeItems', 'student'])
            ->whereBetween('created_at', [$dateTime->format('Y-m-01'),  Carbon::now()->endOfMonth(12)->format('Y-m-d')])
            // ->groupBy('bank_bullet_id')
            ->get();
        // dump([Carbon::now()->format('Y-m-01'),  Carbon::now()->endOfMonth()->format('Y-m-d')]);

        $data = $items->groupBy('bank_bullet_id');
        $ids = [];
        $billetsOnInvoice = [];
        foreach ($data as $listGroup) {
            $inIds =  $listGroup->pluck('id')->toArray();
            $invoice = \Invoice_eloquent::where('bullet_id', $inIds)->get();
            if ($invoice->count() == 0) {

                $ids = [...$ids, ...$inIds];
            } else {

                $billetsOnInvoice = [...$billetsOnInvoice, ...$inIds];
            }
        }


        $data =  $items->filter(function ($row) use ($ids) {
                return in_array($row->id, $ids);
            })->groupBy('bank_bullet_id');



        // dump($ids,  $billetsOnInvoice);


        $i = 0;
        foreach ($data as $listOfData) {

            $order = collect([]);
            $hasOrder = false;
            $billetId = $listOfData->first()->id;

            $listOfData->each(function ($billet) use (&$order, &$hasOrder, $billetsOnInvoice, $billetId) {
                if (in_array($billet->id, $billetsOnInvoice)) {
                    $hasOrder = true;
                    return;
                }
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

            if ($hasOrder) continue;


            $invoice = [
                'due_date' => $order->first()->due_date,
                'bullet_id' => $order->first()->bullet_id,
                'user_id' => $order->first()->user_id,
                'price' => $order->sum('price'),
                'description' => $order->implode('description', PHP_EOL),
                'status' => \Invoice_eloquent::PENDING_CREATE
            ];
               
            // dump($invoice);

            \Invoice_eloquent::updateOrCreate(
                ['bullet_id' => $order->first()->bullet_id],
                $invoice
            );
            $i += 1;
        }

        $this->text('Notas fiscais geradas: ' . $i);
        // $isValid = Carbon::create(
        //     $dateTime->format('Y'),
        //     $dateTime->format('m'),
        //     $dateTime->format('d'),
        //     $dateTime->format('H'),
        //     $dateTime->format('i')
        // )->betweenIncluded($first, $second);


        // if ($isValid)
        //     shell_exec('rm -rf /app/temp/*');
    }
}
