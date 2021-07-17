<?php


namespace Application\Command;


use Application\Command\Traits\MigrationApplication\BuildSyncExpense;
use Packages\Commands\BaseCommand;

class ExpenseMigration extends BaseCommand
{


    use BuildSyncExpense;

    protected $name = 'expense:migration';
    protected $CI;
    protected $description = 'Migration all despesas(expenses)';




    public function __construct($CI)
    {
        $this->CI = $CI;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);
    }

    protected function start()
    {
        $this->CI->load->model(['eloquent/migrate/Movimento', 'eloquent/Staff',
         'eloquent/Supplier',
         'eloquent/Expense',
         'eloquent/ExpenseHead']);

        $items =  \Movimento::with(['staff', 'supplier'])->orderBy('codmovimento', 'desc')->get();


        foreach ($items as $row) {


            // dump($this->buildExpense($row));

            $expense = ($this->buildExpense($row));
            // if( empty($row->rg ))
            // dump($staff);
            \Expense::updateOrCreate([
                'owner_id' => $expense['owner_id'],
                'owner_type' => $expense['owner_type'],
                'amount' => $expense['amount'],
                'date' => $expense['date'],
            ],  $expense);
            

        }
    }
}
