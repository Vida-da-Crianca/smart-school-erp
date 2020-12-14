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
            'eloquent/Student_classe',
            'eloquent/Student_fee_master_eloquent',
            'eloquent/Student_fee_item_eloquent',
            'eloquent/Student_deposite_eloquent',
            'eloquent/Student_session_eloquent',
            'eloquent/Student_eloquent',
            'customfield_model',
            'student_model',
            'user_model',
            'setting_model',
            'customfield_model'
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
        $d = \Turma_eloquent::whereIn('ano', ['2020'])->orderBy('ano', 'desc')
            ->with(
                [
                    'serie',
                    'matriculas.aluno',
                    'matriculas.aluno.guardian',
                    'matriculas.aluno.mother',
                    'matriculas.aluno.father',
                    'matriculas.aluno.city.uf',
                    'matriculas.aluno.cityBirthDay.uf',
                    'matriculas.lancamentos' => function ($query) {
                        return $query->where('situacao', 0)
                            ->whereYear('datavencimento', '2020');
                    }
                ]
            )
            ->select('codturma', 'descricao', 'ano', 'codserie')
            ->get();
        try {

            foreach ($d as $row) {

                $section_id = \Section::where('section', 'like', "%{$row->descricao}%")
                    ->first()->id;
                $classe_id = \Student_classe::where('class', 'like', "%{$row->serie->descricao}%")->first()->id;

                $options = (object) array_merge(
                    compact('classe_id'),
                    compact('section_id')
                );


                if (!$options) continue;

                

                foreach ($row->matriculas as $v) {

                    if (!$v->aluno || $this->isTest($v->aluno->nome)) continue;

                    // dump(sprintf('%s -  %s /%s', $v->aluno->nome, $row->descricao , $row->serie->descricao));
                     
                    if ($v->lancamentos->count() == 0) {
                        // log_message('info', sprintf('Student %s : lancamentos %s', $v->aluno->nome, $v->lancamentos->count()));
                        continue;
                    }
                    // if ($v->aluno->codaluno != 77) continue;

                   
                    // dump($this->);

                    // continue;

                    $v->options = $options;

                    // if( $v->aluno->codaluno != 342 ) continue;
                    $student = $this->buildStudent($v);
                     
                    $user = (object) ($this->syncStudent($student));
                    $v->aluno->id = $user->id;
                    $this->buildCustomFields($v->aluno);
                    
                    

                    
                    if (!$user->id) {
                        $user  = null;
                        log_message('error', sprintf('Failure created student %s', json_encode($student, JSON_PRETTY_PRINT)));
                        continue;
                    }
                    foreach ($v->lancamentos as $lanc) {
                        $fee = $this->buildFee($lanc, (object)
                        [
                            'user_id' => $user->id,
                            'classe_id' => $options->classe_id,
                            'session_id' => $user->session_id
                        ]);
                        $fee_id = ($this->syncFeeItems($fee));

                        if ($lanc->valorpago == 0 || $lanc->datapagamento == null) continue;

                        $feePay = $this->buildPayment((object) array_merge($fee, [
                            'id' => $fee_id,
                            'fee_discount' => $lanc->desconto,
                            'amount_pay' =>  $lanc->valorpago

                        ]));
                        $this->syncDeposite($feePay);
                    }
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
        return strpos(strtolower($str), 'teste') != false;
    }
}
