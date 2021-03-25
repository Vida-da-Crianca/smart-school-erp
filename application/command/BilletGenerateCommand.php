<?php

namespace Application\Command;

use Application\Core\BankInterPayment;
use Billet_eloquent;
use Illuminate\Database\Eloquent\Collection;
use Packages\Commands\BaseCommand;
use stdClass;
use Illuminate\Database\Capsule\Manager as DB;


class BilletGenerateCommand extends BaseCommand
{

    protected $name = 'billet:generate';

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

        $this->CI->load->library(['bank_payment_inter', 'mailer']);
        $this->CI->load->model(['eloquent/Billet_eloquent', 'eloquent/Email_setting_eloquent', 'eloquent/Invoice_eloquent']);


        DB::beginTransaction();

        try {


            $billets = \Billet_eloquent::whereNull('bank_bullet_id')
                ->with(['feeItems', 'student'])
                ->get()->groupBy('user_id');

            foreach ($billets as $row) {

                $group = $row->groupBy('due_date');
                $this->buildByOnDueDate($group);
            }
        } catch (\Exception $e) {
            discord_exception(
                sprintf('%s----%s', PHP_EOL, $e->getMessage())
            );
        }


        return 0;
    }


    protected function callGrouped($data, $callback)
    {
        foreach ($data as $row) {
            $callback($row);
        }
    }


    protected function sendMail($options)
    {
        try {
            $content = $this->CI->load->view('mailer/billet.tpl.php', $options,  TRUE);
            $this->CI->mailer->send_mail($options->email, 'Envio de boletos', $content /**/);
            discord_log(
                sprintf('Email do boleto enviado %s %s', PHP_EOL, $options->email )
            );
            
        } catch (\Exception $e) {
            discord_exception(
                sprintf('Falha no e-mail %s %s', PHP_EOL, $e->getMessage)
            );
        }
    }


    public function buildByOnDueDate($data)
    {


        foreach ($data as $row) {

            $student = null;
            $descriptions = [];
            $billet = new \stdClass();
            $billet->price = 0;
            $billet->due_date = null;
            $billet->description = null;
            $billet->id = [];
            $billet->mail_items = [];
            $billet->custom_number = substr(md5(rand(10, 1000) . date('YmdHis')), 0, 10);

            $this->callGrouped($row, function ($item) use (&$billet, &$student, &$descriptions, &$items) {

                $billet->id[] = $item->id;
                $first = $item->feeItems()->first();
                $body =  $item->body_json;
                $billet->price +=  $item->price;
                $billet->due_date = $item->due_date;
                $student = $item->student;

                $billet->mail_items[] = (object)[
                    'name' => $student->full_name,
                    'due_date' => new \DateTime($first->due_date),
                    'description' => $first->title,
                    'price' => sprintf('%s', number_format($first->amount - $body->fee_discount, 2, ',', '.'))
                ];

                $descriptions[] =  sprintf('%s - %s - R$ %s - Desc. R$ %s', $student->full_name, $first->title, number_format($first->amount, 2, ',', '.'), number_format($body->fee_discount, 2, ',', '.'));
            });
            //   dump( $billet->mail_items);
            // continue;
            if (count($billet->id) == 0 || !$student) {

                discord_exception(
                    sprintf('%s%s----%s', sprintf('Sem dados do usuário (%s)', json_encode($billet->id)), PHP_EOL, json_encode($row->toArray(), JSON_PRETTY_PRINT))
                );
                if (count($billet->id) > 0) {

                    \Billet_eloquent::whereIn('id', $billet->id)
                        ->update([
                            'deleted_at' => date('Y-m-d H:i:s'),
                            'is_active' => 0
                        ]);
                    DB::commit();
                }

                continue;
            }

            $payment = $this->buildOptionsStudentPayment($student);
            $billet->description = implode(PHP_EOL, $descriptions);

            $this->buildOptionsBilletPayment($payment, $billet);
            $this->push($payment, function ($options) use ($billet, $student) {
                //  if($id == null) return;
                $this->onPush($options, $billet, $student);
            });
        }
    }


    public function onPush($options, $billet, $student)
    {

        if (!$options->success) {
            discord_log(sprintf('%s', json_encode($options, JSON_PRETTY_PRINT)), 'Falha ao gerar boleto');
            return;
        };
        \Billet_eloquent::whereIn('id', $billet->id)
            ->update([
                'custom_number' => $billet->custom_number,
                'bank_bullet_id' => $options->billet->number,
            ]);
        DB::commit();
        discord_log(sprintf('%s', json_encode($options, JSON_PRETTY_PRINT)), 'Novo Boleto');
        // \Invoice_eloquent::create([
        //     'price' =>  $billet->price,
        //     'status' => \Invoice_eloquent::PENDING_CREATE,
        //     'due_date' =>  $billet->due_date,
        //     'bullet_id' => $billet->id[0],
        //     'user_id' =>  $student->id,
        // ]);
        $items = [];
        foreach ($billet->mail_items as $row) {
            $row->billet = $options->billet->number;
            $items[] = $row;
        }

        $data = (object) [
            'name' => $student->guardian_name,
            'email' => getenv('ENVIRONMENT') == 'development' ?  'contato@carlosocarvalho.com.br' : $student->guardian_email,
            'id' => $options->billet->number,
            'link' => site_url('billet/live/' . $options->billet->number),
            'code' => $options->billet->barcode,
            'file' => '',
            'due_date' =>  new \DateTime($billet->due_date),
            'items' => $items
        ];

        $this->sendMail($data);
    }

    public function buildOptionsStudentPayment($student)
    {
        $payment = new BankInterPayment;
        $payment->user =  $student->guardian_name;
        $payment->user_document =  $student->guardian_document;
        $payment->address = $student->guardian_address;
        $payment->address_state = $student->guardian_state;
        $payment->address_district = $student->guardian_district;
        $payment->address_city = $student->guardian_city;
        $payment->address_number = $student->guardian_address_number;
        $payment->address_postal_code = $student->guardian_postal_code;


        return $payment;
    }

    public function buildOptionsBilletPayment(&$payment, &$billet)
    {

        $payment->price = $billet->price;
        $payment->date_payment = $billet->due_date;
        $payment->description =  $billet->description;
        $payment->your_number  = $billet->custom_number;
    }


    public function push($payment, \Closure $callback)
    {
        //    $callback(['success']);    
        $this->CI->bank_payment_inter->create($payment, $callback);
    }
}
