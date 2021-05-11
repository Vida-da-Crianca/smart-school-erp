<?php

namespace Application\Support;

use Application\Support\Traits\MakeComputeTribute;
use Application\Support\Traits\NotificationComputeTribute;
use Carbon\Carbon;

class ComputeTributeService
{

    use NotificationComputeTribute, MakeComputeTribute;

    public function handle()
    {
        get_instance()->load->model([
            'eloquent/Invoice_eloquent', 'eloquent/Invoice_setting_eloquent',
            'eloquent/Invoice_resume_eloquent'
        ]);
        $dateTime = new \DateTime();
        $now = $dateTime->format('Y-m-d');
        $dateTime->modify('-1 month');
        $now = $dateTime->format('Y-m-d');
        $dateTime->modify('-11 month');

        $this->buildTotalOldMonth();

        $total = \Invoice_resume_eloquent::whereBetween('due_date', [$dateTime->format('Y-m-01'), $now])
            ->sum('total');

        $tribute = $this->makeComputeTribute($total);
        \Invoice_setting_eloquent::updateOrCreate([
            'key' => 'simple_rate',
        ], [
            'value' => str_replace('.', ',', number_format($tribute->compute_rate, 2)) . "%",
            'key' => 'simple_rate',

        ]);

        \Invoice_setting_eloquent::updateOrCreate([
            'key' => 'iss',
        ], [
            'value' => str_replace('.', ',', number_format($tribute->iss, 2)) . "%",
            'key' => 'iss',

        ]);

        $this->notifyDiscord((object) [
            'due_date' => $dateTime->format('Y-m-d'),
            'total' =>  number_format($total, 2, ',', '.'),
            'real_iss' => $tribute->real_iss,
            'iss' => $tribute->iss,
            'compute' => $tribute->compute_rate
        ]);
    }



    public function buildTotalOldMonth()
    {

        $startDate = Carbon::now()->startOfMonth()->subMonth()->toDateString();

        $endDate =  (new Carbon($startDate))->endOfMonth()->toDateString();
        $interval = [$startDate, $endDate];
        // dump($interval, Carbon::now()->toDateTimeLocalString());
        $total =  \Invoice_eloquent::whereBetween('due_date', $interval)->valid()->sum('price');

        \Invoice_resume_eloquent::updateOrCreate([
            'due_date' => $startDate,
        ], [
            'total' => $total,
            'due_date' => $startDate,

        ]);
    }
}
