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
            'eloquent/SessionYear',
            'eloquent/Student_classe',
            'eloquent/Student_fee_master_eloquent',
            'eloquent/Student_fee_item_eloquent',
            'eloquent/Fee_group_eloquent',
            'eloquent/Student_deposite_eloquent',
            'eloquent/Student_session_eloquent',
            'eloquent/FeeSessionGroup',
            'eloquent/Student_eloquent',
            'eloquent/User',
            'customfield_model',
            'student_model',
            'user_model',
            'setting_model',
            'customfield_model'
        ]);
        $year = 2015;
        $this->current_session = \SessionYear::where('session', 'like', sprintf('%s%%', $year))->first()->id;




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


        $d = \Turma_eloquent::whereIn('ano', [$year])->orderBy('ano', 'desc')
            ->with(
                [
                    'serie',
                    'matriculas.aluno',
                    'matriculas.aluno.guardian',
                    'matriculas.aluno.mother',
                    'matriculas.aluno.father',
                    'matriculas.aluno.city.uf',
                    'matriculas.aluno.cityBirthDay.uf',
                    'matriculas.lancamentos' => function ($query) use ($year) {
                        return $query->where('situacao', 0)
                            ->with(['boleto' => function ($q) {
                                return $q->where('codremessa', '<>', 0);
                            }])
                            ->whereYear('datavencimento', $year);
                    }
                ]
            )
            ->select('codturma', 'descricao', 'ano', 'codserie')
            ->get();
        try {

            foreach ($d as $row) {

                $section_id = \Section::where('section', 'like', "%{$row->descricao}%")
                    ->first()->id;


                $classeStudent = \Student_classe::where('class', 'like', "%{$row->serie->descricao}%")->first();
                $classe_id  = $classeStudent->id;
                $class = $classeStudent->class;

                $options = (object) array_merge(
                    compact('classe_id'),
                    compact('section_id'),
                    compact('class'),
                );

                if (!$options) continue;



                foreach ($row->matriculas as $v) {

                    if (!$v->aluno || $this->isTest($v->aluno->nome)) continue;

                    // dump(sprintf('%s -  %s /%s', $v->aluno->nome, $row->descricao , $row->serie->descricao));



                    if ($v->lancamentos->count() == 0) {
                        // log_message('info', sprintf('Student %s : lancamentos %s', $v->aluno->nome, $v->lancamentos->count()));
                        continue;
                    }
                    $v->options = $options;
                    $student = $this->buildStudent($v);


                    $user = (object) ($this->syncStudent($student));
                    $v->aluno->id = $user->id;
                    $this->buildCustomFields($v->aluno);





                    if (!$user->id) {
                        $user  = null;
                        log_message('error', sprintf('Failure created student %s', json_encode($student, JSON_PRETTY_PRINT)));
                        continue;
                    }
                    $feeGroup = \Fee_group_eloquent::where('name', $options->class)->first();
                    $feeSessionGroup = \FeeSessionGroup::where('fee_groups_id', $feeGroup->id)
                        ->where('session_id', $this->current_session)->first();
                    foreach ($v->lancamentos->groupBy('codboleto') as $listOfOrders) {

                        $lancFirst = $listOfOrders->first();

                        $amount = $lancFirst->valor - $lancFirst->valorpago;

                        if ($lancFirst->boleto)
                            $amount = $lancFirst->boleto->valor - $lancFirst->boleto->desconto_previsto;

                        foreach ($listOfOrders as $lanc) {

                         

                            $fee = $this->buildFee($lanc, (object)
                            [
                                'user_id' => $user->id,
                                'classe_id' => $options->classe_id,
                                'session_id' => $user->session_id,
                                'fee_session_group_id' => $feeSessionGroup->id,
                            ]);
                            $fee_id = ($this->syncFeeItems($fee));

                            if( ($lanc->valorpago == 0 && $lanc->boleto->valorpago == 0) || (
                                $lanc->valorpago == 0 && !isset($lanc->boleto->valorpago) 
                            ) ) continue;
                            $feePay = $this->buildPayment((object) array_merge($fee, [
                                'id' => $fee_id,
                                'fee_discount' =>  $lanc->boleto->desconto_previsto,
                                'amount_pay' =>  $lanc->valor ?? $lanc->boleto->valorpago

                            ]));

                            $this->syncDepositePivot($feePay, $fee_id);
                        }
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
