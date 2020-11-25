<?php  

namespace Application\Command;


use Packages\Commands\BaseCommand;



class CancelBillet extends BaseCommand{

    protected $name = 'billet:cancel';

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
        
        $billets = \Billet_eloquent::onlyTrashed()->where('is_active',1)->get();
        

        foreach($billets as $row){
              $this->CI->bank_payment_inter->cancel(['number' => $row->bank_bullet_id, 'motive' => $row->status], 
              function($status) use(&$row){
                   if($status->success ) {
                       dump('Deleted '.  $row->id);
                          $row->is_active = 0;
                          $row->save();
                   }

                   dump($status);
              });
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

