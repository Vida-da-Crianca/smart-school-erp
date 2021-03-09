<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use CarlosOCarvalho\Sigiss\Drivers\Barretos;
use CarlosOCarvalho\Sigiss\Provider;
use CarlosOCarvalho\Sigiss\SigissService;
use Symfony\Component\Lock\StoreInterface;
use Packages\Commands\BaseCommand;
use Symfony\Component\Console\Input\ArrayInput;
// use Symfony\Component\Process\Process;
use Amp\Loop;
use Amp\Process\Process;
use Funcionario;

use function Amp\Promise\all;



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
            'invoice:cancel' => 120,
            'invoice:create' => 120,
            'invoice:tribute' => (60 * 60),
            'billet:generate' =>  60,
            'billet:paid' => 60 * 60,
            'billet:cancel' => 10 * (60),
            'clean:directory' => 2 * (60 * 60),
            'invoice:billet-check' => 10 * 60,
            'billet:old' => 60

        ];
        foreach ($comandList as $name => $interval) {
            Loop::repeat(($interval * 1000), function ()  use ($name) {
                $process = $this->makeCommand($name);
                dump($name);
                yield $process->start();
                $stream = $process->getStdout();
                while (null !== $chunk = yield $stream->read()) {
                    // echo $chunk;
                }
                $code = yield $process->join();
                $pid = $process->getPid();
            });
        }

        Loop::run();

        // Loop::run(function()  {
        //     $comandList = [
        //         // 'invoice:cancel',
        //         // 'invoice:create',
        //         // 'invoice:tribute',
        //         // 'billet:generate',
        //         // 'billet:paid',
        //         // 'billet:cancel',
        //         // 'clean:directory',
        //         'invoice:billet-check && sleep 10'

        //     ];
        //     Loop::repeat( 1000 , function() use($comandList){
        //         $promises = [];
        //         foreach ($comandList as $name) {
        //             $command = sprintf('/usr/local/bin/php /app/man %s ', $name);
        //             $process = new Process($command);
        //             $promises[] = new \Amp\Coroutine(watch_live($process));
        //         }

        //         yield all($promises);
        //     });


        // });

        // while (true) {
        //     $options = [];
        //     foreach ($comandList as $command) {
        //         $result = null;
        //         exec(sprintf('/usr/local/bin/php /app/man %s &', $command), $result);
        //         $c = collect($result)->filter( function($row){  return !empty($row); });
        //         if ($c->count() > 0)
        //             $options[$command][] = implode(PHP_EOL,$c->toArray());
        //     }
        //     if (count($options) > 0) {
        //         discord_schedule_log(
        //             sprintf('%s', json_encode($options, JSON_PRETTY_PRINT))
        //         );
        //     }
        //     sleep(30);
        // }
        return 0;
    }



    public function makeCommand($name): Process
    {
        return new Process(sprintf('/usr/local/bin/php /app/man %s ', $name));
    }
}
