<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Packages\Commands\BaseCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;

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

        $process = new Process(['ls', '-lsa']);
        // $process->setTimeout(3600);
        $process->start();

        while (true) {
            // ...
            $comandList = [
                'invoice:cancel',
                'invoice:create',
                'billet:paid',
                'billet:cancel',
                'billet:generate'
            ];

            foreach ($comandList as $c) {
                $command = $this->getApplication()->find($c);
                $this->call($command);
            }
            // check if the timeout is reached
            $process->checkTimeout();

            sleep(30);
        }

        return 0;
    }



    public function call($app, $options = [])
    {
        $arguments = new ArrayInput($options);
        return $app->run($arguments, $this->_output);
    }
}
