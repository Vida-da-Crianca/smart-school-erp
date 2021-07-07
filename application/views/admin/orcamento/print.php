<html>
    <head>
        <title>Orçamento nº <?php echo str_pad($orcamento->idOrcamento,5,'0',STR_PAD_LEFT); ?></title>
        <style type="text/css">
             html{
                width: 100% !important;
               
            }
            body{
                width: 100% !important;
               
            }
            table { width: 100%; }
            table th, table td { width: 25%; }
            
            b{
               
                font-size: 11px;
            }
        </style>
    </head>
    <body>
     
<!--<table>
    <tr>
        <td style="text-align: center; width: 80px;" >
            <img src="<?php echo $escola['logo']; ?>" style="max-width: 90%;">
        </td>
        <td style="text-align: left; vertical-align: middle;" >
            <b><?php echo $escola['nome']; ?></b><br />
            <?php echo $escola['endereco']; ?><br />
            <?php echo $escola['telefone']; ?> | <?php echo $escola['email']; ?><br />
        </td>
    </tr>
</table>-->
            <img  src="<?php echo base_url(); ?>/uploads/print_headerfooter/student_receipt/<?php $this->setting_model->get_receiptheader(); ?>" style="height: 100px;width: 100%;">
                  
       <hr />
       <div style="width: 100%; border: 1px solid #7B8080; background-color: #F7F7F7;">
       <table class="table"> 
            <tr >
                <td style="width: 20%;">
                    <b>Orçamento nº</b><br />
                    <?php echo str_pad($orcamento->idOrcamento,5,'0',STR_PAD_LEFT); ?>
                </td>
                <td style="width: 25%;">
                    <b>Validade</b><br />
                    <?php echo $this->tools->formatarData($orcamento->dataValidade, 'us', 'br'); ?>
                </td>
                <td style="width: 30%;">
                    <b>Emitido por</b><br />
                   <?php echo $escola['usuario']; ?>
                </td>
                <td style="width: 25%;">
                    <b>Emitido em</b><br />
                   <?php echo $this->tools->formatarData($orcamento->dataOrcamento, 'us', 'br'); ?> 
                   <?php echo $orcamento->horaOrcamento; ?>
                </td>
            </tr>
        </table>
       </div>
       <br />
       <div style="width: 100%; border: 1px solid #7B8080; background-color: #F7F7F7;">
        <table class="table"> 
            <tr >
                <td style="width: 40%;">
                    <b>Aluno</b><br />
                    <?php echo $orcamento->alunoNome; ?>
                </td>
                <td style="width: 20%;">
                    <b>Nascimento</b><br />
                     <?php echo $this->tools->formatarData($orcamento->dataNascimento, 'us', 'br'); ?>
                </td>
                <td style="width: 20%;">
                    <b>Turma</b><br />
                    <?php echo $escola['turma']; ?>
                </td>
                <td style="width: 20%;">
                    <b>Período</b><br />
                    <?php echo $escola['periodo']; ?>
                </td>
                
            </tr>
        </table>
       </div>
       <br />
       <div style="width: 100%; border: 1px solid #7B8080; background-color: #F7F7F7;">
        <table class="table"> 
            <tr >
                <td style="width: 50%;">
                    <b>Responsável</b><br />
                    <?php echo $orcamento->responsavelFinanceiroNome; ?>
                </td>
                <td style="width: 30%;">
                    <b>Email</b><br />
                     <?php echo $orcamento->responsavelFinanceiroEmail; ?>
                </td>
                <td style="width: 20%;">
                    <b>Telefone</b><br />
                    <?php echo $orcamento->responsavelFinanceiroTelefone; ?>
                </td>
                
            </tr>
        </table>
       </div>
       
        <br />
        <div style="width: 100%; border: 1px solid #7B8080; background-color: #F7F7F7;">
            
             <table class="table"> 

                   
                        <tr>
                            <th style="width: 10%;">Cód</th>
                            <th style="width: 25%;">Item</th>
                            <th style="width: 10%;">Dia Venc.</th>
                            <th style="width: 10%;">Unitário</th>
                            <th style="width: 10%;">Quant.</th>
                            <th style="width: 10%;">V. Item</th>
                            <th style="width: 10%;">Desconto</th>
                            <th style="width: 15%;">Valor Final</th>
                           
                        </tr>
                    
                        <?php $vf = 0 ; foreach ($itens as $row): if((int)$row->parcelaEscolar == 1):?>
                            <tr>
                                <td style="width: 10%;">
                                    <?php echo $row->idOrcamentoItem; ?>
                                </td>
                                <td style="width: 25%;">
                                    <?php echo $row->descricao; ?>
                                </td>
                                <td style="width: 10%;">
                                    <?php echo str_pad($row->diaVencimento, 2,'0',STR_PAD_LEFT); ?>
                                </td>
                                <td style="width: 10%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->valorUnitario, 2, ',', '.'); ?>
                                </td>
                                <td style="width: 10%;">
                                    <?php echo $row->quantidade; ?>
                                </td>
                                <td style="width: 10%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->valorItem, 2, ',', '.'); ?>
                                </td>
                                <td style="width: 10%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->descontoValor, 2, ',', '.'); ?>
                                </td>
                                <td style="width: 15%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->valorFinal, 2, ',', '.');  $vf += $row->valorFinal; ?>
                                </td>
                               
                            </tr>
                        <?php endif; endforeach; ?>
                   


                </table>
            
        </div>
       <div style="width: 100%; border: 1px solid #7B8080; background-color: #F7F7F7;">
            
             <table class="table"> 

                   
                        <tr>
                            <th style="width: 10%;">Cód</th>
                            <th style="width: 25%;">Item</th>
                            <th style="width: 10%;">Dia Venc.</th>
                            <th style="width: 10%;">Unitário</th>
                            <th style="width: 10%;">Quant.</th>
                            <th style="width: 10%;">V. Item</th>
                            <th style="width: 10%;">Desconto</th>
                            <th style="width: 15%;">Valor Final</th>
                           
                        </tr>
                    
                        <?php $vf = 0 ; foreach ($itens as $row): if((int)$row->parcelaEscolar == 0):?>
                            <tr>
                                <td style="width: 10%;">
                                    <?php echo $row->idOrcamentoItem; ?>
                                </td>
                                <td style="width: 25%;">
                                    <?php echo $row->descricao; ?>
                                </td>
                                <td style="width: 10%;">
                                    <?php echo str_pad($row->diaVencimento, 2,'0',STR_PAD_LEFT); ?>
                                </td>
                                <td style="width: 10%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->valorUnitario, 2, ',', '.'); ?>
                                </td>
                                <td style="width: 10%;">
                                    <?php echo $row->quantidade; ?>
                                </td>
                                <td style="width: 10%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->valorItem, 2, ',', '.'); ?>
                                </td>
                                <td style="width: 10%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->descontoValor, 2, ',', '.'); ?>
                                </td>
                                <td style="width: 15%;">
                                    <span class="small">R$</span> 
                                    <?php echo number_format($row->valorFinal, 2, ',', '.');  $vf += $row->valorFinal; ?>
                                </td>
                               
                            </tr>
                        <?php endif; endforeach; ?>
                   

                        <tr>
                            <td colspan="7" style="width: 85%;"></td>
                            <td style="width: 15%; font-weight: bold; background-color: #000; color: #fff;">
                                
                                    <span class='small'>R$</span> 
                                    <?php echo number_format($vf, 2, ',', '.'); ?>
                                
                            </td>
                        </tr>

                </table>
            
        </div>
        
        <br />
        
         <div style="width: 100%; border: 1px solid #7B8080; background-color: #F7F7F7;">
            
             <table class="table">
                 <tr>
                     <td style="width: 33%;">
                         <b>Observações</b><br />
                         <?php echo $orcamento->observacoes; ?>
                     </td>
                      <td style="width: 33%;">
                          <?php if($orcamento->numeroParcelasEscolares > 0): ?>
                                <b>Parcelamento Parc. Escolar</b>
                                <?php
                                
                                    $numeroParcelas = $orcamento->numeroParcelasEscolares;
                                
                                    $valorPorParcela = $orcamento->valorFinalParcelaEscolar / $numeroParcelas;

                                    echo '<br /><div class="alert text-center" style="font-size:1.2em;">'.$numeroParcelas ." Parcelas de R$ ".number_format($valorPorParcela,2,',','.'). ' cada.</div>'; 
                                
                                ?>
                          <?php endif; ?>
                         
                     </td>
                     <td style="width: 33%;">
                          <?php if($orcamento->numeroParcelas > 0): ?>
                                <b>Parcelamento Outros Itens</b>
                                <?php
                                
                                    $numeroParcelas = $orcamento->numeroParcelas;
                                
                                    $valorPorParcela = $orcamento->valorFinal / $numeroParcelas;

                                    echo '<br /><div class="alert text-center" style="font-size:1.2em;">'.$numeroParcelas ." Parcelas de R$ ".number_format($valorPorParcela,2,',','.'). ' cada.</div>'; 
                                
                                ?>
                          <?php endif; ?>
                         
                     </td>
                 </tr>
             </table>
         </div>
        
    </body>
</html>
