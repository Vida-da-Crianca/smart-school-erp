<?php

namespace Application\Command\Queue;

use Packages\Commands\BaseCommand;



class MailerCommand extends BaseCommand
{

    protected $name = 'queue:mailer';
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
        $this->CI->load->model([
            'eloquent/MailerEloquent',
            'eloquent/MessageEloquent'
        ]);

        $this->CI->load->library('mailer', null, 'LMailer');
        $data =  \MailerEloquent::whereNull('sended_at')->get();
        // dump($data->count());
        foreach ($data as $row) {
            try {
                $status = $this->CI->LMailer->send_mail(
                    getenv('ENVIRONMENT') == 'development' ?  'contato@carlosocarvalho.com.br' : $row->to,
                    $row->subject,
                    $row->message /**/
                );
                if ($row->retry  == $row->max_retry) continue;

                if ($status) {

                    $log = [
                        'title' =>sprintf('<span style="color: green;">✓</span> Novo boleto enviado - [%s]', $row->to),
                        'send_mail' => 1,
                        'message' => sprintf(
                            'Um novo e-mail foi enviado para o e-mail %s',
                           $row->to,
                        ),
                        'is_individual' => 1
                    ];
                    \MessageEloquent::create($log);
                    $row->update(['sended_at' => date('Y-m-d H:i:w')]);
                }

                if (!$status) {
                    throw new \Exception($this->CI->LMailer->error);
                }
            } catch (\Exception $e) {


                $row->increment('retry');
                $countRetry = $row->retry;
                if ($countRetry == $row->max_retry) {
                  $row->delete();
                }

                $this->logFailure($row, $e->getMessage());
            }
        }
    }




    function logFailure($row, $message)
    {
        $log = [
            'title' => sprintf('<span style="color: red;">⊘</span> Falha no envio de boleto - [%s]', $row->to),
            'send_mail' => 1,
            'message' => sprintf(
                'Houve uma falha no envio de e-mail <b>%s</b> <br/><b>Dados do erro </b> <br/> <hr/> %s ',
                $row->to,
                $message
            ),
            'is_individual' => 1
        ];
        \MessageEloquent::create($log);
    }
}
