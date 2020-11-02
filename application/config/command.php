<?php

//Register your commands


return [

    'invoice' => Application\Command\Invoice::class, 
    'billet_cancel' => Application\Command\CancelBillet::class, 
    'billet_paid' => Application\Command\PaidBillet::class, 
    'migrate' => \Packages\Commands\Migrations\Latest::class, 
    'rollback' => \Packages\Commands\Migrations\Rollback::class,
];