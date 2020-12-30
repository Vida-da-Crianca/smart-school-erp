<?php


namespace Application\Command;

use AG\DiscordMsg;
use Application\Command\Traits\ExceptionsFailInvoice;
use Carbon\Carbon;
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

        $invoices = \Invoice_eloquent::with(['student', 'billet',  'feeStudentDeposite.feeGroupType.feeGroup', 'feeStudentDeposite.feeItem'])->forGenerate()->get();

        if ($invoices->count() == 0) return $this->success('Not exists invoices for create');
          
        $options = $settings->toArray();
        $aliquota = str_replace([',','%'], ['.',''],$options['simple_rate']);
        $first = Carbon::now();
        foreach ($invoices as $item) {
            
            if( $item->latest_try_at !=  null){
                $timed = Carbon::create($item->latest_try_at);
                if($timed->diffInMinutes() != 10)
                  continue;
            }
            

            
             
            $this->buildInvoiceDescription($item);
            $calc = ($aliquota / 100) * $item->price;
            $al = number_format($calc,2,',', '.');
            
           
            
            $data  = [
                'valor' => $item->price,
                'base'  => $item->price,
                'descricaoNF' => sprintf('%s %s %s', $item->student->full_name, PHP_EOL, $item->_description),
                'tomador_tipo' => 2,
                'tomador_cnpj' => $item->student->guardian_document, //cnoj da empresa
                'tomador_email' =>  getenv('ENVIRONMENT') === 'develoment' ?  getenv('MAIL_NOTA') : $item->student->guardian_email,
                'tomador_razao' => $item->student->guardian_name,
                'tomador_endereco' => $item->student->guardian_address,
                'tomador_numero' => $item->student->guardian_address_number,
                'tomador_bairro' => $item->student->guardian_district,
                'tomador_CEP' => $item->student->guardian_postal_code,
                'tomador_cod_cidade' => getCodeCity($item->student->guardian_city),
                'rps_num' => '',
                'id_sis_legado' => '',
                'iss' => $options['iss'],
                'aliquota_simples' => $aliquota,
                // 'aliquota_atividade'=> $options['aliquota_atividade'],
                // 'retencao_iss' => '2.80%',
                'rps_serie' => $options['serie'],
                'serie' =>  $options['serie']
            ];

            // dump($data);
            // continue;
            \Invoice_eloquent::where('id', $item->id)->update(['latest_try_at' => Carbon::now()]);
            
            $service  =  new SigissService($provider);
            try {


                $service->params($data)->create();
                $response = $service->fire();

                // dump($service->getBody());

                if ($response->RetornoNota->Resultado > 0) {
                    unset($item->_description);
                    $item->update(['invoice_number' => $response->RetornoNota->Nota, 
                    'status' => Invoice_eloquent::VALID,
                    'body' => json_encode($response->RetornoNota)]);
                    discord_log(sprintf('%s', json_encode($response->RetornoNota, JSON_PRETTY_PRINT)) , 'Nova Nota Fiscal');

                }
                if ($response->RetornoNota->Resultado == 0) {
                    discord_exception(
                        sprintf('%s', json_encode($response, JSON_PRETTY_PRINT)),
                        'Falha ao criar nota'
                    );
                }
                

                dump($response);

           
            } catch (\Exception $e) {

                $response = $service->getClientSoap()->__getLastResponse();
                discord_exception(
                    sprintf('%s %s----%s', json_encode($service->getBody(), JSON_PRETTY_PRINT), PHP_EOL, $e->getMessage())
                );
                // dump($e->getMessage());
            }
        }

        return 0;
    }

    


    public function buildInvoiceDescription(&$item)
    {
        $item->_description  = 'S/N';
        if (!$item->billet ) {
            $item->_description = $item->feeStudentDeposite->feeItem->title;
            return;
        }

        $billet = $item->billet()->with('feeItems')->first();
        $collectionDescriptions = [];
        $item->price = $billet->price;
        foreach ($billet->feeItems as $row) {
            $collectionDescriptions[] = sprintf('%s - R$ %s', $row->title, number_format($row->amount, 2, ',', '.'));
        }
        $collectionDescriptions[] = sprintf('Boleto %s/%s ', $billet->custom_number,  $billet->bank_bullet_id );

        $item->_description =  sprintf('%s', implode(PHP_EOL, $collectionDescriptions));
    }
}
