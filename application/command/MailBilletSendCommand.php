<?php



namespace Application\Command;

use Application\Command\Traits\SendMailBillet;
use Billet_eloquent;
use Carbon\Carbon;
use Packages\Commands\BaseCommand;
use Illuminate\Database\Capsule\Manager as DB;



class  MailBilletSendCommand  extends BaseCommand
{
    
    use SendMailBillet;


    protected $name = 'billet:send:mail';

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
        $this->CI->load->model(['eloquent/Billet_eloquent', 
         'eloquent/Invoice_eloquent', 
         'eloquent/Student_deposite_eloquent']);

        $billets = \Billet_eloquent::with(['feeItems',  'student'])->where('status', \Billet_eloquent::PAID_PENDING)
            ->whereNull('sended_mail_at')
            // ->whereBetween('due_date', ['2021-01-01','2021-01-31'])
           

           
            ->get();
        // \Student_deposite_eloquent::whereBetween('created_at', ['2021-01-01','2021-01-31'])->delete();
     
        foreach ($billets->groupBy('bank_bullet_id') as $row) {
            $billet =  $row->first();

            $billetsItems = \Billet_eloquent::with(['feeItems'])->where('bank_bullet_id',$billet->bank_bullet_id)
           ->get();
            $items = [];
            foreach($billetsItems as $bItem){
                $items[] = $bItem->feeItems->first();
            }
            $billet->feeItems = collect($items);
            dump($billet->id);
            $this->handleTrySendMail($billet, function($v) use($billet){
                $mail =  (object) $v;
                if( $mail->status ) {
                  //'bank_bullet_id'
                    \Billet_eloquent::where('bank_bullet_id', $billet->bank_bullet_id)->update([
                        'sended_mail_at' => date('Y-m-d H:i:s')
                    ]);
                }
            } );
        }
        return 0;
    }
}




