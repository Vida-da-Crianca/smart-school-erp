<?php


namespace Application\Command\Traits\MigrationApplication;



trait BuildPaymentMigration
{



    function buildPayment($item)
    {
        $discount =   $item->amount_pay < $item->amount ? $item->amount_pay - $item->amount : 0;
        $fine =  $item->amount_pay < $item->amount ? $item->amount_pay - $item->amount : 0;
        return [
            'fee_groups_feetype_id' => $item->feetype_id,
            'student_fees_master_id' => $item->user_id,
            'student_fees_id' => $item->id,
            'created_at' => $item->due_date,
            'is_active' => 'yes',
            'amount_detail' => json_encode(['1' => [
                'amount' => $item->amount_pay,
                'date' => $item->due_date,
                'description' => 'Sistema Anterior Collected By: IMPORTADO',
                'amount_discount' =>  $discount,
                'amount_fine' => $fine,
                'payment_mode' => 'S/N',
                'received_by' => 'Importado via sistema',
                'inv_no' => 1,
            ]])

        ];
    }


    function syncDeposite($data, $hasDeposite = null)
    {



        //$deposite = !$hasDeposite ?  \Student_deposite_eloquent::create($data) : $hasDeposite;

    }

    function syncDepositePivot($data, $feeId)
    {


        $deposite = \Student_deposite_eloquent::updateOrCreate(
            [
                'fee_groups_feetype_id'    => $data['fee_groups_feetype_id'],
                'student_fees_master_id'      => $data['student_fees_master_id'],
                'student_fees_id'    => $data['student_fees_id'],
                'created_at'    => $data['created_at'],
                'amount_detail' => $data['amount_detail'],
            ],
            $data
        );
        dump($deposite->id);
        //$deposite = !$hasDeposite ?  \Student_deposite_eloquent::create($data) : $hasDeposite;

    }
}
