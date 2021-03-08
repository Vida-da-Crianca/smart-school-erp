<?php


namespace Application\Command;

use Application\Command\Traits\ExceptionsFailInvoice;
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
        if (getenv('ENVIRONMENT') !== 'development' && !$isValid  && \Invoice_resume_eloquent::where('due_date', Carbon::now()->sub('1','month')->format('Y-m-01'))->count() > 0) return;

        $this->buildTotalOldMonth();
        $settings = \Invoice_setting_eloquent::get()->pluck('value', 'key');
        $data = json_decode(file_get_contents(sprintf('%stributos_items.json', getenv('BASE_DIR'))));

        $dateTime->modify('-1 month');
        $now = $dateTime->format('Y-m-d');
        $dateTime->modify('-11 month');
        $total = \Invoice_resume_eloquent::whereBetween('due_date', [$dateTime->format('Y-m-01'), $now])
            ->sum('total');
        $tribute = null;

        
        dump($total);
        return;

        foreach ($data as $row) {
            if ($total >= $row->rba_min   &&  $total <=  $row->rba_max) {
                $tribute = $row;
                break;
            }
        }
        $calcA = ((($total * ($tribute->aliquota_nominal / 100)) - $tribute->valor_reduzido) / $total) * 100;
        $calcB =  $calcA * ($tribute->icms / 100);

        \Invoice_setting_eloquent::updateOrCreate([
            'key' => 'simple_rate',
        ], [
            'value' => str_replace('.', ',', number_format($calcA, 2)) . "%",
            'key' => 'simple_rate',

        ]);

        \Invoice_setting_eloquent::updateOrCreate([
            'key' => 'iss',
        ], [
            'value' => str_replace('.', ',', number_format($calcB, 2)) . "%",
            'key' => 'iss',

        ]);

        discord_log(

            json_encode(
                [
                    'total' => $total,
                    'hora' =>Carbon::now()->format('d/m/Y H:i:s'),
                    'aliquota' =>
                    str_replace('.', ',', number_format($calcA, 2)) . "%", 'iss' => str_replace('.', ',', number_format($calcB, 2)) . "%",
                    'meses' => \Invoice_resume_eloquent::whereBetween('due_date', [$dateTime->format('Y-m-01'), $now])->get()


                ],
                JSON_PRETTY_PRINT
            ),
            'Calculo do Tributo'
        );
    }



    public function getAliquota($item)
    {
    }

    public function getISS($item)
    {
    }


    /**
     * Generate faturamento of previews month
     *
     * @return void
     */
    public function buildTotalOldMonth()
    {

        $startDate = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $interval = [$startDate, Carbon::now()->subMonth()->endOfMonth()->toDateString()];
        $total =  \Invoice_eloquent::whereBetween('due_date', $interval)->valid()->sum('price');
        \Invoice_resume_eloquent::updateOrCreate([
            'due_date' => $startDate,
        ], [
            'total' => $total,
            'due_date' => $startDate,

        ]);
    }
}
