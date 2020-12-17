<?php


namespace Application\Command\Traits\MigrationApplication;

use Illuminate\Support\Str;

trait  BuildSyncExpense
{




    public function buildExpense($data)
    {   

       
       // $isTeach = $isTeach !=  0 ? $isTeach : (!empty($data->cargo) &&  strpos('professora', Str::slug($data->cargo))  ? 4 : 0); 
        
        $expense_head =  \ExpenseHead::where('category_last_id', $data->codcategoria)->first()->id;
        return [
            'exp_head_id' => $expense_head !=  null ? $expense_head : 1,
            'name' =>$data->staff->nome ??  $data->supplier->nome  ,
            'invoice_no' =>  substr(md5($data->codmovimento), 0, 10),
            'date' => $data->datavencimento,
            'amount' => $data->valor,
            'documents' => '',
            "note" => sprintf('[importado] %s', $data->observacoes),
            'owner_id' =>  $this->getOwnerId($data),
            'owner_type' => $data->staff ? 'F' : 'J',
            'is_active' => 'yes',
            'is_deleted' => 'no',
            'payment_at' => $data->datapagamento,
           
        ];
    }



    public function getOwnerId($data){

        if( $data->staff){
           $staff = \Staff::where('employee_id', only_numeric($data->staff->rg))->first();
           return $staff->id ??  $staff->id;
        }

        if( $data->item_supplier){
            $supplier = \Supplier::where('item_supplier', 'like', "%{$data->supplier->nome}%")->first();
            return $supplier->id ??  $supplier->id;
         }
    }


   
}
