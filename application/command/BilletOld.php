<?php

namespace Application\Command;

use Application\Command\Traits\SendMailBillet;
use Carbon\Carbon;
use Packages\Commands\BaseCommand;



class BilletOld extends BaseCommand
{
    use SendMailBillet;
    protected $name = 'billet:old';

    protected $description = 'Recupera todos os boletos vencidos';

    protected $CI;

    protected $hour_notification = '08:00';

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
        $this->CI->load->model(['eloquent/Billet_eloquent', 'eloquent/Invoice_eloquent']);

        if (getenv('ENVIRONMENT') != 'development' && !isValidDay()) {
            return;
        }
        // if( getenv('ENVIRONMENT') != 'development') return;


        $billets = \Billet_eloquent::isOld()
            ->where(function ($q) {
                $q->whereNotBetween('sended_mail_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::now()->format('Y-m-d 23:59:59')])
                    ->orWhereRaw('sended_mail_at IS NULL');
            })
            ->with(['feeItems', 'student'])->get();
        // dump($billets->count());
        foreach ($billets as $billet) {
            $this->handleSendMail($billet);
            $billet->sended_mail_at = Carbon::now()->format('Y-m-d H:i:s');
            $billet->save();
        }

        return 0;
    }
}
