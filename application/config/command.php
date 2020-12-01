<?php

//Register your commands


return [

    'invoice' => Application\Command\InvoiceCommand::class, 
    'invoice_cancel' => Application\Command\InvoiceCancelCommand::class,
    'invoice_tribute' => Application\Command\TributeCommand::class,
    'billet_cancel' => Application\Command\CancelBillet::class, 
    'billet_create' => Application\Command\BilletGenerateCommand::class, 
    'billet_paid' => Application\Command\PaidBillet::class, 
    'migrate' => \Packages\Commands\Migrations\Latest::class, 
    'rollback' => \Packages\Commands\Migrations\Rollback::class,
    'schedule_run' => Application\Command\ScheduleCommand::class,
];