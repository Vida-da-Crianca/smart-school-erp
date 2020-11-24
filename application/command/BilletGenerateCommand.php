<?php  

namespace Application\Command;


use Packages\Commands\BaseCommand;



class BilletGenerateCommand extends BaseCommand{

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

        // $this->CI->load->library('bank_payment_inter');
        $this->CI->load->model('eloquent/Billet_eloquent');
        
        $billets = \Billet_eloquent::where('status', \Billet_eloquent::FOR_CREATE )->get();

        foreach($billets as $row){
           
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

