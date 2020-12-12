<?php


namespace Application\Command\Traits\MigrationApplication;


trait  BuildSyncLancamentoMigration
{




    public function buildFee($data, $user)
    {

        return [
            'title' => strip_tags($data->descricao),
            'feetype_id' => 39,
            'amount' => $data->valor,
            'due_date' => $data->datavencimento,
            'user_id' => $user->user_id,
            'class_id' => $user->classe_id,
            'student_session_id' => $user->session_id,
        ];
    }


    function syncFeeItems($data)
    {

        $fee = new \Student_fee_item_eloquent;
        $fee->forceFill($data);
        $fee->save();

       

        return $fee->id;
    }
}
