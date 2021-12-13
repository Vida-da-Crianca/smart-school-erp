<?php


namespace Application\Command;

use Application\Command\Traits\SendMailBillet;
use Application\Core\BankInterPayment;
use Billet_eloquent;

use ctodobom\APInterPHP\BancoInter;
use ctodobom\APInterPHP\Cobranca\Boleto;
use ctodobom\APInterPHP\Cobranca\Pagador;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Packages\Commands\BaseCommand;
use stdClass;
use Illuminate\Database\Capsule\Manager as DB;


class BankTestCommand extends BaseCommand
{
    // use SendMailBillet, PaymentInter;

    protected $name = 'billet:test:generate';

    protected $description = '';

    protected $CI;


    protected $forGenerateItems = [];

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
        // $this->CI->load->library(['bank_payment_inter', 'mailer']);
        // $this->CI->load->model(['eloquent/Billet_eloquent',
        // 'eloquent/Email_setting_eloquent',
        // 'eloquent/MailerEloquent',
        //  'eloquent/Invoice_eloquent']);


    

        try {

            $conta = "84806796";
            $cnpj = "05460684000128";
            $certificado = "/app/certificates/inter/2022.pem";
            $chavePrivada = "/app/certificates/inter/2022.key";
            // dados de teste
            $cpfPagador = "36635374043";
            $estadoPagador = "SP";
         
            $banco = new BancoInter($conta, $certificado, $chavePrivada);
           
            $pagador = new Pagador();
            $pagador->setTipoPessoa(Pagador::PESSOA_FISICA);
            $pagador->setNome("Nome de Teste");
            $pagador->setEndereco("Nome da rua");
            $pagador->setNumero(42);
            $pagador->setBairro("Centro");
            $pagador->setCidade("Cidade");
            $pagador->setCep("12345000");
            
            $pagador->setCnpjCpf($cpfPagador);
            $pagador->setUf($estadoPagador);
            
            $boleto = new Boleto();
            $boleto->setCnpjCPFBeneficiario($cnpj);
            $boleto->setPagador($pagador);
            $boleto->setSeuNumero("123456");
            $boleto->setDataEmissao(date('Y-m-d'));
            $boleto->setValorNominal(100.10);
            $boleto->setDataVencimento(date_add(new DateTime() , new DateInterval("P10D"))->format('Y-m-d'));
            $banco->createBoleto($boleto);
            echo "\nBoleto Criado\n";
            echo "\n seuNumero: ".$boleto->getSeuNumero();
            echo "\n nossoNumero: ".$boleto->getNossoNumero();
            echo "\n codigoBarras: ".$boleto->getCodigoBarras();
            echo "\n linhaDigitavel: ".$boleto->getLinhaDigitavel();
           
         
        } catch (\Exception $e) {
            echo "\n\n".$e->getMessage();
            echo "\n\nCabeçalhos: \n";
            echo $e->reply->header;
            echo "\n\nConteúdo: \n";
            echo $e->reply->body . "\n";
        }


        return 0;
    }
}

