<?php $uuid = uniqid(); //vamos criar um hash aleatorio toda vez que essa tela é carregada e vamos utiliza-los nas declaracoes JS, com isso evitamos problemas de cahce do JS ?>

<form id='form-<?= $uuid; ?>' method="POST" onsubmit="return;">

    <input type='hidden' name='codigo' value='<?php echo ($orcamento->idOrcamento); ?>' >

    <input type='hidden' name='action' value='<?php ($action); ?>' >
    <input type='hidden' name='origem' value='<?php echo ($origem); ?>' >
    <input type='hidden' name='_submit' value='yeap' >
    
    <div class = "panel panel-default">
        <div class = "panel-heading">
            <div class="panel-title">Dados do Aluno</div>
        </div>
        <div class = "panel-body">
            <div class = "row">
                <div class = "col-md-4 col-xs-12 col-sm-6">
                    <label>Nome</label><br />
                    <input type="text" 
                           name="alunoNome" 
                           id="alunoNome" 
                           value="<?php echo $orcamento->alunoNome; ?>"
                           placeholder="Nome do aluno(a)"
                           class="form-control"/>
                </div>
                <div class = "col-md-4 col-xs-12 col-sm-6">
                    <label>Sobrenome</label><br />
                    <input type="text" 
                           name="alunoSobrenome" 
                           id="alunoSobrenome" 
                           value="<?php echo $orcamento->alunoSobrenome; ?>"
                           placeholder="Sobrenome do aluno(a)"
                           class="form-control"/>
                </div>
                <div class = "col-md-2 col-xs-12 col-sm-2">
                    <label>Sexo</label><br />
                    <?php echo form_dropdown('genero',['M'=>'Masculino','F'=>'Feminino'], $orcamento->genero, "id='genero' class='form-control'"); ?>
                </div>
                <div class = "col-md-2 col-xs-12 col-sm-4">
                    <label>Nascimento</label><br />
                    <input type="tel" 
                           name="dataNascimento" 
                           id="dataNascimento<?= $uuid; ?>" 
                           value="<?php echo $orcamento->dataNascimento == '' ? '' : $this->tools->formatarData($orcamento->dataNascimento, 'us', 'br'); ?>"
                           placeholder="Data de nascimento"
                           class="form-control"/>
                </div>
            </div>
            <br />
            <div class = "row">
                <div class = "col-md-5 col-xs-12 col-sm-5">
                    <label>Turma</label><br />
                    <?php echo form_dropdown('class_id',[], '', "id='class_id".($uuid)."' class='form-control'"); ?>
                </div>
                <div class = "col-md-4 col-xs-12 col-sm-4">
                    <label>Período</label><br />
                    <?php echo form_dropdown('section_id',[], '', "id='section_id".($uuid)."' class='form-control'"); ?>
                </div>
                <div class = "col-md-3 col-xs-12 col-sm-3">
                            <label>Origem</label><br />
                            <?php echo form_dropdown('source_id',$sources, $orcamento->source_id, "id='source_id' class='form-control'"); ?>

                        </div> 
            </div>
        </div>
    </div>
    <div class = "panel panel-default">
        <div class = "panel-heading">
            <div class="panel-title">Dados dos Pais</div>
        </div>
        <div class = "panel-body">
            <div class = "row">
                 <div class = "col-md-5 col-xs-12 col-sm-8">
                    <label>Nome da Mãe</label><br />
                    <input type="text" 
                           name="maeNome" 
                           id="maeNome<?= $uuid; ?>" 
                           value="<?php echo $orcamento->maeNome; ?>"
                           placeholder="Nome da mãe"
                           class="form-control"/>
                </div>
                <div class = "col-md-3 col-xs-12 col-sm-4">
                    <label>Celular da Mãe</label><br />
                    <input type="tel" 
                           name="maeTelefone" 
                           id="maeTelefone<?= $uuid; ?>" 
                           value="<?php echo $orcamento->maeTelefone; ?>"
                           placeholder="Celular da mãe"
                           class="form-control"/>
                </div>
                <div class = "col-md-4 col-xs-12 col-sm-4">
                    <label>Trabalho/Ocupação da Mãe</label><br />
                    <input type="text" 
                           name="maeOcupacao" 
                           id="maeOcupacao<?=$uuid; ?>" 
                           value="<?php echo $orcamento->maeOcupacao; ?>"
                           placeholder="Ocupação da mãe"
                           class="form-control"/>
                </div>
            </div>
            <br />
            <div class = "row">
                 <div class = "col-md-5 col-xs-12 col-sm-8">
                    <label>Nome do Pai</label><br />
                    <input type="text" 
                           name="paiNome" 
                           id="paiNome<?= $uuid; ?>" 
                           value="<?php echo $orcamento->paiNome; ?>"
                           placeholder="Nome do pai"
                           class="form-control"/>
                </div>
                <div class = "col-md-3 col-xs-12 col-sm-4">
                    <label>Celular do Pai</label><br />
                    <input type="tel" 
                           name="paiTelefone" 
                           id="paiTelefone<?= $uuid; ?>" 
                           value="<?php echo $orcamento->paiTelefone; ?>"
                           placeholder="Celular do pai"
                           class="form-control"/>
                </div>
                <div class = "col-md-4 col-xs-12 col-sm-4">
                    <label>Trabalho/Ocupação do Pai</label><br />
                    <input type="text" 
                           name="paiOcupacao" 
                           id="paiOcupacao<?=$uuid; ?>" 
                           value="<?php echo $orcamento->paiOcupacao; ?>"
                           placeholder="Ocupação do pai"
                           class="form-control"/>
                </div>
            </div>
        </div>
    </div>
    <div class = "panel panel-default">
        <div class = "panel-heading">
            <div class="panel-title">Responsável Financeiro</div>
        </div>
        <div class = "panel-body">
            <div class = "row">
                <div class = "col-md-2">
                    <label>Responsável</label><br />
                    <?php echo form_dropdown('responsavelFinanceiro',['Pai'=>'Pai','Mãe'=>'Mãe','Outro'=>'Outro'], $orcamento->responsavelFinanceiro, "id='responsavelFinanceiro".($uuid)."' class='form-control'"); ?>

                </div> 
                 <div class = "col-md-6 col-xs-12 col-sm-6">
                    <label>Nome do Responsável</label><br />
                    <input type="text" 
                           name="responsavelFinanceiroNome" 
                           id="responsavelFinanceiroNome<?=$uuid; ?>" 
                           value="<?php echo $orcamento->responsavelFinanceiroNome; ?>"
                           placeholder="Nome do responsavel"
                           class="form-control"/>
                </div>
                <div class = "col-md-4 col-xs-12 col-sm-4">
                    <label>CPF do Responsável</label><br />
                    <input type="text" 
                           name="responsavelFinanceiroCPF" 
                           id="responsavelFinanceiroCPF<?=$uuid; ?>" 
                           value="<?php echo $orcamento->responsavelFinanceiroCPF; ?>"
                           placeholder="CPF do Responsável"
                           class="form-control"/>
                </div>
            </div>
            <br />
            <div class = "row">
                <div class = "col-md-3 col-xs-12 col-sm-3">
                    <label>Relação de Parentesco</label><br />
                    <input type="text" 
                           name="responsavelFinanceiroRelacao" 
                           id="responsavelFinanceiroRelacao<?=$uuid; ?>" 
                           value="<?php echo $orcamento->responsavelFinanceiroRelacao; ?>"
                           placeholder="Pai, Mãe, Avó, Tio..."
                           class="form-control"/>
                </div>
                <div class = "col-md-2 col-xs-12 col-sm-2">
                    <label>Celular</label><br />
                    <input type="tel" 
                           name="responsavelFinanceiroTelefone" 
                           id="responsavelFinanceiroTelefone<?=$uuid; ?>" 
                           value="<?php echo $orcamento->responsavelFinanceiroTelefone; ?>"
                           placeholder="Telefone do responsável"
                           class="form-control"/>
                </div>
                <div class = "col-md-4 col-xs-12 col-sm-4">
                    <label>Email</label><br />
                    <input type="email" 
                           name="responsavelFinanceiroEmail" 
                           id="responsavelFinanceiroEmail<?=$uuid; ?>" 
                           value="<?php echo $orcamento->responsavelFinanceiroEmail; ?>"
                           placeholder="Email do responsável"
                           class="form-control"/>
                </div>
                <div class = "col-md-3 col-xs-12 col-sm-3">
                    <label>Ocupação</label><br />
                    <input type="text" 
                           name="responsavelFinanceiroOcupacao" 
                           id="responsavelFinanceiroOcupacao<?=$uuid; ?>" 
                           value="<?php echo $orcamento->responsavelFinanceiroOcupacao; ?>"
                           placeholder="Ocupação do responsável"
                           class="form-control"/>
                </div>
            </div>
            
            <br />
            
             <div class="row">
                <div class="col-md-2">
                    <label>CEP</label>
                    <div class="input-group">
                        <input type="text" name="cep" id="cep<?=$uuid; ?>"
                            value="<?php echo $orcamento->cep; ?>" class="form-control"
                            style="text-transform: capitalize;"
                            placeholder="CEP" />
                        <span class="input-group-addon hand btnBuscaCep" onclick="$(this).pesquisaCep();">
                                <i class="fa fa-search-plus" id="loadingCEP"></i>
                            </span>
                    </div>
                </div>
                                            <div class="col-md-5">
                                                <label>Endereço</label>
                                                <input type="text" name="endereco" id="endereco<?=$uuid; ?>" 
                                                        style="text-transform: capitalize; margin-bottom: 10px;"
                                                       class="form-control"
                                                       disabled="disabled"
                                                       value="<?php echo $orcamento->endereco; ?>"
                                                       placeholder="Rua, Av, Travessa..."  />
                                            </div>
                                             <div class="col-md-2">
                                                <label>nº</label>
                                                <input type="text" name="numero" id="numero<?=$uuid; ?>" 
                                                        style="text-transform: capitalize; margin-bottom: 10px;"
                                                       class="form-control"
                                                       value="<?php echo $orcamento->numero; ?>"
                                                       placeholder="nº"  />
                                            </div>
                                             <div class="col-md-3">
                                                <label>Complemento</label>
                                                <input type="text" name="complemento" id="complemento<?=$uuid; ?>" 
                                                       style="text-transform: capitalize; margin-bottom: 10px;"
                                                       class="form-control"
                                                       value="<?php //echo $orcamento->complemento; ?>"
                                                       placeholder="Complemento"  />
                                            </div>

                                         </div>

                                         <div class="row">
                                              <div class="col-md-4">
                                                <label>Bairro</label>
                                                <input type="text" name="bairro" id="bairro<?=$uuid; ?>" 
                                                       style="text-transform: capitalize; margin-bottom: 10px;"
                                                       class="form-control"
                                                       disabled="disabled"
                                                       value="<?php echo $orcamento->bairro; ?>"
                                                       placeholder="Bairro, Vila..."  />
                                            </div>
                                            <div class="col-md-2">
                                                <label>Estado</label>

                                                <?php echo form_dropdown('uf', $estados,$orcamento->uf,"id='uf".($uuid)."' class='form-control' style='margin-bottom: 10px;' disabled='disabled'"); ?>
                                            </div>  
                                             <div class="col-md-6">
                                                <label>Cidade</label>
                                                <input type="text" name="cidade" id="cidade<?=$uuid; ?>" 
                                                       style="text-transform: capitalize; margin-bottom: 10px;"
                                                       class="form-control"
                                                       disabled="disabled"
                                                       value="<?php echo $orcamento->cidade; ?>"
                                                       placeholder="Cidade"  />    
                                            </div>

                                        </div>
                                     
            
        </div>
    </div>
    
    
    <div class = "panel panel-default">
                <div class = "panel-heading">
                    <div class="panel-title">Itens do Orçamento</div>
                </div>
                <div class = "panel-body">
                    <div class = "row">
                        <div class = "col-md-9">
                             <div class="input-group">
                                  <span class="input-group-addon">
                                      Item:
                                    </span>
                                 <?php echo form_dropdown('item',[], '', "id='item".($uuid)."' class='form-control'"); ?>

                               
                            </div>
                        </div> 
                         <div class = "col-md-3 col-xs-12 col-sm-3">
                             <div class="input-group">
                                  <span class="input-group-addon">
                                      Unitário R$:
                                  </span>
                                 <input type="text" 
                                        id="itemValorUnitario<?= $uuid; ?>" 
                                        value=""
                                        placeholder=""
                                        disabled="disabled"
                                        class="form-control"/>
                             </div>
                        </div>
                    </div>
                    <br />
                    <div class = "row">
                       
                        <div class = "col-md-3 col-xs-12 col-sm-3">
                             <div class="input-group">
                                  <span class="input-group-addon">
                                      Quant.:
                                  </span>
                                 <input type="number" 
                                        id="itemQuantidade<?= $uuid; ?>" 
                                        value="1"
                                        placeholder=""
                                        min="1"
                                        style="
                                                text-align: center;
                                                font-weight: bold;
                                                font-size: 1.2em;
                                        "
                                        class="form-control"/>
                             </div>
                        </div>
                        <div class = "col-md-4 col-xs-12 col-sm-4">
                             <div class="input-group">
                                  <span class="input-group-addon">
                                      Desc:
                                  </span>
                                 <input type="text" 
                                        id="itemDesconto<?= $uuid; ?>" 
                                        value="0,00"
                                        placeholder=""
                                        
                                        class="form-control"/>
                                  <span class="input-group-addon">
                                      <input type="radio" checked="checked" name="itemDescontoTipo" value="1"> %
                                      <input type="radio"  name="itemDescontoTipo" value="2"> R$
                                  </span>
                             </div>
                        </div>
                         <div class = "col-md-3 col-xs-12 col-sm-3">
                             <div class="input-group">
                                  <span class="input-group-addon">
                                      Total R$:
                                  </span>
                                 <input type="text" 
                                        id="itemValorTotal<?= $uuid; ?>" 
                                        value="0,00"
                                        placeholder=""
                                        disabled="disabled"
                                        style="
                                                text-align: center;
                                                font-weight: bold;
                                                background-color: #FFFDC1;
                                                font-size: 1.2em;
                                        "
                                        class="form-control"/>
                             </div>
                         </div>
                        <div class = "col-md-2 col-xs-12 col-sm-2">
                            <button type="button"   
                                    class="btn btn-primary btn-sm btn-block" 
                                    id='btn-lancar-item<?= $uuid; ?>' 
                                    onclick="$(this).lancarItem<?= $uuid; ?>();">
                                Lançar <i class="fa fa-arrow-down"></i>
                            </button>
                        </div>
                                 
                       
                    </div>
                    <br />
                    <div class = "row">
                        <div class = "col-md-4 col-xs-12 col-sm-4">
                             <div class="input-group">
                                  <span class="input-group-addon">
                                      Dia de Vencimento:
                                  </span>
                                    <input type="number" 
                                        id="diaVencimento<?= $uuid; ?>" 
                                        value="1"
                                        placeholder=""
                                        min="1"
                                        max='31'
                                        class="form-control"/>
                             </div>
                        </div> 
                    </div>
                    
                    <hr />
                    <div id="output-itens<?= $uuid; ?>"></div>
                    
                </div>
            </div>
    
       
    <div class = "row">
         <div class = "col-md-4 col-xs-12 col-sm-4">
             <div class = "panel panel-default">
                <div class = "panel-heading">
                    <div class="panel-title">Outras Informações</div>
                </div>
                <div class = "panel-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <label>Observações</label><br />
                            <textarea name="observacoes" class="form-control" rows="3" placeholder="Informações complementares..."><?php echo $orcamento->observacoes; ?></textarea>
                        </div> 
                    </div>
                   
                    
                </div>
             </div>
         </div>
         
          <div class = "col-md-4 col-xs-12 col-sm-4">
             <div class = "panel panel-default">
                <div class = "panel-heading">
                    <div class="panel-title">Parcelamento Parc. Escolar</div>
                </div>
                <div class = "panel-body">
                    <div class = "row">
                        <div class = "col-md-12 col-xs-12 col-sm-12">
                            <label>Quantidede de Parcelas</label><br />
                            <input type="number" 
                                   name="numeroParcelasEscolar" 
                                   id="numeroParcelasEscolar<?= $uuid; ?>" 
                                   value="<?php echo (int) $orcamento->numeroParcelasEscolares; ?>"
                                   placeholder=""
                                   min="0"
                                   class="form-control"/>
                        </div> 
                    </div>
                    <div id="output-parcelas-escolar<?= $uuid; ?>"></div>
                </div>
             </div>
         </div>
        
         <div class = "col-md-4 col-xs-12 col-sm-4">
             <div class = "panel panel-default">
                <div class = "panel-heading">
                    <div class="panel-title">Parcelamento Outros Itens</div>
                </div>
                <div class = "panel-body">
                    <div class = "row">
                        <div class = "col-md-12 col-xs-12 col-sm-12">
                            <label>Quantidede de Parcelas</label><br />
                            <input type="number" 
                                   name="numeroParcelas" 
                                   id="numeroParcelas<?= $uuid; ?>" 
                                   value="<?php echo $orcamento->numeroParcelas; ?>"
                                   placeholder=""
                                   min="1"
                                   class="form-control"/>
                        </div> 
                    </div>
                    <div id="output-parcelas<?= $uuid; ?>"></div>
                </div>
             </div>
         </div>
           
    </div>
        
    
    
    
    
    
</form>
<br />
<hr />

<div class = "row">
    <div class = "col-md-12 col-xs-12 col-sm-12 text-center">

        <button type="button" 
                class="btn btn-default" 
                id='btn' onclick="$('.modal').last().modal('hide');">
            Cancelar
        </button>
        <?php if($orcamento->status == 1): ?>
            <button type="button" 
                    class="btn btn-info" 
                    id='btn-enviar<?php echo $uuid; ?>' 
                    onclick="$(this)._enviarOrcamento('<?php echo $orcamento->idOrcamento; ?>','<?php echo $orcamento->responsavelFinanceiroEmail; ?>');">
                Enviar Email <i class="fa fa-envelope"></i>
            </button>
        <?php 
                            
                                $textoWhats = '';
                                $textoWhats .= 'Olá segue o acesso ao orçamento solicitado:%0a';
                                $textoWhats .= '%0a';
                                $textoWhats .= base_url('site/orcamento/').$orcamento->token;
                                $textoWhats .= '%0a';
                                $textoWhats .= '%0aPara mais informações, favor entrar em contato conosco!';
                            
                            ?>
            <a type="button" 
               target="_blank"
               href="https://web.whatsapp.com/send?phone=55<?php echo preg_replace('/[^0-9]/', '', $orcamento->responsavelFinanceiroTelefone);?>&text=<?php echo $textoWhats; ?>"
               class="btn btn-info" >
                Enviar WhatsApp <i class="fa fa-whatsapp"></i>
            </a>
            <a type="button" 
               target="_blank"
               href="<?php echo base_url('admin/orcamento/output/').$orcamento->token; ?>"
               class="btn btn-info" >
                PDF <i class="fa fa-print"></i>
            </a>
        <?php endif; ?>
        <button type="button" 
                class="btn btn-success" 
                id='btn-gravar<?php echo $uuid; ?>' onclick="$(this)._addOrcamento<?php echo $uuid; ?>();">
            Gravar Orçamento <i class="fa fa-save"></i>
        </button>
    </div> 
</div>

<script type='text/javascript'>
$(document).ready(function(){

    /* MASCARAS -----------------------------------------------------*/ 
    var date_format = 'dd/mm/yyyy';
    $('#dataNascimento<?= $uuid; ?>').mask('99/99/9999');    
    $('#maeTelefone<?= $uuid; ?>').mask('(99) 9 9999-9999');
    $('#paiTelefone<?= $uuid; ?>').mask('(99) 9 9999-9999');    
    $('#responsavelFinanceiroTelefone<?= $uuid; ?>').mask('(99) 9 9999-9999');
    $('#responsavelFinanceiroCPF<?= $uuid; ?>').mask('999.999.999-99');    
    $('#cep<?= $uuid; ?>').mask('99999-999');
    $(this)._maskMoney('#itemValorUnitario<?= $uuid; ?>');
    $(this)._maskMoney('#itemDesconto<?= $uuid; ?>');
    $(this)._maskMoney('#itemValorTotal<?= $uuid; ?>');
    /* MASCARAS -----------------------------------------------------*/
    
    /* REPONSAVEL -----------------------------------------------------*/ 
    $('#responsavelFinanceiro<?= $uuid; ?>').change(function(){
        
        $('#responsavelFinanceiroRelacao<?=$uuid; ?>').val($(this).val());
        
        if($(this).val() === 'Mãe'){
            $('#responsavelFinanceiroNome<?=$uuid; ?>').val($('#maeNome<?=$uuid; ?>').val());
            $('#responsavelFinanceiroTelefone<?=$uuid; ?>').val($('#maeTelefone<?=$uuid; ?>').val());
            $('#responsavelFinanceiroOcupacao<?=$uuid; ?>').val($('#maeOcupacao<?=$uuid; ?>').val());
        }else{
            if($(this).val() === 'Pai'){
                $('#responsavelFinanceiroNome<?=$uuid; ?>').val($('#paiNome<?=$uuid; ?>').val());
                $('#responsavelFinanceiroTelefone<?=$uuid; ?>').val($('#paiTelefone<?=$uuid; ?>').val());
                $('#responsavelFinanceiroOcupacao<?=$uuid; ?>').val($('#paiOcupacao<?=$uuid; ?>').val());
            }else{
                $('#responsavelFinanceiroNome<?=$uuid; ?>').val('');
                $('#responsavelFinanceiroTelefone<?=$uuid; ?>').val('');
                $('#responsavelFinanceiroOcupacao<?=$uuid; ?>').val('');
                $('#responsavelFinanceiroRelacao<?=$uuid; ?>').val('');
            }
        }
        
        
    });
    $('#responsavelFinanceiro<?= $uuid; ?>').trigger('change');
    /* REPONSAVEL -----------------------------------------------------*/ 
    
    
    /* BUSCA CEP -----------------------------------------------------*/
    $.fn.limpa_formulário_cep = function() {
                // Limpa valores do formulário de cep.
                $("#endereco<?= $uuid; ?>").val("");
                $("#numero<?= $uuid; ?>").val("");
                $("#bairro<?= $uuid; ?>").val("");
                $("#cidade<?= $uuid; ?>").val("");
                $("#uf<?= $uuid; ?>").val("SP");
    };
    
    $.fn.pesquisaCep = function(){
		
                //Nova variável "cep" somente com dígitos.
                var cep = $("#cep<?= $uuid; ?>").val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep !== "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
			$('#loadingCEP').removeClass("fa-search-plus").addClass("fa-circle-o-notch fa-spin");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
				$("#endereco<?= $uuid; ?>").val(dados.logradouro);
				$("#numero<?= $uuid; ?>").val("");
				$("#numero<?= $uuid; ?>").focus();
				$("#bairro<?= $uuid; ?>").val(dados.bairro);
				$("#cidade<?= $uuid; ?>").val(dados.localidade);
				$("#uf<?= $uuid; ?>").val(dados.uf);


                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                $(this).limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                            
                            $('#loadingCEP').addClass("fa-search-plus").removeClass("fa-circle-o-notch fa-spin");

                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        $(this).limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                        
                    }
                } //end if.
                else {
                   
                    //cep sem valor, limpa formulário.
                   $(this).limpa_formulário_cep(); 
                   alert("CEP inválido/nulo.");
                   $("#cep<?= $uuid; ?>").focus();
                }
        };
     /* BUSCA CEP -----------------------------------------------------*/    
       
    /* ITENS DO ORÇAMENTO -----------------------------------------------------*/ 
    /*Carrega no combobox, os itens que podem ser lancados para a turma selecionada*/
    $.fn.comboBoxItemLancarPorTurma<?= $uuid; ?> = function(){
            $(this).comboBox({
                url : '<?php echo base_url(); ?>admin/orcamento/getListaItensParaOrcamentoPorTurma',
                data: { class_id : $('#class_id<?= $uuid; ?>').val() },
                combobox : '#item<?= $uuid; ?>',
                callback: function(){
                    $(this).calcularValorItemLancar<?= $uuid; ?>();
                }
            });   
    };
    
    $.fn.zerarCamposLancamentoItem<?= $uuid; ?> = function(){
        $('#itemValorUnitario<?= $uuid; ?>').val('0,00');
        $('#itemQuantidade<?= $uuid; ?>').val('1');
        $('#itemDesconto<?= $uuid; ?>').val('0,00');
        $('#itemValorTotal<?= $uuid; ?>').val('0,00');
    };
    $(this).zerarCamposLancamentoItem<?= $uuid; ?>();
    
    //Carregar os valores do item selecionado e calcula o total do item a ser lancado
    $.fn.calcularValorItemLancar<?= $uuid; ?> = function(){
        try{
            
            var dadosItem = JSON.parse($('#item<?= $uuid; ?>').val());
            
            //variaveis do calculo
            var valorUnitario = parseFloat(dadosItem.valor);
            var quantidade = 0;
            var desconto = 0;
            var descontoTipo = parseInt($('input[name="itemDescontoTipo"]:checked').val());
            var valorDesconto = 0;
            var valorItem = 0;
            var valorTotal = 0;
            
            //carreando valores que sao digitados pelo usuario
            quantidade = parseInt($('#itemQuantidade<?= $uuid; ?>').val());
            if(quantidade<=0){quantidade = 1;$('#itemQuantidade<?= $uuid; ?>').val('1');}
            desconto = parseFloat( $('#itemDesconto<?= $uuid; ?>').val().replace('.','').replace(',','.') );
            
            //valores calculados
            valorItem = (valorUnitario * quantidade );
            
            if(desconto>0){
                if(descontoTipo === 1){//desconto po %
                    valorDesconto = parseFloat( ((valorUnitario * desconto) / 100)  );
                }else{
                    valorDesconto = desconto;
                }
            }
            valorTotal = valorItem - valorDesconto;
            
            console.log('Desc, ', valorDesconto);
            console.log('Total, ',valorTotal);
            
            //Setando valores nos campos da tela
            $('#itemValorUnitario<?= $uuid; ?>').val($(this).formatMoney(valorUnitario));
            $('#itemValorTotal<?= $uuid; ?>').val($(this).formatMoney(valorTotal));
            
        }catch(e){
            console.log(e);
            //alert('Erro ao carregar dados do item selecionado!');
            $(this).zerarCamposLancamentoItem<?= $uuid; ?>();
        }
    };
    $('#item<?= $uuid; ?>').change(function(){
        $(this).calcularValorItemLancar<?= $uuid; ?>();
    });
    $('#itemQuantidade<?= $uuid; ?>').change(function(){
        $(this).calcularValorItemLancar<?= $uuid; ?>();
    });
    $('#itemDesconto<?= $uuid; ?>').keyup(function(){
        setTimeout(function(){
            $(this).calcularValorItemLancar<?= $uuid; ?>();
        },100);
    });
    $('input[name="itemDescontoTipo"]').click(function(){
        $(this).calcularValorItemLancar<?= $uuid; ?>();
    });
    
    
    $.fn.lancarItem<?= $uuid; ?> = function(){
        
        
       
        $(this)._submit({
            url : '<?php echo base_url('admin/orcamento/item/add'); ?>',
            data: {
                _submit: 'yeap',
                item : $('#item<?= $uuid; ?>').val(),
                quantidade : $('#itemQuantidade<?= $uuid; ?>').val(),
                desconto : $('#itemDesconto<?= $uuid; ?>').val(),
                descontoTipo : $('#input[name="itemDescontoTipo"]:checked').val(),
                idOrcamento : '<?php echo $orcamento->idOrcamento; ?>',
                diaVencimento : $('#diaVencimento<?= $uuid; ?>').val()
            },
            button: $('#btn-lancar-item<?= $uuid; ?>'),
            callback: function(resp){
                
                
                

                if(!resp.status)
                {
                    //$(this)._notify({ title: 'Atenção!' , msg: resp.msg, type: 'd' });
                    alert(resp.msg);
                }
                else
                {
                    //$('.modal').last().modal('toggle'); 
                    $(this).buscarItensLancados<?= $uuid; ?>();
                    $(this).totaisOrcamento<?= $uuid; ?>();
                    $(this).zerarCamposLancamentoItem<?= $uuid; ?>();
                }

            }

        });  
    };
    
    $.fn.buscarItensLancados<?= $uuid; ?> = function(){
        $(this).search({
            output : '#output-itens<?= $uuid; ?>',
            data: {idOrcamento : '<?php echo $orcamento->idOrcamento; ?>', uuid : '<?php echo $uuid; ?>'}, 
            url: '<?php echo base_url('admin/orcamento/item/lancados'); ?>'
        });
    };
    $(this).buscarItensLancados<?= $uuid; ?>();
    
    $.fn.removerItemOrcamento<?= $uuid; ?> = function(id){
       $(this)._submit({
                             url : '<?php echo base_url('admin/orcamento/item/delete'); ?>',
                             data: { id : id, _submit : 'yeap'  },
                             button: $('#btn-lancar-item<?= $uuid; ?>'),
                             callback: function(resp){

                                 if(!resp.status)
                                 {
                                      alert(resp.msg);
                                 }
                                 else
                                 {
                                      $(this).buscarItensLancados<?= $uuid; ?>(); 
                                      $(this).totaisOrcamento<?= $uuid; ?>();
                                 }

                             }

                         });  
    };    
    /* ITENS DO ORÇAMENTO -----------------------------------------------------*/ 
    
    /*TOTAIS DO ORÇAMENTO -----------------------------------------------------*/
    $.fn.totaisOrcamento<?= $uuid; ?> = function(){
        $(this).search({
            output : '#output-totais<?= $uuid; ?>',
            data: {idOrcamento : '<?php echo $orcamento->idOrcamento; ?>'}, 
            url: '<?php echo base_url('admin/orcamento/getTotais'); ?>'
        });
        $('#numeroParcelas<?= $uuid; ?>').trigger('change');
        $('#numeroParcelasEscolar<?= $uuid; ?>').trigger('change');
    };
    $(this).totaisOrcamento<?= $uuid; ?>();
    /*TOTAIS DO ORÇAMENTO -----------------------------------------------------*/
    
    
    /*TURMA E PERIODO ---------------------------------------------------------*/
    /*Carrega o combobox de periodos*/
    $.fn.comboBoxPeriodo<?= $uuid; ?> = function(){
        $(this).comboBox({
            url : '<?php echo base_url(); ?>admin/orcamento/getListaPeriodosPorTurma',
            data: { class_id : $('#class_id<?= $uuid; ?>').val() },
            combobox : '#section_id<?= $uuid; ?>',
            selected: '<?php echo $orcamento->section_id; ?>',
            callback: {function(){} }
        }); 
       
    };
    
    /*Verificar a turma com base na data de nascimento*/
    $.fn.carregarComboBoxTurmasDisponiveis<?= $uuid; ?> = function(dataNascimento){
        $(this).comboBox({
            url : '<?php echo base_url(); ?>admin/orcamento/getListaTurmasPorDataNascimento',
            data: { dataNascimento : dataNascimento },
            combobox : '#class_id<?= $uuid; ?>',
            selected: '<?php echo $orcamento->class_id; ?>',
            callback: function(){ 
                $(this).comboBoxPeriodo<?= $uuid; ?>(); 
                $(this).comboBoxItemLancarPorTurma<?= $uuid; ?>();
            } 
        });     
    };
    $(this).carregarComboBoxTurmasDisponiveis<?= $uuid; ?>('<?php echo $this->tools->formatarData($orcamento->dataNascimento, 'us', 'br'); ?>');
    
    //$('#dataNascimento<?= $uuid; ?>').datepicker().on('changeDate', function (ev) {
   //    $(this).carregarComboBoxTurmasDisponiveis<?= $uuid; ?>($(this).val());
   // });
    //$('#dataNascimento<?= $uuid; ?>').keyup(function(){
    //   $(this).carregarComboBoxTurmasDisponiveis<?= $uuid; ?>($(this).val());
    //});
    
        let typingTimer;                //timer identifier
        let doneTypingInterval = 1000;  //time in ms (5 seconds)
        let myInput = document.getElementById('dataNascimento<?= $uuid; ?>');

        //on keyup, start the countdown
        $('#dataNascimento<?= $uuid; ?>').keyup(function(){
            clearTimeout(typingTimer);
            if ($('#dataNascimento<?= $uuid; ?>').val()) {
                typingTimer = setTimeout(function(){
                    $(this).carregarComboBoxTurmasDisponiveis<?= $uuid; ?>($('#dataNascimento<?= $uuid; ?>').val());
                }, doneTypingInterval);
            }
        });

    
    /*TURMA E PERIODO ---------------------------------------------------------*/
    
    
    $.fn._addOrcamento<?= $uuid; ?> = function(){
        
        $("#endereco<?= $uuid; ?>").prop("disabled",false);
        $("#bairro<?= $uuid; ?>").prop("disabled",false);
        $("#cidade<?= $uuid; ?>").prop("disabled",false);
        $("#uf<?= $uuid; ?>").prop("disabled",false);
        
        $(this)._submit({
            url : '<?php echo base_url('admin/orcamento/add'); ?>',
            data: $('#form-<?= $uuid; ?>').serialize(),
            button: $('#btn-gravar<?php echo $uuid; ?>'),
            callback: function(resp){
                
                $("#endereco<?= $uuid; ?>").prop("disabled","disabled");
                $("#bairro<?= $uuid; ?>").prop("disabled","disabled");
                $("#cidade<?= $uuid; ?>").prop("disabled","disabled");
                $("#uf<?= $uuid; ?>").prop("disabled","disabled");

                if(!resp.status)
                {
                    alert(resp.msg);
                }
                else
                {
                    $('.modal').last().modal('hide'); 
                    $(this).buscarOrcamentos();
                    
                    <?php if($action == 'add'): ?>
                            BootstrapDialog.confirm({
                                title: 'Enviar Orçamento',
                                message: '<h3 class="text-center">Gostaria de enviar o orçamento no WhatsApp?</h3>',
                                type: BootstrapDialog.TYPE_DEFAULT, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                                closable: true, // <-- Default value is false
                                draggable: true, // <-- Default value is false
                                btnCancelLabel: 'Não', // <-- Default value is 'Cancel',
                                btnOKLabel: 'Sim', // <-- Default value is 'OK',
                                btnOKClass: 'btn-success', // <-- If you didn't specify it, dialog type will be used,
                                size: BootstrapDialog.SIZE_SMALL,
                                 onshown: function(dialogRef){
	               
                       $('.modal-dialog').last().css('z-index',1301);
                },
                                callback: function(result) {


                                    if(result) {
                                          window.open('https://web.whatsapp.com/send?phone='+(resp.msg.numero)+'&text='+resp.msg.textoWhats);  
                                    }
                                }
                             });
                    <?php endif; ?>
                }

            }

        });  
    }; 
    
    $('#numeroParcelas<?= $uuid; ?>').change(function(){
        $(this).search({
            output : '#output-parcelas<?= $uuid; ?>',
            data: {numeroParcelas : $('#numeroParcelas<?= $uuid; ?>').val(), idOrcamento : '<?php echo $orcamento->idOrcamento; ?>' }, 
            url: '<?php echo base_url('admin/orcamento/getParcelas'); ?>'
        });
    });
    $('#numeroParcelas<?= $uuid; ?>').trigger('change');
    
    $('#numeroParcelasEscolar<?= $uuid; ?>').change(function(){
        $(this).search({
            output : '#output-parcelas-escolar<?= $uuid; ?>',
            data: {numeroParcelas : $('#numeroParcelasEscolar<?= $uuid; ?>').val(), idOrcamento : '<?php echo $orcamento->idOrcamento; ?>' }, 
            url: '<?php echo base_url('admin/orcamento/getParcelasEscolar'); ?>'
        });
    });
    $('#numeroParcelasEscolar<?= $uuid; ?>').trigger('change');
    
    
    $('#maeNome<?= $uuid; ?>').keyup(function(){
        if($(this).val() !== ''){
            $('#maeTelefone<?= $uuid; ?>').prop('disabled',false);
            $('#maeOcupacao<?= $uuid; ?>').prop('disabled',false);
        }else{
            $('#maeTelefone<?= $uuid; ?>').prop('disabled','disabled');
            $('#maeOcupacao<?= $uuid; ?>').prop('disabled','disabled');
        }
    });
    $('#maeNome<?= $uuid; ?>').trigger('keyup');
    
    $('#paiNome<?= $uuid; ?>').keyup(function(){
        if($(this).val() !== ''){
            $('#paiTelefone<?= $uuid; ?>').prop('disabled',false);
            $('#paiOcupacao<?= $uuid; ?>').prop('disabled',false);
        }else{
            $('#paiTelefone<?= $uuid; ?>').prop('disabled','disabled');
            $('#paiOcupacao<?= $uuid; ?>').prop('disabled','disabled');
        }
    });
    $('#paiNome<?= $uuid; ?>').trigger('keyup');
    

});
</script>