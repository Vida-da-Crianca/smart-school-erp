<div class="table table-responsive">

    <table class="table table-bordered table-hover table-striped">

        <tbody>
               
                 <tr>
                    <td>Itens(+)</td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($orcamento->valorItens, 2, ',', '.'); ?>
                    </td>
                 </tr>
                 <tr>
                    <td>Descontos Sobre Itens(-)</td>
                    <td class="text-right">
                        <span class="small">R$</span> 
                        <?php echo number_format($orcamento->valorDesconto, 2, ',', '.'); ?>
                    </td>
                 </tr>
                 <tr>
                    <td class="bg-info"><b>Total(=)</b></td>
                    <td class="text-right bg-info">
                        <b>
                        <span class="small">R$</span> 
                        <?php echo number_format($orcamento->valorFinal, 2, ',', '.'); ?></b>
                    </td>
                </tr>
            
        </tbody>
        
    </table>

</div>