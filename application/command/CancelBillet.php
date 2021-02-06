<?php

namespace Application\Command;


use Packages\Commands\BaseCommand;



class CancelBillet extends BaseCommand
{

    protected $name = 'billet:cancel';

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
        $this->CI->load->model(['eloquent/Billet_eloquent','eloquent/Invoice_eloquent']);
        
        if( !isValidDay()) {
            return;
        }


        $billets = \Billet_eloquent::onlyTrashed()->where('is_active', 1)->get()->groupBy('bank_bullet_id');


        foreach ($billets as $item) {
            //   dump($row->status);
            $row = $item->first();
            if ($row->bank_bullet_id == null) {
                $row->is_active = 0;
                $row->save();
                continue;
            }
            $this->CI->bank_payment_inter->cancel(
                ['number' => $row->bank_bullet_id, 'motive' => $row->status],
                function ($status) use ($row) {
                    if ($status->success) {
                        \Billet_eloquent::onlyTrashed()
                            ->where('bank_bullet_id', $row->bank_bullet_id)
                            ->update([
                                'is_active' => 0,
                            ]);
                    }
                    \Invoice_eloquent::where('bullet_id', $row->bank_bullet_id)
                    ->update(['status' => \Invoice_eloquent::PENDING_DELETE ]);

                    discord_log(sprintf('%s', json_encode($status, JSON_PRETTY_PRINT)), 'Cancelamento de Boleto');
                }
            );
        }
        return 0;
    }
}
