<?php  

namespace Application\Command;

use Symfony\Component\Console\Command\Command as SCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use ctodobom\APInterPHP\BancoInter;
use ctodobom\APInterPHP\BancoInterException;
use ctodobom\APInterPHP\Cobranca\Boleto;
use ctodobom\APInterPHP\Cobranca\Pagador;
use Packages\Commands\BaseCommand;

define('CERTICATE', ROOTPATH. "erp-inter.pem" );
define('CERTIFICATE_KEY',ROOTPATH. "erp-inter.pem" );


class BulletCommand extends BaseCommand{

    protected $name = 'billet:generate';

    protected $description = '';

    protected $CI;
    
    public function __construct($CI){
        $this->CI = $CI;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);
    }

    protected function start(){

        $bank = new BancoInter('84806796', CERTICATE, CERTIFICATE_KEY);
        $bank->setKeyPassword("85914d23919a");
        $doc = new Pagador();
        $doc->setTipoPessoa(Pagador::PESSOA_FISICA);
        $doc->setNome("Carlos Carvalho");
        $doc->setEndereco("Travessa Salve a mocidade");
        $doc->setNumero('33');
        $doc->setBairro("Jardim Conquista");
        $doc->setCidade("São Paulo");
        $doc->setCep("08343320");
        $doc->setCnpjCpf('31162904828');
        $doc->setUf('SP');

        $boleto = new Boleto();
        $boleto->setCnpjCPFBeneficiario('05460684000128');
        $boleto->setPagador($doc);
        $boleto->setSeuNumero("123456");
        $boleto->setDataEmissao(date('Y-m-d'));
        $boleto->setValorNominal(5.10);
        $boleto->setDataVencimento(date_add(new \DateTime() , new \DateInterval("P10D"))->format('Y-m-d'));

        // try {
        //     echo "\nListando boletos vencendo nos próximos 10 dias (apenas a primeira página)\n";
        //     $listaBoletos = $bank->listaBoletos(date('Y-m-d'), date_add(new \DateTime() , new \DateInterval("P10D"))->format('Y-m-d'));
        //     var_dump($listaBoletos);
        // } catch ( BancoInterException $e ) {
        //     echo "\n\n".$e->getMessage();
        //     echo "\n\nCabeçalhos: \n";
        //     echo $e->reply->header;
        //     echo "\n\nConteúdo: \n";
        //     echo $e->reply->body;
        // }
        try {
            $bank->createBoleto($boleto);
            echo "\nBoleto Criado\n";
            echo "\n seuNumero: ".$boleto->getSeuNumero();
            echo "\n nossoNumero: ".$boleto->getNossoNumero();
            echo "\n codigoBarras: ".$boleto->getCodigoBarras();
            echo "\n linhaDigitavel: ".$boleto->getLinhaDigitavel();
        } catch ( BancoInterException $e ) {
            echo "\n\n".$e->getMessage();
            echo "\n\nCabeçalhos: \n";
            echo $e->reply->header;
            echo "\n\nConteúdo: \n";
            echo $e->reply->body;
        }


        // try {
        //     echo "\nBaixando boleto\n";
        //     $bank->baixaBoleto('00616514891', INTER_BAIXA_DEVOLUCAO);
        //     echo "Boleto Baixado";
        // } catch ( BancoInterException $e ) {
        //     echo "\n\n".$e->getMessage();
        //     echo "\n\nCabeçalhos: \n";
        //     echo $e->reply->header;
        //     echo "\n\nConteúdo: \n";
        //     echo $e->reply->body;
        // }
        return 0;
    }
    

}

