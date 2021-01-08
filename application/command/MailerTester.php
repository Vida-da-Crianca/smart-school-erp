<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;

class MailerTester extends BaseCommand
{
    use ExceptionsFailInvoice;

    protected $name = 'mail:test';
    protected $CI;
    protected $description = 'Run all schedule';


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
       

        $this->CI->load->library(['mailer']);
        $this->CI->mailer->setDebug(SMTP::DEBUG_SERVER)->send_mail('contato@carlosocarvalho.com.br', 'Email tests', 'Minha mensagem de text');
         
        return 0;
    }




}
