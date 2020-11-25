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

    private $CI;

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
        $this->CI = $CI;
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
            $doc->setEndereco( substr($data->getAddress(),0,90 ));
            $doc->setNumero( substr($data->getAddressNumber(), 0,10) );
            $doc->setBairro($data->getAddressDistrict());
            $doc->setCidade($data->getAddressCity());
            $doc->setCep($data->getAddressPostalCode());
            $doc->setCnpjCpf($data->getUserDocument());
            $doc->setUf($data->getAddressState());
            $boleto = new Boleto();
            $boleto->setCnpjCPFBeneficiario($this->settings->api_username);
            $boleto->setPagador($doc);
            $boleto->setSeuNumero( $data->getYourNumber());
            $boleto->setDataEmissao(date('Y-m-d'));
            $boleto->setValorNominal($data->getPrice());
            $boleto->setDataVencimento($data->getDatePayment()   /*date_add(new \DateTime() , new \DateInterval("P10D"))->format('Y-m-d')*/);
            $message =  new Mensagem();
            $description = explode(PHP_EOL, $data->getDescription());
            foreach ($description as $k => $v) {
                if ($k <= 4) {
                    $call = sprintf('setLinha%s', $k + 1);
                    $message->$call(substr(trim($v),0, 78));
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
   
    public function find($id)
    {
        try {
            return $this->bank->getBoleto($id);
        } catch (BancoInterException $e) {
              return;
        }
    }


    public function download($id){
      
        try {
            
            $pdf = $this->bank->getPdfBoleto($id, getenv('BANK_INTER_PDF_FILES'));
            $filename  = sprintf('%s%s.pdf', getenv('BANK_INTER_PDF_FILES'), $id);
            rename($pdf, $filename);
            echo "\n\nSalvo PDF em ".$pdf."\n";
        } catch ( BancoInterException $e ) {
            echo "\n\n".$e->getMessage();
            echo "\n\nCabeçalhos: \n";
            echo $e->reply->header;
            echo "\n\nConteúdo: \n";
            echo $e->reply->body;
        }

    }

    public function show($id){

        $filename  = sprintf('%s%s.pdf', getenv('BANK_INTER_PDF_FILES'), $id);
        if( !file_exists($filename)) $this->download($id);
        $this->CI->load->helper('file');
        
        $contents = read_file($filename);
        // Header content type 
        $this->CI->output
        ->set_header('Content-type: application/pdf')
        ->set_status_header(200)
        ->set_content_type(get_mime_by_extension($filename))
        ->set_output($contents); 
        
        // $this->CI->output->set_header('Content-Transfer-Encoding: binary'); 
        
        // $this->CI->output->set_header('Accept-Ranges: bytes');
      
        //@readfile($filename); 
        // exit();

    }

    public function list()
    {

        return $this->bank->listaBoletos(date('Y-m-d'), date_add(new \DateTime(), new \DateInterval("P50D"))->format('Y-m-d'));
    }

    //00617177078
    public function cancel($data, $onCallback)
    {
        try {
            $this->bank->baixaBoleto($data['number'], $data['motive']);
            return $onCallback((object)['success' => true]);
        } catch (BancoInterException $e) {
            $onCallback((object)['success' => false,  'status' => $e->getMessage(), 'body' => $e->reply->body]);
        }
    }
}
