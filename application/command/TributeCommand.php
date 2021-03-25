<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
use Application\Support\ComputeTributeService;
use Carbon\Carbon;
use Packages\Commands\BaseCommand;

use Illuminate\Database\Capsule\Manager as DB;

class TributeCommand extends BaseCommand
{
    use ExceptionsFailInvoice;

    protected $name = 'invoice:tribute';
    protected $CI;
    protected $description = 'Generate all tribute for invoice';


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


        $dateTime = new \DateTime();
        $second = Carbon::create($dateTime->format('Y'), $dateTime->format('m'), 1, 0, 0);
        $first = Carbon::create($dateTime->format('Y'), $dateTime->format('m'), 1, 0, 40);

        $isValid = Carbon::create(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d'),
            $dateTime->format('H'),
            $dateTime->format('i')
        )->betweenIncluded($first, $second);

        $this->CI->load->model([
            'eloquent/Invoice_eloquent', 'eloquent/Invoice_setting_eloquent',
            'eloquent/Invoice_resume_eloquent'
        ]);
        if (getenv('ENVIRONMENT') !== 'development' && !$isValid  && \Invoice_resume_eloquent::where('due_date', Carbon::now()->sub('1', 'month')->format('Y-m-01'))->count() > 0) return;
        (new ComputeTributeService)->handle();
    }
}
