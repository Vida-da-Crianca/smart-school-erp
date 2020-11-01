<?php

use Application\Core\Contracts\BankInterContract;
use ctodobom\APInterPHP\BancoInter;
use ctodobom\APInterPHP\BancoInterException;
use ctodobom\APInterPHP\Cobranca\Boleto;
use ctodobom\APInterPHP\Cobranca\Mensagem;
use ctodobom\APInterPHP\Cobranca\Pagador;


class Bank_payment_inter
{

    /**
     * ctodobom\APInterPHP\BancoInter
     */
    private $bank;

    private $sender;

    /**
     * 
     */
    private $settings;

    public function __construct($options = [])
    {

        log_message('debug', "BankPaymentInter Class Initialized");
        $CI = get_instance();

        $CI->load->model('eloquent/Payment_setting_eloquent');
        $CI->load->model('eloquent/Billet_eloquent');
        $settings = Payment_setting_eloquent::where('payment_type', 'banco_inter')->first();
        $this->bank = new BancoInter($settings->account_no, $settings->api_secret_key, $settings->api_publishable_key);
        $this->bank->setKeyPassword($settings->api_password);
        $this->settings = $settings;
    }

    private function configure($options = [])
    {
    }


    public function sender($data)
    {

        return $this;
    }

    public function create(BankinterContract $data, \Closure $onCallback)
    {
        try {

            $doc = new Pagador();
            $doc->setTipoPessoa(Pagador::PESSOA_FISICA);
            $doc->setNome($data->getUser());
            $doc->setEndereco($data->getAddress());
            $doc->setNumero($data->getAddressNumber());
            $doc->setBairro($data->getAddressDistrict());
            $doc->setCidade($data->getAddressCity());
            $doc->setCep($data->getAddressPostalCode());
            $doc->setCnpjCpf($data->getUserDocument());
            $doc->setUf($data->getAddressState());
            $boleto = new Boleto();
            $boleto->setCnpjCPFBeneficiario($this->settings->api_username);
            $boleto->setPagador($doc);
            $boleto->setSeuNumero($data->getYourNumber());
            $boleto->setDataEmissao(date('Y-m-d'));
            $boleto->setValorNominal($data->getPrice());
            $boleto->setDataVencimento($data->getDatePayment()   /*date_add(new \DateTime() , new \DateInterval("P10D"))->format('Y-m-d')*/);
            $message =  new Mensagem();
            $description = explode(PHP_EOL, $data->getDescription());
            foreach ($description as $k => $v) {
                if ($k <= 4) {
                    $call = sprintf('setLinha%s', $k + 1);
                    $message->$call(trim($v));
                }
            }
            $boleto->setMensagem($message);

            // dump($boleto);
            $this->bank->createBoleto($boleto);

            return $onCallback((object)['success' => true, 'billet' => (object) [
                'number' => $boleto->getNossoNumero(),
                'barcode' => $boleto->getCodigoBarras()
            ]]);
        } catch (BancoInterException $e) {
            $onCallback((object)['success' => false,  'status' => $e->getMessage(), 'body' => $e->reply->body]);
        }
    }


    public function list()
    {

        return $this->bank->listaBoletos(date('Y-m-d'), date_add(new \DateTime() , new \DateInterval("P20D"))->format('Y-m-d'));
    }

    //00617177078
    public function down($number, $motive = 'ACERTOS')
    {

        return true;
    }
}
