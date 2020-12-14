<?php


namespace Application\Command;

use Application\Command\Traits\MigrationApplication\BuildPaymentMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncLancamentoMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncStudentMigration;
use Packages\Commands\BaseCommand;
use Section;
use Illuminate\Database\Capsule\Manager as DB;


class SupplierMigration extends BaseCommand
{


    use BuildPaymentMigration,
        BuildSyncStudentMigration,
        BuildSyncLancamentoMigration;

    protected $name = 'supplier:migration';
    protected $CI;
    protected $description = 'Run import database';
   



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
         $this->CI->load->model(['eloquent/migrate/Fornecedor', 'itemsupplier_model']);

          $items =  \Fornecedor::all();
          foreach($items as $row){
            $data = array(
                'phone' => $row->telefone,
                'contact_person_phone' => null,
                'item_supplier' => $row->nome,
                'email' => null,
                'address' => $row->endereco,
                'contact_person_name' => null ,
                'contact_person_email' => null,
                'description' => $row->nome_fantasia,
            );
            

            $this->CI->itemsupplier_model->add($data);

          }
          

        

    }


}