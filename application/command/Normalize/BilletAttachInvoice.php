<?php

namespace Application\Command\Normalize;


use Packages\Commands\BaseCommand;
use Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * 
 */

class BilletAttachInvoice extends BaseCommand
{

    protected $name = 'normalize:billete:attach-invoice';

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

        $billets = \Billet_eloquent::with(['feeItems', 'invoice', 'invoices'])->whereIn('status', [\Billet_eloquent::PAID, \Billet_eloquent::PAID_PENDING])
            ->get();
        foreach ($billets->groupBy('bank_bullet_id') as $row) {

            $invoice = new \stdClass;
            $invoice->id = null;
            
            $row->each(function ($billet) use (&$invoice) {
                $billet->invoice->each(function ($item) use (&$invoice) {

                    if ($item->id != null) $invoice = $item;
                });
            });

            foreach ($row as $billet) {
                // dump($billetRow->id);

                if ($invoice->id != null) {

                    $billet->invoices()->detach([$invoice->id]);
                    $billet->invoices()->attach([$invoice->id]);
                }
            }
            // dump($final); 
        }
       

        return 0;
    }
}
