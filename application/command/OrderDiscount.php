<?php


namespace Application\Command;

use Application\Command\Traits\MigrationApplication\BuildPaymentMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncLancamentoMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncStudentMigration;
use Packages\Commands\BaseCommand;
use Section;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class OrderDiscount extends BaseCommand
{


    use BuildPaymentMigration,
        BuildSyncStudentMigration,
        BuildSyncLancamentoMigration;

    protected $name = 'app:order:discount';
    protected $CI;
    protected $description = 'S';
    protected $current_session;



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
        $inTest  = FALSE;


        $this->CI->load->model([
            'eloquent/migrate/Aluno_eloquent',
            'eloquent/migrate/Lancamento',
            'setting_model',
            'eloquent/Student_fee_item_eloquent',
            'eloquent/Student_deposite_eloquent',
        ]);

        $this->current_session = $this->CI->setting_model->getCurrentSession();
        $this->CI->load->library(['role']);

        // DB::table('chat_messages')->truncate();
        // DB::table('alumni_students')->truncate();

        // DB::table('chat_connections')->truncate();

        // DB::table('chat_users')->truncate();

        // DB::table('students')->delete();
        // DB::table('student_fees_master')->delete();
        // DB::table('student_fee_items')->delete();
        // DB::table('student_fees_deposite')->delete();
        // DB::table('users')->delete();

        // return;

        // DB::beginTransaction();
        // $this->CI->db->trans_start(TRUE);

        // resturn;
        // return;
        // \Student_eloquent::delete();
        // return;
        // dump(Aluno_eloquent::all());

        try {

            $items = \Lancamento::whereYear('tblancamento.datavencimento', '2020')
                ->with(['aluno'])
                ->where('tbboleto.codremessa', '<>', 0)
                ->join('tbboleto', 'tblancamento.codboleto', '=', 'tbboleto.codboleto')
                ->select(
                    'tblancamento.*',
                )
                ->get();
            foreach ($items as $item) {
                $fee = new \stdClass;
                $amount = $item->valor - $item->desconto_previsto;
                $feeItems =  \Student_fee_item_eloquent::where('title', 'like', sprintf('%%Siscob %s', $item->codboleto))
                    ->with(['deposite'])
                    ->get();
                if ($feeItems->count() == 0) continue;



                // if ($item->codboleto != '1976')  continue;


                $feeItems->each(function ($row) use (&$fee, $item) {

                    $cod =  sprintf(' Siscob %s', $item->codboleto);
                    $title = sprintf('%s %s', strip_tags($item->descricao), $cod);
                    if ($row->title == $title)
                        $fee = $row;
                });


                if (!$fee->id) continue;

                $feePay = $this->buildPayment((object) array_merge([
                    'feetype_id' => $fee->feetype_id,
                    'user_id' => $fee->user_id,
                    'due_date' => $fee->due_date
                ], [
                    'id' => $fee->id,
                    'fee_discount' => $item->desconto_previsto,
                    'amount_pay' =>  $amount

                ]));

                // // dump($item->toArray());
                // dump($fee->id);
                // dump($feePay);

                $this->syncDeposite($feePay, $fee->deposite);
            }
        } catch (\Exception $e) {

            // $this->CI->db->trans_rollback();
            // DB::rollBack();

            dump($e->getMessage());
        }



        // $this->CI->db->trans_complete();
    }
}
