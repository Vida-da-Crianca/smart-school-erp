<?php



namespace Application\Command\Fake;

use Application\Command\Traits\ExceptionsFailInvoice;
use Application\Command\Traits\SendMailBillet;
use Carbon\Carbon;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;



class BilletFakeCommand extends BaseCommand
{
    use ExceptionsFailInvoice;

    use SendMailBillet;

    protected $name = 'fake:billet:create';
    protected $CI;
    protected $description = 'Generate fake billet and add process mailer queue';


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
        $this->CI->load->model(['eloquent/Billet_eloquent', 'eloquent/Email_setting_eloquent',
        'eloquent/MailerEloquent',
        'eloquent/Invoice_eloquent']);


        $data = [
            'body' =>
            '{"fee_session_group_id":5,"fee_master_id":17969,"fee_groups_feetype_id":24,"fee_amount":85,"fee_title":"Material Escolar - Material Escolar 1\/5","fee_discount":0,"fee_line_1":" ()","fee_line_2":"","fee_date_payment":"2021-08-17","fee_date_payment_old":"2021-08-17","fee_fine":0,"fee_date_payment_unix":1629169200,"fee_billet_old":false,"fee_item_id":17969,"due_date":"2021-08-17"}',
            'status' => 'AGUARDANDO PAGAMENTO',
            'due_date' => '2021-08-17',
            'price' => 85,
            'bank_bullet_id' => '00712260241',
            'user_id'  => 1035,
            'custom_number' => rand(10000, 20000)
        ];

        $d =  \Billet_eloquent::create($data);

        $billets = \Billet_eloquent::with(['feeItems',  'student'])
            ->where('id',  $d->id)
            ->get();
        
        foreach ($billets->groupBy('bank_bullet_id') as $row) {
            $billet =  $row->first();

            $billetsItems = \Billet_eloquent::with(['feeItems'])->where('bank_bullet_id',$billet->bank_bullet_id)
           ->get();
            $items = [];
            foreach($billetsItems as $bItem){
                $items[] = $bItem->feeItems->first();
            }
            $billet->feeItems = collect($items);
            $this->onQueue($billet, function($v) use($billet){
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
