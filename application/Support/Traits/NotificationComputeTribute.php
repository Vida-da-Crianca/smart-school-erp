<?php

namespace Application\Support\Traits;

use Carbon\Carbon;


trait NotificationComputeTribute
{


    public function notifyDiscord($item)
    {

        discord_log(

            json_encode(
                [
                    'total' => $item->total,
                    'hora' => Carbon::now()->format('d/m/Y H:i:s'),
                    'aliquota' =>
                    str_replace('.', ',', number_format($item->compute, 2)) . "%", 'iss' => str_replace('.', ',', number_format($item->iss, 2)) . "%",
                    'meses' => \Invoice_resume_eloquent::whereBetween('due_date', [$item->due_date, Carbon::now()])->get()


                ],
                JSON_PRETTY_PRINT
            ),
            'Calculo do Tributo'
        );
    }
}
