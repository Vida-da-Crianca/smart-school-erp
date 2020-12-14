<?php

//Register your commands

use Application\Command\AppImport;
use Application\Command\CleanDirectoryTemp;
use Application\Command\SupplierMigration;

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
    'clean_directory' => CleanDirectoryTemp::class,
    'app_import' => AppImport::class,
    'supplier_migration' => SupplierMigration::class
];