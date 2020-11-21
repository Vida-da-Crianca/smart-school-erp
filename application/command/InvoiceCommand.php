<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Invoice_eloquent;
use Packages\Commands\BaseCommand;

##f3a2da46-7bd6-4870-935b-85914d23919a
//pwd
##85914d23919a

/**
 * TODO: gerar nota fiscal apos quitação do boleto bancário
 * TODO: gerar nota fiscal apos cobrança manual(adicionar checkbox para dar opção para o usuário decidir se o registro terá nota fiscal)
 * TODO: cancelar quando o usuário fizer o cancelamento manual.
 */

class InvoiceCommand extends BaseCommand
{
    use ExceptionsFailInvoice;

    protected $name = 'invoice:create';
    protected $CI;
    protected $description = 'Generate all invoices in database';


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

        log_message('debug', "Invoice generate started");
        $this->CI->load->model(['eloquent/Invoice_eloquent', 'eloquent/Invoice_setting_eloquent']);

        $settings = \Invoice_setting_eloquent::get()->pluck('value', 'key');

        $options =  $settings->merge(['url' => 'https://barretos.sigiss.com.br/barretos/ws/sigiss_ws.php?wsdl'])->toArray();

        // return dump($options);


        $provider = new Provider(new Barretos($options));

        $invoices = \Invoice_eloquent::with(['student', 'feeStudentDeposite.feeGroupType.feeGroup', 'feeStudentDeposite.feeItem'])->forGenerate()->get();

       if( $invoices->count() == 0) return $this->success('Not exists invoices for create');

        foreach ($invoices as $item) {
            $address = explode(',', $item->student->guardian_address);
          
            $data  = [
                'valor' => $item->price,
                'base'  => $item->price,
                'descricaoNF' => $item->feeStudentDeposite->feeItem->title,
                'tomador_tipo' => 2,
                'tomador_cnpj' => $item->student->guardian_document, //cnoj da empresa
                'tomador_email' => $item->student->guardian_email,
                'tomador_razao' => $item->student->guardian_name,
                'tomador_endereco' => $address[0],
                'tomador_numero' => $address[1],
                'tomador_bairro' => $item->student->guardian_district,
                'tomador_CEP' => $item->student->guardian_postal_code,
                'tomador_cod_cidade' => getCodeCity($item->student->guardian_city),
                'rps_num' => '',
                'id_sis_legado' => '',
                'rps_serie' => $settings->toArray()['serie'],
                'serie' =>  $settings->toArray()['serie']
            ];

            // dump($data);
            $service  =  new SigissService($provider);
            try {

               
                $service->params($data)->create();

                $response = $service->fire();

               
                if ($response->RetornoNota->Resultado > 0) {
                    $item->update(['invoice_number' => $response->RetornoNota->Nota, 
                    'status' => Invoice_eloquent::VALID,
                    'body' => json_encode($response->RetornoNota)]);
                    // $this->handleExceptionFailInvoice($response->DescricaoErros);
                }

            } catch (\Exception $e) {
                $response = $service->getClientSoap()->__getLastResponse();
                //dump($response);
               dump($e->getMessage());
            }
        }

        return 0;
    }
}
