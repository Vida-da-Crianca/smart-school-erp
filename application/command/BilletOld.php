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

        if( getenv('ENVIRONMENT') != 'development' && !isValidDay()) {
            return;
        }       
        if( getenv('ENVIRONMENT') != 'development' && Carbon::now()->format('H:i') != $this->hour_notification) return;

        $billets = \Billet_eloquent::isOld()->with(['feeItems', 'student'])->limit(1)->get();
        foreach ($billets as $billet) {
            // dump($billet->toArray());
            $this->handleSendMail($billet);
        }

        return 0;
    }
}
