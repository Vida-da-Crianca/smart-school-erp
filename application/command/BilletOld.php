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
        try{

            // return;s
            $this->CI->load->library('bank_payment_inter');
            $this->CI->load->model(['eloquent/Billet_eloquent',
            'eloquent/MailerEloquent',
            'eloquent/Invoice_eloquent','eloquent/FeeReminder']);
            $timeStart = Carbon::create(date('Y'), date('m'), date('d'), 13, 8);
            $timeEnd = Carbon::create(date('Y'), date('m'), date('d'), 21, 0);
    
           
    
            if(\FeeReminder::isBankAfter()->isActive()->count() == 0) {
                if(\FeeReminder::isBankAfter()->count() == 0){
                    
                    \FeeReminder::create(['reminder_type' => \FeeReminder::BANK_TYPE_AFTER, 'day' => 3, 'is_active' => 0]);
                }
                   
                $this->success('Boletos em atraso, desativado');
                return;
            }  
    
            //getenv('ENVIRONMENT') != 'development' && 
            if (getenv('ENVIRONMENT') != 'development' && !isValidDay() ) {
                return  $this->warning('Dia inválido');
            }
    
    
            $this->CI->lang->load('app_files/system_lang.php','Portugues_Brazil');
            // $isBetween = Carbon::now()->betweenIncluded($timeStart, $timeEnd);
            $this->text('verificação de boletos vencidos iniciada...');
            $billets = \Billet_eloquent::isOld()
                ->where(function ($q) {
                    $q->whereNotBetween('sended_mail_at', [Carbon::now()->format('Y-m-d 00:00:00'), Carbon::now()->format('Y-m-d 23:59:59')])
                        ->orWhereRaw('sended_mail_at IS NULL');
                })
                ->with(['feeItems', 'student'])->get();
         
            $listOfGroup = $billets->groupBy('bank_bullet_id');
            
            foreach ($listOfGroup as $listBillet) {
                $billet  = $listBillet->first();
                $date = new Carbon($billet->sended_mail_at);
               
    
                if (!$billet->student) {
                    // if ((getenv('ENVIRONMENT') != 'development'))
                    //     discord_billet_old(json_encode([
                    //         'codigo' => $billet->bank_bullet_id,
                    //         'valor'  =>  $listBillet->sum('price'),
                    //         'vencimento' => $billet->due_date,
                    //         'message' => 'Esse boleto não contém os dados do estudante'
                    //     ], JSON_PRETTY_PRINT), 'Boletos não enviados por falta de dados');
                    // \Billet_eloquent::where('bank_bullet_id', $billet->bank_bullet_id)->update(['sended_mail_at' => Carbon::now()->format('Y-m-d H:i:s')]);
                    continue;
                }
    
               
                // if (($billet->sended_mail_at != null && $date->isToday())) continue;
    
    
                $this->onQueue($billet);
                // $billet->update(['sended_mail_a' => date('Y-m-d H:i:s')]);
                
                sleep(1);
                
            }
            $this->text('verificação de boletos vencidos finalizada t('. $listOfGroup->count().')');
        }catch(\Exception $e) {
            log_message('error', $e->getMessage());
            $this->text('[error]'. $e->getMessage());
        }
       
        

        return 0;
    }
}
