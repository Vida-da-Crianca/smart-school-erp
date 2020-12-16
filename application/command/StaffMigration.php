<?php


namespace Application\Command;

use Application\Command\Traits\MigrationApplication\BuildPaymentMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncLancamentoMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncStaff;
use Application\Command\Traits\MigrationApplication\BuildSyncStudentMigration;
use Packages\Commands\BaseCommand;
use Section;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;


class StaffMigration extends BaseCommand
{


    use BuildSyncStaff;

    protected $name = 'staff:migration';
    protected $CI;
    protected $description = 'Migration all funcionarios';




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
        $this->CI->load->model(['eloquent/migrate/Movimento', 'eloquent/Expense']);

        $items =  \Funcionario::with(['bank', 'city.uf'])->get();


        foreach ($items as $row) {

            $staff = ($this->buildStaff($row));
            // if( empty($row->rg ))
            // dump($staff);
            \Staff::updateOrCreate([
                'employee_id' => $staff['employee_id'],
            ],  $staff);
            

        }
    }
}
