<?php


namespace Application\Command;

use Application\Command\Traits\MigrationApplication\BuildPaymentMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncLancamentoMigration;
use Application\Command\Traits\MigrationApplication\BuildSyncStudentMigration;
use Packages\Commands\BaseCommand;
use Section;
use Illuminate\Database\Capsule\Manager as DB;


class AppImport extends BaseCommand
{


    use BuildPaymentMigration,
        BuildSyncStudentMigration,
        BuildSyncLancamentoMigration;

    protected $name = 'app:import';
    protected $CI;
    protected $description = 'Run import database';
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
            'eloquent/migrate/Turma_eloquent',
            'eloquent/Section',
            'eloquent/Student_fee_master_eloquent',
            'eloquent/Student_fee_item_eloquent',
            'eloquent/Student_deposite_eloquent',
            'eloquent/Student_session_eloquent',
            'eloquent/Student_eloquent',
            'customfield_model',
            'student_model',
            'user_model',
            'setting_model'
        ]);

        $this->current_session = $this->CI->setting_model->getCurrentSession();
        $this->CI->load->library(['role']);

        // DB::table('chat_messages')->truncate();
        // DB::table('alumni_students')->truncate();

        // DB::table('chat_connections')->truncate();

        // DB::table('chat_users')->truncate();
        // DB::table('students')->delete();

        // resturn;
        // return;
        // \Student_eloquent::delete();
        // return;
        // dump(Aluno_eloquent::all());
        $d = \Turma_eloquent::whereIn('ano', ['2020'])->orderBy('ano', 'desc')->with(
            [
                'matriculas.aluno.guardian',
                'matriculas.aluno.mother',
                'matriculas.aluno.father',
                'matriculas.serie', 'matriculas.lancamentos'
            ]
        )
            ->select('codturma', 'descricao', 'ano')
            ->get();
        try {

            foreach ($d as $row) {

                $section = \Section::where('section', 'like', "%{$row->descricao}%")
                    ->with(['classe'])
                    ->first();

                if (!$section) continue;

                foreach ($row->matriculas as $v) {
                    // $this->CI->db->trans_start($inTest);
                    // DB::beginTransaction();
                    $v->section = $section;
                    if (!$v->aluno || $this->isTest($v->aluno->nome)) continue;
                   
                    if ($v->lancamentos->count() == 0) {
                        log_message('info', sprintf('Student %s : lancamentos %s', $v->aluno->nome, $v->lancamentos->count()));
                        continue;
                    }
                    $item = $this->buildStudent($v);

                    $user_id = ($this->syncStudent($item));
                    if (!$user_id) {
                        $user_id = null;
                        log_message('error', sprintf('Failure created student %s', json_encode($item, JSON_PRETTY_PRINT)));
                        continue;
                    }
                    

                    foreach ($v->lancamentos as $lanc) {
                        $fee = $this->buildFee($lanc, $user_id, $section->classe->first()->id);
                        $fee_id = ($this->syncFeeItems($fee));
                        if ($lanc->datapagamento) {
                            $feePay = $this->buildPayment((object) array_merge($fee, [
                                'id' => $fee_id,
                                'fee_discount' => $lanc->desconto,

                            ]));
                            $this->syncDeposite($feePay);
                        }
                    }

                    // if ($inTest) {
                    //     DB::rollBack();
                    // }
                    // if (!$inTest) {
                    //     DB::commit();
                    // }
                    // $this->CI->db->trans_complete();
                }
            }
        } catch (\Exception $e) {
            // $this->CI->db->trans_rollback();
            // DB::rollBack();

            dump($e->getMessage());
        }



        // $this->CI->db->trans_complete();
    }



    public function isTest($str)
    {
        return preg_match('#teste#', $str);
    }
}
