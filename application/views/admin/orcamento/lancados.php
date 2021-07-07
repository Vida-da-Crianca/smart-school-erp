<div class="table table-responsive">

    <table class="table table-bordered table-hover table-striped">

        <thead>
            <tr>
                <th>nº</th>
                <th>Aluno</th>
                <th>Nascimento</th>
                <th>Resp. Financeiro</th>
                <th>Contatos</th>
                <th>Data</th>
                <th class="text-right">Parc. Escolar</th>
                <th class="text-right">Outros Itens</th>
                <th class="text-center">Matrícula</th>
                <th></th>
                
            </tr>
        </thead>
        <tbody>
            <?php $t = $a = $b = 0;foreach ($results as $row): ?>
                <tr>
                    <td>
                        <?php echo $row->idOrcamento; ?>
                    </td>
                    <td>
                        <?php echo $row->alunoNome; ?>
                    </td>
                    <td>
                        <?php echo $row->dataNascimentoBr; ?>
                    </td>
                    <td>
                        <?php echo $row->responsavelFinanceiroNome; ?>
                    </td>
                    <td>
                        <i class='fa fa-whatsapp'></i> <?php echo $row->responsavelFinanceiroTelefone; ?><br />
                        <i class='fa fa-envelope-o'></i> <?php echo $row->responsavelFinanceiroEmail; ?>
                    </td>
                    <td>
                        <?php echo $row->dataOrcamentoBr; ?>
                    </td>
                    <td class="text-right">
                            <span class="small">R$</span> 
                            <?php echo number_format($row->valorFinalParcelaEscolar, 2, ',', '.'); $t += $row->valorFinalParcelaEscolar; $a += $row->valorFinalParcelaEscolar; ?>
                        </td>
                    <td class="text-right">
                            <span class="small">R$</span> 
                            <?php echo number_format($row->valorFinal, 2, ',', '.'); $t += $row->valorFinal;  $b += $row->valorFinal;?>
                        </td>
                    <td class="text-center"> 
                        <?php if($row->geradoMatricula == 1): ?>
                            <i class="fa fa-check text-success"></i>
                        <?php endif; ?>
                        <?php if($row->geradoMatricula == 0): ?>
                            <button type="button" 
                                    data-toggle="tooltip" title="Gerar Matrícula do Aluno"    
                                    class="btn btn-default btn-xs" 
                                    id='btn' onclick="$(this).gerarMatricula('Orçamento nº <?php echo $row->idOrcamento; ?>','<?php echo $row->idOrcamento; ?>');">
                                Gerar <i class="fa fa-plus"></i>
                            </button>
                        <?php endif; ?>    
                    </td>
                    <td class="text-center">
                            <button type="button" 
                                    data-toggle="tooltip" title="Alterar Orçamento"    
                                    class="btn btn-default btn-xs" 
                                    id='btn' onclick="$(this).addUpdateOrcamento('update','Orçamento nº <?php echo $row->idOrcamento; ?>','<?php echo $row->idOrcamento; ?>');">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <a type="button" 
                                target="_blank"
                                data-toggle="tooltip" title="Gerar PDF"    
                                href="<?php echo base_url('admin/orcamento/output/').$row->token; ?>"
                                class="btn btn-info btn-xs" >
                                 <i class="fa fa-print"></i>
                             </a>
                        
                         <button type="button" 
                            class="btn btn-info  btn-xs" 
                            data-toggle="tooltip" title="Enviar Email" 
                            id='btn-enviar<?php echo $uuid; ?>' 
                            onclick="$(this)._enviarOrcamento('<?php echo $row->idOrcamento; ?>','<?php echo $row->responsavelFinanceiroEmail; ?>');">
                        <i class="fa fa-envelope"></i>
                    </button>
                        
                            <?php 
                            
                                $textoWhats = '';
                                $textoWhats .= 'Olá segue o acesso ao orçamento solicitado:%0a';
                                $textoWhats .= '%0a';
                                $textoWhats .= base_url('site/orcamento/').$row->token;
                                $textoWhats .= '%0a';
                                $textoWhats .= '%0aPara mais informações, favor entrar em contato conosco!';
                            
                            ?>
                        
                        
                            <a type="button" 
                                target="_blank"
                                data-toggle="tooltip" title="Enviar no WhatsApp"  
                                href="https://web.whatsapp.com/send?phone=55<?php echo preg_replace('/[^0-9]/', '', $row->responsavelFinanceiroTelefone);?>&text=<?php echo $textoWhats; ?>"
                                class="btn btn-info btn-xs" >
                                <i class="fa fa-whatsapp"></i>
                             </a>
                            <button type="button" 
                                    data-toggle="tooltip" title="Excluir Orçamento"    
                                    class="btn btn-danger btn-xs" 
                                    id='btn' onclick="$(this).deleteOrcamento('<?php echo $row->idOrcamento; ?>');">
                                <i class="fa fa-trash-o"></i>
                            </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
      
            <tr>
                <td colspan="5"></td>
                <td class="bg-info text-right">
                    <b>
                        <span class='small'>R$</span>
                        <?php echo number_format($a, 2, ',', '.'); ?>
                    </b>
                </td>
                <td class="bg-info text-right">
                    <b>
                        <span class='small'>R$</span>
                        <?php echo number_format($b, 2, ',', '.'); ?>
                    </b>
                </td>
            </tr>
        
    </table>

</div>