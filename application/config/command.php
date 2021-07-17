<?php

//Register your commands

use Application\Command\AppImport;
use Application\Command\BilletOld;
use Application\Command\CategoryExpenseMigration;
use Application\Command\CleanDirectoryTemp;
use Application\Command\Normalize\DepositePaidBillet;
use Application\Command\ExpenseMigration;
use Application\Command\InvoiceCheckOnBillet;
use Application\Command\MailerTester;
use Application\Command\Normalize\BilletAttachInvoice;
use Application\Command\Normalize\DepositeAllBilletPending;
use Application\Command\OrderDiscount;
use Application\Command\StaffMigration;
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
    'supplier_migration' => SupplierMigration::class,
    'staff_migration' => StaffMigration::class,
    'expense_migration' => ExpenseMigration::class,
    'expense_category_migration' => CategoryExpenseMigration::class,
    'mailer_teste' => MailerTester::class,
    'order_discount' => OrderDiscount::class,
    'invoice_check_billet' => InvoiceCheckOnBillet::class,
    'billet_old' => BilletOld::class,
    'normalilze_deposite_billet' => DepositePaidBillet::class,
    'normalize_deposite_all_billet_pending' => DepositeAllBilletPending::class,
    'normalize_invoice_all_billet' => BilletAttachInvoice::class,
];