<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use Application\Support\ComputeTributeService;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

##f3a2da46-7bd6-4870-935b-85914d23919a
//pwd
##85914d23919a

/**
 * TODO: gerar nota fiscal apos quitação do boleto bancário
 * TODO: gerar nota fiscal apos cobrança manual(adicionar checkbox para dar opção para o usuário decidir se o registro terá nota fiscal)
 * TODO: cancelar quando o usuário fizer o cancelamento manual.
 */

class InvoiceCancelCommand extends BaseCommand
{
    use ExceptionsFailInvoice;

    protected $name = 'invoice:cancel';
    protected $CI;
    protected $description = 'Cancel all invoices in database';




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

        $this
            // ...
            ->addOption('invoice_id', null, InputOption::VALUE_OPTIONAL, 'delete manual invoice');
    }

    protected function start()
    {

        $this->CI->load->model(['eloquent/Invoice_eloquent', 'eloquent/Invoice_setting_eloquent']);
        if ($this->getOption('invoice_id') !== null) {
            $this->manualCancel($this->getOption('invoice_id'));
            return 0;
        }
        $settings = \Invoice_setting_eloquent::get()->pluck('value', 'key');
        $options =  $settings->merge(['url' => 'https://barretos.sigiss.com.br/barretos/ws/sigiss_ws.php?wsdl'])->toArray();
        $provider = new Provider(new Barretos($options));
        $service  =  new SigissService($provider);
        $invoices = \Invoice_eloquent::with(['student'])->forDelete()->get();

        if ($invoices->count() == 0) return; //$this->success('Not exists invoices for delete');
        $this->text('start cancel invoices');
        foreach ($invoices as $item) {
            
            if ($item->invoice_number == null || empty($item->invoice_number)) {
                $item->forceDelete();
                continue;
            }
            // dump($item->toArray());
            try {
                $data  = [
                    'nota' =>  $item->invoice_number,
                    'email' =>  getenv('ENVIRONMENT') === 'develoment' ?  getenv('MAIL_NOTA') : $item->student->guardian_email,
                    'motivo' => 'Nota cancelada'
                ];
               
                $service->params($data)->cancel();
                $response = $service->fire();
               
                if ($response->RetornoNota->Resultado == 0) {
                    continue;
                }
                 
                $item->status =  \Invoice_eloquent::DELETED;
                $item->deleted_at = date('Y-m-d H:i:s');
                $item->save();
                // discord_log(sprintf('%s', json_encode($response->DescricaoErros, JSON_PRETTY_PRINT)) , 'Cancelamento de Nota Fiscal');
                 
                (new ComputeTributeService)->handle();
               
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                // discord_exception(
                //     sprintf('%s %s----%s', json_encode($service->getBody(), JSON_PRETTY_PRINT), PHP_EOL, $e->getMessage())
                // );

            }
        }
        // $this->text('end cancel invoices');

        return 0;
    }


    function manualCancel($id)
    {
        $settings = \Invoice_setting_eloquent::get()->pluck('value', 'key');

        $options =  $settings->merge(['url' => 'https://barretos.sigiss.com.br/barretos/ws/sigiss_ws.php?wsdl'])->toArray();

        $provider = new Provider(new Barretos($options));
        $service  =  new SigissService($provider);

        try {
            foreach (preg_split('#,#', $id) as $v) {
                $data  = [
                    'nota' => $v,
                    'email' => 'contato@carlosocarvalho.com.br',
                    'motivo' => 'Nota cancelada'
                ];
               
                $service->params($data)->cancel();
                $response = $service->fire();
                // dump($response);
                // discord_log(sprintf('%s', json_encode($response->DescricaoErros, JSON_PRETTY_PRINT)), 'Cancelamento de Nota Fiscal');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            // discord_exception(
            //     sprintf('%s %s----%s', json_encode($service->getBody(), JSON_PRETTY_PRINT), PHP_EOL, $e->getMessage())
            // );
        }
    }
}
