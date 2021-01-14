<?php


namespace Application\Command\Traits\MigrationApplication;



trait BuildPaymentMigration
{



    function buildPayment($item)
    {

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
                'amount_discount' => $item->fee_discount,
                'amount_fine' => $item->amount_fine,
                'payment_mode' => 'S/N',
                'received_by' => 'Importado via sistema',
                'inv_no' => 1,
            ]])

        ];
    }


    function syncDeposite($data, $hasDeposite = null)
    {
       dump(!$hasDeposite);
        $deposite = !$hasDeposite ?  new \Student_deposite_eloquent : $hasDeposite;
        $deposite->fill($data);

        $deposite->save();
    }
}
