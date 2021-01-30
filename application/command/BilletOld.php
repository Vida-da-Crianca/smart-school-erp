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

        // if( !getUtilDay(Carbon::now()->format('Y-m-d'))) {
        //        echo 'Day until';
        //     return;
        // }
        if( getenv('ENVIRONMENT') != 'development' && !isValidDay()) {
            return;
        }
       
        if( getenv('ENVIRONMENT') != 'development' && Carbon::now()->format('H:i') != $this->hour_notification) return;

        $billets = \Billet_eloquent::isOld()->with(['feeItems', 'student'])->get();
        foreach ($billets as $billet) {
            $this->handleSendMail($billet);
        }

        return 0;
    }
}
