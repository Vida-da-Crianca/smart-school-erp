<?php


namespace Application\Command\Traits\MigrationApplication;


trait  BuildSyncLancamentoMigration
{




    public function buildFee($data, $user)
    {
        
        $cod = $data->codboleto > 0 ? sprintf(' Siscob %s',$data->codboleto) : null;
        return [
            'title' =>  sprintf('%s %s',strip_tags($data->descricao), $cod),
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
