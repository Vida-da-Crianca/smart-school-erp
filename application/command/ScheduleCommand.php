<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;
use Symfony\Component\Console\Input\ArrayInput;

class ScheduleCommand extends BaseCommand
{
    use ExceptionsFailInvoice;

    protected $name = 'schedule:run';
    protected $CI;
    protected $description = 'Run all schedule';


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
        $this->title('Schedule running');

        $comandList = [
            'invoice:cancel',
            'invoice:create',
            'billet:paid'
        ];

        foreach ($comandList as $c) {
            $command = $this->getApplication()->find($c);
            $this->call($command);
        }
        return 0;
    }



    public function call($app, $options = [])
    {
        $arguments = new ArrayInput($options);
        return $app->run($arguments, $this->_output);
    }
}
