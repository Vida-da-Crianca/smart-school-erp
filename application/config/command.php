<?php

//Register your commands


return [

    'invoice' => Application\Command\Invoice::class, 
    'migrate' => \Packages\Commands\Migrations\Latest::class, 
    'rollback' => \Packages\Commands\Migrations\Rollback::class,
];