<?php 



namespace Application\Command\Fake;

use Application\Command\Traits\ExceptionsFailInvoice;
use Carbon\Carbon;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;



class InvoiceCommand extends BaseCommand
{
    use ExceptionsFailInvoice;

    protected $name = 'fake:invoice:create';
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


        $item = \Invoice_eloquent::with(['student', 'billet',  'feeStudentDeposite.feeGroupType.feeGroup', 'feeStudentDeposite.feeItem'])
         ->where('id', 267)
        ->orderBy('id', 'desc')
        // ->limit(1)
        ->first();

      

        $options = $settings->toArray();
        $aliquota = str_replace([',', '%'], ['.', ''], $options['iss']);
        $simple_rate = str_replace([',', '%'], ['.', ''], $options['simple_rate']);
        $first = Carbon::now();
        $trys = [10, 15, 20, 25, 30];

        // dump($invoices->filter(function($row){ return $row->bullet_id == 66 ;})->toArray());
        // return;
    


            $this->buildInvoiceDescription($item);
            $calc = ($aliquota / 100) * $item->price;
            $al = number_format($calc, 2, ',', '.');


            $descptionNF = $item->description != null ?  $item->description : sprintf('%s %s %s', $item->student->full_name, PHP_EOL, $item->_description);
            $tributteCalculate = number_format((($simple_rate / 100) * $item->price), 2, ',', '.');
            $data  = [
                'valor' => str_replace('.', ',', $item->price),
                'base'  => str_replace('.', ',', $item->price),
                'descricaoNF' =>   $descptionNF, //sprintf('%s%sValor aprox. dos tributos (Lei nº 12.741/2012):  R$ %s - Aliq: %s', $descptionNF, PHP_EOL , $tributteCalculate, $options['simple_rate']) ,
                'tomador_tipo' => 2,
                'total_tributos' => $tributteCalculate,
                'tomador_cnpj' => $item->student->guardian_document, //cnoj da empresa
                'tomador_email' =>  getenv('ENVIRONMENT') == 'development' ?  getenv('MAIL_NOTA') : $item->student->guardian_email,
                'tomador_razao' => $item->student->guardian_name,
                'tomador_endereco' => $item->student->guardian_address,
                'tomador_numero' => $item->student->guardian_address_number,
                'tomador_bairro' => $item->student->guardian_district,
                'tomador_CEP' => $item->student->guardian_postal_code,
                'tomador_cod_cidade' => getCodeCity($item->student->guardian_city),
                'rps_num' => '',
                'id_sis_legado' => '',
                // 'iss' => $options['iss'],
                'aliquota_simples' => $aliquota,
                // 'aliquota_atividade'=> $options['aliquota_atividade'],
                'retencao_iss' => ($aliquota / 100) * $item->price,
                'rps_serie' => $options['serie'],
                'serie' =>  $options['serie']
            ];
           
            \Invoice_eloquent::where('id', $item->id)->update(['latest_try_at' => Carbon::now()]);

            $service  =  new SigissService($provider);
            try {


                $service->params($data)->create();
                $response = $service->fire();

                // dump($service->getBody());

                if ($response->RetornoNota->Resultado > 0) {

                    dump($response->RetornoNota);
                    unset($item->_description);
                    $item->update([
                        'invoice_number' => $response->RetornoNota->Nota,
                        'status' => \Invoice_eloquent::VALID,
                        'body' => json_encode($response->RetornoNota)
                    ]);
                  

                   // discord_log(sprintf('%s', json_encode(array_merge((array) $response->RetornoNota, ['numero_controle' =>  $item->id, 'nota' => $service->getBody()]), JSON_PRETTY_PRINT)), 'Nova Nota Fiscal');
                }
                if ($response->RetornoNota->Resultado == 0) {

                    discord_exception(
                        sprintf('%s', json_encode(array_merge((array)$response, ['numero_controle' =>  $item->id, 'nota' => $service->getBody()]), JSON_PRETTY_PRINT)),
                        'Falha ao criar nota'
                    );
                }


                dump($service->getBody());


            } catch (\Exception $e) {

                $response = $service->getClientSoap()->__getLastResponse();
                // discord_exception(
                //     sprintf('%s %s----%s', json_encode($service->getBody(), JSON_PRETTY_PRINT), PHP_EOL, $e->getMessage())
                // );
                dump($e->getMessage());
            }
        

        return 0;
    }




    public function buildInvoiceDescription(&$item)
    {
        $item->_description  = 'S/N';
        if (!$item->billet && !$item->description) {
            $item->_description = $item->feeStudentDeposite->feeItem->title;
            return;
        }

        if ($item->description != null) return;
        $billet = $item->billet()->with('feeItems')->first();
        $collectionDescriptions = [];
        $item->price = $billet->price;
        if ($item->description !=  null) {
        }

        foreach ($billet->feeItems as $row) {
            $collectionDescriptions[] = sprintf('%s - R$ %s', $row->title, number_format($row->amount, 2, ',', '.'));
        }
        $collectionDescriptions[] = sprintf('Boleto %s/%s ', $billet->custom_number,  $billet->bank_bullet_id);

        $item->_description =  sprintf('%s', implode(PHP_EOL, $collectionDescriptions));
    }
}



