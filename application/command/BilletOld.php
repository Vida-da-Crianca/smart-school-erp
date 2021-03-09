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
        $this->CI->load->model(['eloquent/Billet_eloquent', 'eloquent/Invoice_eloquent','eloquent/FeeReminder']);
        $timeStart = Carbon::create(date('Y'), date('m'), date('d'), 8, 0);
        $timeEnd = Carbon::create(date('Y'), date('m'), date('d'), 21, 0);

        if(\FeeReminder::isBankAfter()->isActive()->count() == 0) {
            
            return;
        }  


        if (getenv('ENVIRONMENT') != 'development' && (!isValidDay() || !Carbon::now()->betweenIncluded($timeStart, $timeEnd))) {
            return;
        }


        $this->CI->lang->load('app_files/system_lang.php','Portugues_Brazil');
        // $isBetween = Carbon::now()->betweenIncluded($timeStart, $timeEnd);
      
        $billets = \Billet_eloquent::isOld()
            ->where(function ($q) {
                $q->whereNotBetween('sended_mail_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::now()->format('Y-m-d 23:59:59')])
                    ->orWhereRaw('sended_mail_at IS NULL');
            })
            // ->limit(7)
            ->with(['feeItems', 'student'])->get();
        //    dump($billets);
        //     return;
        $listOfGroup = $billets->groupBy('bank_bullet_id');
        dump($listOfGroup->count());
        foreach ($listOfGroup as $listBillet) {
            $billet  = $listBillet->first();
            $date = new Carbon($billet->sended_mail_at);

            if (!$billet->student) {
                if ((getenv('ENVIRONMENT') != 'development'))
                    discord_billet_old(json_encode([
                        'codigo' => $billet->bank_bullet_id,
                        'valor'  =>  $listBillet->sum('price'),
                        'vencimento' => $billet->due_date,
                        'message' => 'Esse boleto não contém os dados do estudante'
                    ], JSON_PRETTY_PRINT), 'Boletos não enviados por falta de dados');
                \Billet_eloquent::where('bank_bullet_id', $billet->bank_bullet_id)->update(['sended_mail_at' => Carbon::now()->format('Y-m-d H:i:s')]);
                continue;
            }
            // if (($billet->sended_mail_at != null && $date->isToday())) continue;


            $this->handleSendMail($billet, function ($mail) use ($billet) {

                if (!$mail['status']) return;

                if ((getenv('ENVIRONMENT') != 'development'))
                  discord_billet_old(json_encode($mail['data'], JSON_PRETTY_PRINT));

                \Billet_eloquent::where('bank_bullet_id', $billet->bank_bullet_id)->update(['sended_mail_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            });
            usleep(1000);
        }

        return 0;
    }
}
