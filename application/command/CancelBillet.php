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
        
        $billets = \Billet_eloquent::onlyTrashed()->where('is_active',1)->get()->groupBy('bank_bullet_id');
        
        
        foreach($billets as $item){
            //   dump($row->status);
              $row = $item->first();
              $this->CI->bank_payment_inter->cancel(['number' => $row->bank_bullet_id, 'motive' => $row->status], 
              function($status) use($row){
                   if($status->success ) {
                      \Billet_eloquent::onlyTrashed()
                       ->where('bank_bullet_id', $row->bank_bullet_id)
                       ->update([
                           'is_active' => 0,
                       ]);
                   }

                //    dump($status);
                   file_put_contents(getenv('BASE_DIR') . 'schedule.log', sprintf( '%s -  %s',date('Y-m-d H:i:s'), json_encode($status) , PHP_EOL), FILE_APPEND);
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

