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


        try {
            $this->CI->load->library(['mailer']);
            $options = (object) [
                'email' => 'contato@carlosocarvalho.com.br',
                'items' => [],
                'link' => 'http://#',
                'due_date' => new \DateTime
            ];
            if(!filter_var($options->email,  FILTER_VALIDATE_EMAIL))
                 throw new \Exception(sprintf('Inválid e-mail %s', $options->email));


            $content = $this->CI->load->view('mailer/billet.tpl.php', $options,  TRUE);
            $this->CI->mailer->send_mail($options->email, 'Envio de boletos', $content /**/);

            discord_log(
                sprintf('Email do boleto enviado %s %s', PHP_EOL, $options->email )
            );
        } catch (\Exception $e) {
            discord_exception(
                sprintf('Falha no e-mail %s %s', PHP_EOL, $e->getMessage() )
            );
        }

        // $this->CI->mailer->setDebug(SMTP::DEBUG_SERVER)->send_mail('contato@carlosocarvalho.com.br', 'Email tests', 'Minha mensagem de text');

        return 0;
    }
}
