<?php  

namespace Application\Command;


use Packages\Commands\BaseCommand;



class PaidBillet extends BaseCommand{

    protected $name = 'billet:paid';

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

        $this->CI->load->library('bank_payment_inter');
        $this->CI->load->model('eloquent/Billet_eloquent');
        
        $billets = \Billet_eloquent::where('status', \Billet_eloquent::PAID_PENDING )->get();

        foreach($billets as $row){
             $b = $this->CI->bank_payment_inter->find($row->bank_bullet_id);
             if($b->situacao == 'PAGO'){
                   $row->update(['status' => \Billet_eloquent::PAID]);
                   
             }
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

