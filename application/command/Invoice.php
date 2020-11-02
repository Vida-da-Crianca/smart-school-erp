<?php 


namespace Application\Command;

use Symfony\Component\Console\Command\Command as C;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

##f3a2da46-7bd6-4870-935b-85914d23919a
//pwd
##85914d23919a

/**
 * TODO: gerar nota fiscal apos quitação do boleto bancário
 * TODO: gerar nota fiscal apos cobrança manual(adicionar checkbox para dar opção para o usuário decidir se o registro terá nota fiscal)
 * TODO: cancelar quando o usuário fizer o cancelamento manual.
 */

class Invoice extends C
{

    protected $name = 'invoice:generate';

    public function __construct()
    {
       parent::__construct();    
    }

    protected function configure()
    {
          $this->setName($this->name);       
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         dump('Invoice generato');
         return 0;
    }
}