<style>
    .req{
        color:red;
    }
    h4 {
	width: 100%;

	padding-bottom: 10px;
	margin-top: 10px;
	padding-top: 10px;

   }
   .form-control{
       color: #BD0745 !important;
       text-transform: uppercase !important;
   }
</style>
<?php if($this->session->flashdata('msg')): ?>
<?php  echo $this->session->flashdata('msg'); ?>
<?php endif; ?>


<form class="spaceb60 onlineform" onsubmit="return;"
    action=""
    id="employeeform"
    name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="save" value="1" />
    <input type='hidden' name='_submit' value='yeap' />
    <?=$this->customlib->getCSRF()?>
    <h2>Trabalhe Conosco</h2>

    <?php if(isset($erros) && is_array($erros) && count($erros)>0): ?>
    <?php foreach($erros as $erro ): ?>
    <div class="alert alert-danger">
        <?php echo $erro; ?>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>

    <h4 class="h4">Seus Dados</h4>

    <div class="row">
        <div class="col-md-4 col-xs-12 col-sm-6">
            <label>Nome Completo</label><small class="req"> *</small><br />
            <input type="text"
                name="firstname"
                id="firstname"
                value="<?php echo set_value('firstname'); ?>"
                placeholder="Nome completo"
                class="form-control" />
            <span class="text-danger">
                <?php echo form_error('firstname'); ?>
            </span>
        </div>
        <div class="col-md-2 col-xs-12 col-sm-6">
            <label>Telefone</label><small class="req"> *</small><br />
            <input type="text"
                name="telefone"
                id="telefone"
                value=""
                placeholder="Telefone celular"
                class="form-control" />
        </div>
        <div class="col-md-2 col-xs-12 col-sm-3">
            <label for="exampleInputEmail1">Cargo</label><small class="req"> *</small><br />
            <select id="designation" name="designation" placeholder="" type="text" class="form-control" required>
                <option value="select">Selecione</option>
                <?php foreach($designationList as $value): ?>
                      <option value="<?=$value['id']?>"><?=$value['designation']?></option>
                 <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 col-xs-12 col-sm-3">
            <label>Sexo</label><small class="req"> *</small><br />
            <?php echo form_dropdown('gender',$genderList, set_value('gender'), "id='gender' class='form-control'"); ?>

        </div>
        <div class="col-md-2 col-xs-12 col-sm-3">
            <label>Data de Nascimento</label><small class="req"> *</small><br />
            <input type="tel"
                name="dob"
                id="dob"
                value="<?php echo set_value('dob'); ?>"
                placeholder="Data de Nascimento do Aluno(a)"
                class="form-control" />
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-3">
            <label>Experiência Profissional</label><small class="req"> *</small><br />
            <textarea id="work_exp" name="work_exp" placeholder="" class="form-control" cols="35" rows="10" required></textarea>
            <span class="text-danger"></span>
        </div>
        <div class="col-md-3 col-xs-12 col-sm-3">
            <label>Cursos</label><small class="req"> *</small><br />
            <textarea id="cursos" name="cursos" placeholder="" class="form-control" cols="35" rows="10" required></textarea>
            <span class="text-danger"></span>
        </div> 
        <div class="col-md-3 col-xs-12 col-sm-3">
            <label>Outros</label><small class="req"> *</small><br />
            <textarea id="outros" name="outros" placeholder="" class="form-control" cols="35" rows="10" required></textarea>
            <span class="text-danger"></span>
        </div> 
    
    
    </div>
    </br>
    <h4>Endereço</h4>
    <div class="row">
        <div class="col-md-4 col-xs-12 col-sm-2">
            <label>CEP</label><small class="req"> *</small><br />
            <input type="tel"
                name="guardian_postal_code"
                id="guardian_postal_code"
                value=""
                placeholder=""
                class="form-control" onblur="pesquisaCep();" />
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <label>Endereço</label><small class="req"> *</small><br />
            <input type="text"
                name="guardian_address"
                id="guardian_address"
                value=""
                placeholder=""
                disabled="disabled"
                class="form-control" />
        </div>
        <div class="col-md-2 col-xs-12 col-sm-2">
            <label>nº</label><small class="req"> *</small><br />
            <input type="text"
                name="guardian_address_number"
                id="guardian_address_number"
                value=""
                placeholder=""
                class="form-control" required/>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-4 col-xs-12 col-sm-4">
            <label>Bairro</label><small class="req"> *</small><br />
            <input type="text"
                name="guardian_district"
                id="guardian_district"
                value=""
                placeholder=""
                disabled="disabled"
                class="form-control" />
        </div>
        <div class="col-md-4 col-xs-12 col-sm-4">
            <label>Cidade</label><small class="req"> *</small><br />
            <input type="text"
                name="guardian_city"
                id="guardian_city"
                value="<?php echo set_value('guardian_city'); ?>"
                placeholder=""
                disabled="disabled"
                class="form-control" />
        </div>
        <div class="col-md-2 col-xs-12 col-sm-2">
            <label>UF</label><small class="req"> *</small><br />
            <input type="text"
                name="guardian_state"
                id="guardian_state"
                value="<?php echo set_value('guardian_state'); ?>"
                placeholder=""
                disabled="disabled"
                class="form-control" />
        </div>

        

    </div>
    <br />
    <h4>Outras Informações</h4>
    <div class="row">
        <?php echo  display_custom_fields('staff', false, null, $escolaridade_id); ?>
    </div>
    <br />
    <h4>Redes Sociais</h4>
    <div class="row">
        <div class="col-md-3 col-xs-12 col-sm-2">
            <label>
                <?=$this->lang->line('facebook_url')?>
            </label>
            <input type="text" name="facebook" value="" class="form-control" />
        </div>
        <div class="col-md-3 col-xs-12 col-sm-2">
            <label>
                <?=$this->lang->line('twitter_url')?>
            </label>
            <input type="text" name="twitter" value="" class="form-control" />
        </div>
        <div class="col-md-3 col-xs-12 col-sm-2">
            <label>
                <?=$this->lang->line('linkedin_url')?>
            </label>
            <input type="text" name="linkedin" value="" class="form-control" />
        </div>
        <div class="col-md-3 col-xs-12 col-sm-2">
            <label>
                <?=$this->lang->line('instagram_url')?>
            </label>
            <input type="text" name="instagram" value="" class="form-control" />
        </div>
    </div>

</form>

<div class = "row">
         <div class = "col-md-6 col-md-offset-3 col-xs-12 col-sm-8 col-sm-4 text-center">
             <button type="button" class="onlineformbtn btn-block btn-lg" style="margin-top:22.8px;"
                     data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> aguarde"
                     id='btn-cadastrar'
                      onclick="$(this)._saveCurriculo();"
                     >
                 <?=$this->lang->line('cl_enviar')?></button>
	
         </div> 
     </div>

<br /><br /><br /><br /><br /><br />

<script type="text/javascript">
     
     function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#guardian_address").val("");
                $("#guardian_address_number").val("");
                $("#guardian_district").val("");
                $("#guardian_city").val("");
                $("#guardian_state").val("");
            }
    
        function pesquisaCep (){
		
                //Nova variável "cep" somente com dígitos.
                var cep = $("#guardian_postal_code").val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
						$("#guardian_address").val("...");
						$("#guardian_district").val("...");
						$("#guardian_city").val("...");
						$("#guardian_state").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
								$("#guardian_address").val(dados.logradouro);
								$("#guardian_address_number").val("");
								$("#guardian_address_number").focus();
								$("#guardian_district").val(dados.bairro);
								$("#guardian_city").val(dados.localidade);
								$("#guardian_state").val(dados.uf);


                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                   alert("CEP inválido/nulo.");
                    $("#guardian_postal_code").focus();
                }
    };

    $('#guardian_postal_code').mask('99999-999');

    $(document).ready(function () {
        // Telefone contato mask
        $('#telefone').mask('(99) 9 9999-9999');
        // Mascara de data
        $('#dob').mask('99/99/9999');

        $.fn._modalPopup = function (msg, error = false) {
            $.confirm({
                title: '',
                content: msg,
                type: (error) ? 'red' : 'green',
                typeAnimated: true,
                buttons: {
                    '<?=$this->lang->line('close')?>': function () {}
                }
            })
        }
        $.fn._saveCurriculo = function () {
            $("#guardian_address").prop('disabled',false);
		    $("#guardian_address_number").prop('disabled',false);
		    $("#guardian_address_number").prop('disabled',false);
		    $("#guardian_district").prop('disabled',false);
		    $("#guardian_city").prop('disabled',false);
		    $("#guardian_state").prop('disabled',false);
            $('#btn-cadastrar').button('loading');
            $.post('<?=base_url('workwithus/enviar')?>', $('#employeeform').serialize(), function (respJson) {
                $('#btn-cadastrar').button('reset');

                try {
                    var resp = JSON.parse(respJson);

                    if (!resp.status) {
                        $(this)._modalPopup(resp.msg, true);
                    } else {
                        $(this)._modalPopup(resp.msg, false);
                        $("#employeeform").trigger("reset");
                    }
                } catch (e) {
                    $(this)._modalPopup(e, true);
                }
            }).fail(function (err) { console.log('Err ', err); $(this)._modalPopup('Ocorreu um erro. Tente novamente', true); $('#btn-cadastrar').button('reset'); });
        }

    });
</script>