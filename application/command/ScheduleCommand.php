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
use Carbon\Carbon;
use Funcionario;
use Amp\ByteStream;

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
            // 'invoice:cancel' => 120,
            // 'invoice:create' => 120,
            // 'invoice:tribute' => (60 * 60),
            // 'billet:generate' =>  60,
            // 'billet:paid' => 60 * 60,
            // 'billet:cancel' => 10 * (60),
            // 'clean:directory' => 2 * (60 * 60),
            // 'invoice:billet-check' => 10 * 60,
            // 'billet:old' => ['at' => '08:00', 'timezone' => 'America/Sao_Paulo', 'interval' => 60],
            // 'queue:mailer' => 60

        ];
        $runningProcess = [];
        foreach ($comandList as $name => $interval) {
            $data = [];
            if (is_array($interval)) {
                $data =  $interval;
                $interval =  $interval['interval'];
            }
            Loop::repeat(($interval * 1000), function ($row)  use ($name, $data, &$runningProcess) {
               
                if (!$data) {
                    $this->consoleLog($name, 1);
                    $runningProcess[] = $name;
                    $process = $this->makeCommand($name);
                    yield $process->start();
                    $stream =  yield ByteStream\buffer($process->getStdout());
                    $this->text($stream);
                    $code = yield $process->join();
                    $pid = $process->getPid();
                    
                    $this->consoleLog($name, 0);

                } else {

                    $dt = Carbon::now();
                    $dt->tz = $data['timezone'];
                    $dt->format('H:i');
                    // $this->text('schedule running at ==> ' .  $dt->format('H:i'));
                    if ($data['at'] !== $dt->format('H:i')) {
                        return;
                    }
                    $this->consoleLog($name, 1);
                    $process = $this->makeCommand($name);
                    yield $process->start();
                    $stream = $process->getStdout();
                    // while (null !== $chunk = yield $stream->read()) {
                    //     $this->text('stream: --- ' . $chunk);
                    // }
                    $code = yield $process->join();
                    $pid = $process->getPid();
                     
                    $this->consoleLog($name, 0);
                }
            });
        }
        Loop::run();

        return 0;
    }

    public function consoleLog($name, $code = 1)
    {  
        $msg =  $code == 1 ? 'iniciado' : 'finalizado';
        $ts = date('d/m/Y H:i:s'); 
        $this->text("{$ts} - Processo [{$name}] {$msg} {$code}  ");

        if($code == 0) 
          \ProcessControl::where('name', $name)->delete();
    }

    public function makeCommand($name): Process
    {
        return new Process(sprintf('/usr/local/bin/php /app/man %s ', $name));
    }
}
