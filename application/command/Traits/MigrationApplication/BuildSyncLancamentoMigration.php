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
            'fee_session_group_id' => $user->fee_session_group_id
        ];
    }


    function syncFeeItems($data)
    {

        $fee = \Student_fee_item_eloquent::updateOrCreate(
            [
                'title'    => $data['title'],
                'feetype_id'      => $data['feetype_id'],
                'due_date'    => $data['due_date'  ],
                'class_id'    => $data['class_id'],
                'student_session_id' => $data['student_session_id'],
                'user_id' => $data['user_id']
            ], 
            $data 
        );
        return $fee->id;
    }
}
