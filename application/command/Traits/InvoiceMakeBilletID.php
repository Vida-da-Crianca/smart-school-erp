<?php

namespace Application\Command\Traits;

// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

trait InvoiceMakeBilletID
{


    
    public function makeBilletId(SupportCollection $data){
         $ids = [];
         foreach($data as $listGroup){
               $listGroup->first()->id;
         }
    }
}
