<div class="table table-responsive">

    <table class="table table-bordered table-hover table-striped">

        <thead>
            <tr>
                <th>Cód</th>
                <th>Item</th>
                <th>Dia Venc.</th>
                <th class="text-right">Unitário</th>
                <th class="text-center">Quant.</th>
                <th class="text-right">V. Item</th>
                <th class="text-right">Desconto</th>
                <th class="text-right">Valor Final</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $vf = 0 ; foreach ($results as $row): if((int)$row->parcelaEscolar == 1):?>
                <tr>
                    <td>
                        <?php echo $row->idOrcamentoItem; ?>
                    </td>
                    <td>
                        <?php echo $row->descricao; ?>
                    </td>
                    <td>
                        <?php echo str_pad($row->diaVencimento, 2,'0',STR_PAD_LEFT); ?>
                    </td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->valorUnitario, 2, ',', '.'); ?>
                    </td>
                    <td class="text-center">
                        <?php echo $row->quantidade; ?>
                    </td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->valorItem, 2, ',', '.'); ?>
                    </td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->descontoValor, 2, ',', '.'); ?>
                    </td>
                    <td class="text-right bg-info">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->valorFinal, 2, ',', '.');  $vf += $row->valorFinal; ?>
                    </td>
                    <td class="text-center">
                        <button type="button" 
                                    data-toggle="tooltip" title="Remover Item do Orçamento"    
                                    class="btn btn-xs btn-danger" 
                                    id='btn' onclick="$(this).removerItemOrcamento<?php echo $uuid; ?>('<?php echo $row->idOrcamentoItem; ?>');">
                                <i class="fa fa-trash"></i>
                            </button>
                    </td>
                </tr>
            <?php endif; endforeach; ?>
        </tbody>
        
            <tr>
                <td colspan="7"></td>
                <td class="bg-info text-right">
                    <b>
                        <span class='small'>R$</span> 
                        <?php echo number_format($vf, 2, ',', '.'); ?>
                    </b>
                </td>
            </tr>
        
    </table>

    
    <hr />
    
    
    <table class="table table-bordered table-hover table-striped">

        <thead>
            <tr>
                <th>Cód</th>
                <th>Item</th>
                <th>Dia Venc.</th>
                <th class="text-right">Unitário</th>
                <th class="text-center">Quant.</th>
                <th class="text-right">V. Item</th>
                <th class="text-right">Desconto</th>
                <th class="text-right">Valor Final</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
             <?php $vf = 0 ; foreach ($results as $row): if((int)$row->parcelaEscolar == 0):?>
                <tr>
                    <td>
                        <?php echo $row->idOrcamentoItem; ?>
                    </td>
                    <td>
                        <?php echo $row->descricao; ?>
                    </td>
                    <td>
                        <?php echo str_pad($row->diaVencimento, 2,'0',STR_PAD_LEFT); ?>
                    </td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->valorUnitario, 2, ',', '.'); ?>
                    </td>
                    <td class="text-center">
                        <?php echo $row->quantidade; ?>
                    </td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->valorItem, 2, ',', '.'); ?>
                    </td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->descontoValor, 2, ',', '.'); ?>
                    </td>
                    <td class="text-right bg-info">
                        <span class="small">R$</span> 
                        <?php echo number_format($row->valorFinal, 2, ',', '.');  $vf += $row->valorFinal; ?>
                    </td>
                    <td class="text-center">
                        <button type="button" 
                                    data-toggle="tooltip" title="Remover Item do Orçamento"    
                                    class="btn btn-xs btn-danger" 
                                    id='btn' onclick="$(this).removerItemOrcamento<?php echo $uuid; ?>('<?php echo $row->idOrcamentoItem; ?>');">
                                <i class="fa fa-trash"></i>
                            </button>
                    </td>
                </tr>
            <?php endif; endforeach; ?>
        </tbody>
        
            <tr>
                <td colspan="7"></td>
                <td class="bg-info text-right">
                    <b>
                        <span class='small'>R$</span> 
                        <?php echo number_format($vf, 2, ',', '.'); ?>
                    </b>
                </td>
            </tr>
        
    </table>

    
</div>