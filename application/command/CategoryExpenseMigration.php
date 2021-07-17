<?php


namespace Application\Command;

use Application\Command\Traits\MigrationApplication\BuildSyncCategoryExpense;
use Packages\Commands\BaseCommand;

class CategoryExpenseMigration extends BaseCommand
{


    use BuildSyncCategoryExpense;

    protected $name = 'expense-category:migration';
    protected $CI;
    protected $description = 'Migration all categories';




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
        $this->CI->load->model(['eloquent/migrate/Categoria', 'eloquent/ExpenseHead']);

        $items =  \Categoria::all();


        foreach ($items as $row) {


            // dump($this->buildExpense($row));

            $expense = ($this->buildExpense($row));
            // if( empty($row->rg ))
            // dump($staff);
            \ExpenseHead::updateOrCreate([
                'category_last_id' => $expense['category_last_id'],
                'description' => $expense['description'],
                'exp_category' => $expense['exp_category']
            ],  $expense);
            

        }
    }
}
