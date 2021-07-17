<?php

namespace Application\Command\Traits;



trait ExceptionsFailInvoice
{


    public function handleExceptionFailInvoice($errors)
    {
        $data =  [];
        foreach ($errors as $e) {
            $data[] = $e->DescricaoErro;
        }
        if (count($data) > 0)
        throw new \Exception(implode(PHP_EOL, $data));
    }
}
