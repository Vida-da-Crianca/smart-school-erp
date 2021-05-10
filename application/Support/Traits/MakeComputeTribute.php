<?php

namespace Application\Support\Traits;


/**
 * Make Compute Tribute
 */
trait MakeComputeTribute
{


    public function makeComputeTribute($total)
    {
        $data = json_decode(file_get_contents(sprintf('%stributos_items.json', getenv('BASE_DIR'))));
        $tribute = null;
        foreach ($data as $row) {
            if ($total >= $row->rba_min   &&  $total <=  $row->rba_max) {
                $tribute = $row;
                break;
            }
        }
        
        $calcA = ((($total * ($tribute->aliquota_nominal / 100)) - $tribute->valor_reduzido) / $total) * 100;
        $calcB =  $calcA * ($tribute->iss / 100);
        $iss = $calcB < 2 ? 2 : ($calcB > 5 ? 5 :  $calcB);


        return (object) [
            'compute_rate' => $calcA ?? $calcA,
            'compute' => $calcB ?? $calcB,
            'iss' => $iss ?? $iss,
            'real_iss' => $calcB ?? $calcB
        ];
    }
}
