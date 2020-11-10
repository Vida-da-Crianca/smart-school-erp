<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;

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
    }

    protected function start()
    {


        $this->CI->load->model(['eloquent/Invoice_eloquent', 'eloquent/Invoice_setting_eloquent']);

        $settings = \Invoice_setting_eloquent::get()->pluck('value', 'key');

        $options =  $settings->merge(['url' => 'https://barretos.sigiss.com.br/barretos/ws/sigiss_ws.php?wsdl'])->toArray();

        $provider = new Provider(new Barretos($options));

        $invoices = \Invoice_eloquent::with(['student'])->forDelete()->get();

        if ($invoices->count() == 0) return $this->success('Not exists invoices for delete');
        $this->text('start cancel invoices');
        foreach ($invoices as $item) {
            if ($item->invoice_number == null || empty($item->invoice_number)) {
                $item->forceDelete();
                continue;
            }
            try {
                $data  = [
                    'nota' =>  $item->invoice_number,
                    'email' => $item->student->guardian_email,
                    'motivo' => 'Nota cancelada'
                ];
                $service  =  new SigissService($provider);
                $service->params($data)->cancel();
                $response = $service->fire();
                if ($response->RetornoNota->Resultado == 0) {
                    continue;
                }

                $item->status =  \Invoice_eloquent::DELETED;
                $item->deleted_at = date('Y-m-d H:i:s');
                $item->save();
            } catch (\Exception $e) {
            }
        }
        $this->text('end cancel invoices');

        return 0;
    }
}
