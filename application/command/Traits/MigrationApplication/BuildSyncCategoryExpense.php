<?php


namespace Application\Command\Traits\MigrationApplication;

use Illuminate\Support\Str;

trait  BuildSyncCategoryExpense
{




    public function buildExpense($data)
    {


        return [
            'category_last_id' => $data->codcategoria ,
            'exp_category' => $data->descricao,
            'description' => $data->codigo_contabil ?? $data->codigo_contabil,
        ];
    }


}
