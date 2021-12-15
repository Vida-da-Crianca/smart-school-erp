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
<?php if(!$form_admission): ?>
    <div class="alert alert-danger">
       <?php echo $this->lang->line('admission_form_disable_please_contact_to_administrator'); ?>
    </div>
<?php return; endif; ?>
<?php if($this->session->flashdata('msg')): ?>
    <?php  echo $this->session->flashdata('msg'); ?>
<?php endif; ?>


<form class="spaceb60 onlineform" onsubmit="return;"
      action=""  
      id="employeeform" 
      name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="save" value="1" />
     <input type='hidden' name='_submit' value='yeap' >
    <h2>Matícula Online</h2>
    
    <?php if(is_array($erros) && count($erros)>0): ?>
        <?php foreach($erros as $erro ): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <h4 class="h4">Dados do Aluno(a)</h4>
    
    
    <div class = "row">
        <div class = "col-md-8 col-xs-12 col-sm-6">
            <label>Nome Completo do Aluno(a)</label><small class="req"> *</small><br />
            <input type="text" 
                   name="firstname" 
                   id="firstname" 
                   value="<?php echo set_value('firstname'); ?>"
                   placeholder="Nome completo"
                   class="form-control"/>
            <span class="text-danger"><?php echo form_error('firstname'); ?></span>
        </div> 
         <div class = "col-md-2 col-xs-12 col-sm-3">
            <label>Sexo do Aluno(a)</label><small class="req"> *</small><br />
            <?php echo form_dropdown('gender',$genderList, set_value('gender'), "id='gender' class='form-control'"); ?>

            <span class="text-danger"><?php echo form_error('gender'); ?></span>
        </div> 
         <div class = "col-md-2 col-xs-12 col-sm-3">
            <label>Data de Nascimento</label><small class="req"> *</small><br />
            <input type="tel" 
                   name="dob" 
                   id="dob" 
                   value="<?php echo set_value('dob'); ?>"
                   placeholder="Data de Nascimento do Aluno(a)"
                   class="form-control"/>
            <span class="text-danger"><?php echo form_error('dob'); ?></span>
        </div> 
    </div>
    <br />
    <div class = "row">
         <div class = "col-md-4 col-xs-12 col-sm-4">
            <label>Ano da Matrícula</label><small class="req"> *</small><br />
            <?php echo form_dropdown('session_id',$sessions, '', "id='session_id' class='form-control'"); ?>
            <span class="text-danger"><?php echo form_error('session_id'); ?></span>           
        </div>
        <div class = "col-md-4 col-xs-12 col-sm-4">
            <label>Escolha uma Turma</label><small class="req"> *</small><br />
             <?php echo form_dropdown('class_id',['0'=>'## Nenhuma Turma Disponível ###'], '', "id='class_id' class='form-control'"); ?>
            <span class="text-danger"><?php echo form_error('class_id'); ?></span>           
        </div> 
        <div class = "col-md-4 col-xs-12 col-sm-4">
            <label>Escolha um Período</label><small class="req"> *</small><br />
          <select  id="section_id" name="section_id" class="form-control" >
                <option value=""   ><?php echo $this->lang->line('select'); ?></option>
            </select>
            <span class="text-danger"><?php echo form_error('section_id'); ?></span>
        
        </div> 
       
    </div>
    
    
     <h4 class="h4">Dados do Pais</h4>
     <div class = "row">
         <div class = "col-md-6 col-xs-12 col-sm-6">
             <label>Nome do Pai</label><br />
             <input type="text" 
                    name="father_name" 
                    id="father_name" 
                    value="<?php echo set_value('father_name'); ?>"
                    placeholder="Nome completo do pai"
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('father_name'); ?></span>
         </div>
         <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Telefone do Pai</label><br />
             <input type="tel" 
                    name="father_phone" 
                    id="father_phone" 
                    value="<?php echo set_value('father_phone'); ?>"
                    placeholder="Fixo ou Celular"
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('father_phone'); ?></span>
         </div>
          <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Profissão do Pai</label><br />
             <input type="text" 
                    name="father_occupation" 
                    id="father_occupation" 
                    value="<?php echo set_value('father_occupation'); ?>"
                    placeholder=""
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('father_occupation'); ?></span>
         </div>
     </div>
     <br />
     <div class = "row">
         <div class = "col-md-6 col-xs-12 col-sm-6">
             <label>Nome da Mãe</label><br />
             <input type="text" 
                    name="mother_name" 
                    id="mother_name" 
                    value="<?php echo set_value('mother_name'); ?>"
                    placeholder="Nome completo da mãe"
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
         </div>
         <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Telefone da Mãe</label><br />
             <input type="tel" 
                    name="mother_phone" 
                    id="mother_phone" 
                    value="<?php echo set_value('mother_phone'); ?>"
                    placeholder="Fixo ou Celular"
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('mother_phone'); ?></span>
         </div>
          <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Profissão da Mãe</label><br />
             <input type="text" 
                    name="mother_occupation" 
                    id="mother_occupation" 
                    value="<?php echo set_value('mother_occupation'); ?>"
                    placeholder=""
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('mother_occupation'); ?></span>
         </div>
     </div>
     <br />
     <div class = "row">
         <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Quem é o Responsável Financeiro?</label><small class="req"> *</small><br />
              <label class="radio-inline">
                        <input type="radio" name="guardian_is" 
                            <?php echo set_value('guardian_is') == "father" ? "checked" : "";?>
                            value="father"> <?php echo $this->lang->line('father'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" 
                            <?php echo set_value('guardian_is') == "mother" ? "checked" : ""; ?>
                               value="mother"> <?php echo $this->lang->line('mother'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" 
                            <?php echo set_value('guardian_is') == "other" ? "checked" : "";?>
                               value="other"> <?php echo $this->lang->line('other'); ?>
                    </label>
              <span class="text-danger"><?php echo form_error('guardian_is'); ?></span>
         </div> 
         <div class = "col-md-2 col-xs-12 col-sm-2">
             <label>Relação com o Aluno</label><small class="req"> *</small><br />
              <input type="text" 
                    name="guardian_relation" 
                    id="guardian_relation" 
                    value="<?php echo set_value('guardian_relation'); ?>"
                    placeholder="Tio, avô, avó..."
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
         </div>
          <div class = "col-md-7 col-xs-12 col-sm-7">
             <label>Nome do Responsável Financeiro</label><small class="req"> *</small><br />
              <input type="text" 
                    name="guardian_name" 
                    id="guardian_name" 
                    value="<?php echo set_value('guardian_name'); ?>"
                    placeholder="Nome Completo"
                    class="form-control"/>
             <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
         </div>
     </div>
     <br />
     <div class = "row">
         <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>CPF do Responsável</label><small class="req"> *</small><br />
            <input type="tel" 
                      name="guardian_document" 
                      id="guardian_document" 
                      value="<?php echo set_value('guardian_document'); ?>"
                      placeholder=""
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_document'); ?></span>
         </div> 
          <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Telefone do Responsável</label><small class="req"> *</small><br />
            <input type="tel" 
                      name="guardian_phone" 
                      id="guardian_phone" 
                      value="<?php echo set_value('guardian_phone'); ?>"
                      placeholder="Fixo ou Celular"
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
         </div>
          <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Email do Responsável</label><small class="req"> *</small><br />
          <input type="email" 
                      name="guardian_email" 
                      id="guardian_email" 
                      value="<?php echo set_value('guardian_email'); ?>"
                      placeholder="Email para comunicação geral"
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
         </div>
          <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Profissão do Responsável</label><br />
          <input type="text" 
                      name="guardian_occupation" 
                      id="guardian_occupation" 
                      value="<?php echo set_value('guardian_occupation'); ?>"
                      placeholder=""
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_occupation'); ?></span>
         </div>
     </div>
   
     <h4>Endereço</h4>
     <div class = "row">
         <div class = "col-md-2 col-xs-12 col-sm-2">
             <label>CEP</label><small class="req"> *</small><br />
              <input type="tel" 
                      name="guardian_postal_code" 
                      id="guardian_postal_code" 
                      value="<?php echo set_value('guardian_postal_code'); ?>"
                      placeholder=""
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_postal_code'); ?></span>
         </div>
         <div class = "col-md-2 col-xs-12 col-sm-2">
            <label >&nbsp;</label>
            <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processando" id="trigger-cep" data-target="guardian_postal_code" 
                    style="padding: 3.8px 15px;" type="button" class="btn onlineformbtn" onclick="$(this).pesquisaCep();">Pesquisar endereço</button>
         </div>
          <div class = "col-md-6 col-xs-12 col-sm-6">
             <label>Endereço</label><small class="req"> *</small><br />
            <input type="text" 
                      name="guardian_address" 
                      id="guardian_address" 
                      value="<?php echo set_value('guardian_address'); ?>"
                      placeholder=""
                      disabled="disabled"
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
         </div>
          <div class = "col-md-2 col-xs-12 col-sm-2">
             <label>nº</label><br />
            <input type="text" 
                      name="guardian_address_number" 
                      id="guardian_address_number" 
                      value="<?php echo set_value('guardian_address_number'); ?>"
                      placeholder=""
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_address_number'); ?></span>
         </div>
     </div>
     <br />
     <div class = "row">
         <div class = "col-md-4 col-xs-12 col-sm-4">
              <label>Bairro</label><small class="req"> *</small><br />
            <input type="text" 
                      name="guardian_district" 
                      id="guardian_district" 
                      value="<?php echo set_value('guardian_district'); ?>"
                      placeholder=""
                      disabled="disabled"
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_district'); ?></span>
         </div>
          <div class = "col-md-4 col-xs-12 col-sm-4">
              <label>Cidade</label><small class="req"> *</small><br />
            <input type="text" 
                      name="guardian_city" 
                      id="guardian_city" 
                      value="<?php echo set_value('guardian_city'); ?>"
                      placeholder=""
                      disabled="disabled"
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_city'); ?></span>
         </div>
          <div class = "col-md-2 col-xs-12 col-sm-2">
              <label>UF</label><small class="req"> *</small><br />
            <input type="text" 
                      name="guardian_state" 
                      id="guardian_state" 
                      value="<?php echo set_value('guardian_state'); ?>"
                      placeholder=""
                      disabled="disabled"
                      class="form-control"/>
               <span class="text-danger"><?php echo form_error('guardian_state'); ?></span>
         </div>
     </div>
     
     <h4>Documentos e Foto do Aluno</h4>
     <div class = "row">
         <div class = "col-md-3 col-xs-12 col-sm-3">
             <label>Foto do Aluno</label><br />
            
              <input type="text" id="image" 
                                       name="image"
                                       disabled="disabled" class="form-control documento"/>
             <input type="file" id="file_image" name="file_image" accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg" onchange="$(this).loadFile(event);"/>
             <div id="progress_file_image" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>
         </div>
        
                 <!-- <div class = "col-md-2 col-xs-12 col-sm-2">
                     <label>Certidão de Nascimento</label><br />
                     <input type="file" name="certidao_nascimento" accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf" />
                     <span class="text-danger"><?php echo form_error('certidao_nascimento'); ?></span>
                 </div> 
                  <div class = "col-md-2 col-xs-12 col-sm-2">
                     <label>Carteira de Vacinação</label><br />
                     <input type="file" name="carteira_vacinacao" accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf" />
                     <span class="text-danger"><?php echo form_error('carteira_vacinacao'); ?></span>
                 </div>
                  <div class = "col-md-2 col-xs-12 col-sm-2">
                     <label>CNH do Responsável</label><br />
                     <input type="file" name="cnh_responsavel" accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf" />
                     <span class="text-danger"><?php echo form_error('cnh_responsavel'); ?></span>
                 </div> 
            
                  <div class = "col-md-3 col-xs-12 col-sm-3">
                     <label>Comprovante de Residência</label><br />
                     <input type="file" name="comprovante_residencia" accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf" />
                     <span class="text-danger"><?php echo form_error('comprovante_residencia'); ?></span>
                 </div> -->
                 
                 
                   <?php 
                                $documentos = [
                                    'certidao_nascimento'=>'Certidão de Nascimento',
                                    'carteira_vacinacao'=>'Carteira de Vacinação',
                                    'cnh_responsavel'=>'CNH do Responsável',
                                    'comprovante_residencia'=>'Comprovante de Residência',
                                ]
                              ?>
                 
                 
                  <?php foreach($documentos as $campo => $label): ?>
                            <div class = "col-md-2 col-xs-12 col-sm-2">
                                <label><?php echo $label; ?></label>
                                <br />
                                <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" 
                                       value=""
                                       disabled="disabled" class="form-control documento"/>
                               <input type="file" name="<?php echo $campo; ?>_fileupload" 
                                      id="<?php echo $campo; ?>_fileupload" 
                                      accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf" style="opacity: 1;"/>
                                <div id="progress<?php echo $campo; ?>" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                            </div> 
                  <?php endforeach; ?>
                                           
                              
             
             
         </div>
     
     
     <br />
     </form>

     <div class = "row">
         <div class = "col-md-6 col-md-offset-3 col-xs-12 col-sm-8 col-sm-4 text-center">
             <button type="button" class="onlineformbtn btn-block btn-lg" style="margin-top:22.8px;"
                     data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> aguarde"
                     id='btn-cadastrar'
                      onclick="$(this)._saveStudent();"
                     >
                 FAZER MATRÍCULA</button>
	
         </div> 
     </div>

<br /><br /><br /><br /><br /><br />
    


<!-- Adicionando JQuery -->
<script src="<?php echo base_url(); ?>backend/dist/js/jquery-ui.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>backend/file-upload/js/jquery.fileupload.js"></script>

<script type='text/javascript'>
$(document).ready(function(){

             
   /*$('#dob').datepicker({
            autoclose: true,
            todayHighlight: true,
            format:'dd/mm/yyyy'
        });*/
        
        
        $('#father_phone').mask('(99) 999999999');
        $('#mother_phone').mask('(99) 999999999');
        $('#guardian_document').mask('999.999.999-99');
        $('#guardian_phone').mask('(99) 999999999');
        
        
        
          $.fn.comboBox = function(options)
	{
		var settings = $.extend({
			
			url: '',
			data: null,
			selected: null,
			combobox : ''	,
                        callback: null
			
		},options);
		
		$(settings.combobox).html('<option>Aguarde...</option>');
		
		$.post(settings.url, settings.data )
		.done(function(resp){
			
			try
			{
				resp_json =  jQuery.parseJSON(resp);
				
				if(resp_json.status)
				{
					if(resp_json.results.length > 0)
					{
						html = '';
						
						for(var i in resp_json.results)
						{
							html += '<option value="'+resp_json.results[i].value+'" ';
							if(resp_json.results[i].value == settings.selected){
								html += 'selected="selected"';
                                                            }
							html += ">";
							html += resp_json.results[i].label;
							html += '</option>';
							
						}
						
						$(settings.combobox).html(html);
                                                
                                                
                                                 if(typeof settings.callback == 'function'){
                                                            settings.callback.call(this, resp_json);
                                                 }
                                                
					}
					else{
                                            
                                            $(settings.combobox).html('<option value="0">*** Nenhum Resultado ***</option>');
                                        }
				}
				else
					$(settings.combobox).html('<option>*** Erro ao Processar ***</option>');
			}
			catch (e) {
				console.log(e);
				$(settings.combobox).html('<option>*** ERRO ***</option>');
				
			}
			
		})
		.fail(function(){
			
			$(settings.combobox).html('<option>*** Erro ***</option>');
		});
		
	};
        
        
    /*TURMA E PERIODO ---------------------------------------------------------*/
    /*Carrega o combobox de periodos*/
    $.fn.comboBoxPeriodo = function(){
        $(this).comboBox({
            url : '<?php echo base_url(); ?>welcome/getListaPeriodosPorTurma',
            data: { class_id : $('#class_id').val() },
            combobox : '#section_id',
            selected: '<?php echo set_value('section_id',''); ?>',
            callback: {function(){} }
        }); 
       
    };
    
    /*Verificar a turma com base na data de nascimento*/
    $.fn.carregarComboBoxTurmasDisponiveis = function(dataNascimento){
        $(this).comboBox({
            url : '<?php echo base_url(); ?>welcome/getListaTurmasPorDataNascimento',
            data: { dataNascimento : dataNascimento, session_id : $('#session_id').val() },
            combobox : '#class_id',
            selected: '',
            callback: function(){ 
                $(this).comboBoxPeriodo(); 
            } 
        });     
    };
    $(this).carregarComboBoxTurmasDisponiveis('<?php echo set_value('dob',date('01/01/2030')); ?>');
    
  
    $('#dob').mask('99/99/9999');    
        let typingTimer;                //timer identifier
        let doneTypingInterval = 1000;  //time in ms (5 seconds)
        let myInput = document.getElementById('dob');

        //on keyup, start the countdown
        $('#dob').keyup(function(){
            clearTimeout(typingTimer);
            if ($('#dob').val()) {
                typingTimer = setTimeout(function(){
                    $(this).carregarComboBoxTurmasDisponiveis($('#dob').val());
                }, doneTypingInterval);
            }
        });
        
    $('#session_id').change(function(){
         $(this).carregarComboBoxTurmasDisponiveis($('#dob').val());
    });    

    
    /*TURMA E PERIODO ---------------------------------------------------------*/
    
    function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#guardian_address").val("");
                $("#guardian_address_number").val("");
                $("#guardian_district").val("");
                $("#guardian_city").val("");
                $("#guardian_state").val("");
            }
    
     $('#guardian_postal_code').mask('99999-999');
    $.fn.pesquisaCep = function(){
		
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
        
        
        $('input:radio[name="guardian_is"]').change(
            function () {
                if ($(this).is(':checked')) {
                    var value = $(this).val();
                    if (value === "father") {
                        $('#guardian_name').val($('#father_name').val());
                        $('#guardian_phone').val($('#father_phone').val());
                        $('#guardian_occupation').val($('#father_occupation').val());
                        $('#guardian_relation').val("Pai");
                    } else if (value === "mother") {
                        $('#guardian_name').val($('#mother_name').val());
                        $('#guardian_phone').val($('#mother_phone').val());
                        $('#guardian_occupation').val($('#mother_occupation').val());
                        $('#guardian_relation').val("Mãe");
                    } else {
                        $('#guardian_name').val("");
                        $('#guardian_phone').val("");
                        $('#guardian_occupation').val("");
                        $('#guardian_relation').val("");
                    }
                }
        });
        
        
       /* $('#btn-cadastrar').click(function(e){
                e.preventDefault();
                $('#btn-cadastrar').button('loading');
                $("#guardian_address").prop('disabled',false);
		$("#guardian_address_number").prop('disabled',false);
		$("#guardian_address_number").prop('disabled',false);
		$("#guardian_district").prop('disabled',false);
		$("#guardian_city").prop('disabled',false);
		$("#guardian_state").prop('disabled',false);
                $('#form1').submit();
                
        });*/
        
       /* $.fn.loadFile = function(event) {
            var output = document.getElementById('student_image');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
              URL.revokeObjectURL(output.src); // free memory
            };
          };
          
          $('#student_image').click(function(){
              $('#file_image').trigger('click');
          });*/
    
    
    
     /*DOCUMENTOS*/
     <?php foreach($documentos as $campo => $label): ?>
     $('#progress<?php echo $campo; ?>').hide();
        $('#<?php echo $campo; ?>_fileupload').fileupload({
        url: '<?php echo base_url(); ?>uploader/preUpload',
        formData: { _submit: 'yeap', campo: '<?php echo $campo; ?>_fileupload'},
        dataType: 'json',
        done: function (e, data) {

           if(data.result.status){
                $('#<?php echo $campo; ?>').val(data.result.msg.name);
                 
           }else{
               alert(data.result.msg);
           }

           $('#progress<?php echo $campo; ?>').hide();
        },
        progressall: function (e, data) {
            $('#progress<?php echo $campo; ?>').show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress<?php echo $campo; ?> > .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');
     <?php endforeach; ?>
    /*DOCUMENTOS*/
    
    
    $('#progress_file_image').hide();
        $('#file_image').fileupload({
        url: '<?php echo base_url(); ?>uploader/preUpload',
        formData: { _submit: 'yeap', campo: 'file_image'},
        dataType: 'json',
        done: function (e, data) {

           if(data.result.status){
                $('#image').val(data.result.msg.name);
                 
           }else{
               alert(data.result.msg);
           }

           $('#progress_file_image').hide();
        },
        progressall: function (e, data) {
            $('#progress_file_image').show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress_file_image > .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');
    
    
    $.fn._saveStudent = function(){
        
          <?php foreach($documentos as $campo => $label): ?>
                $('#<?php echo $campo; ?>').prop('disabled',false);
        <?php endforeach; ?> 
            $('.documento').prop('disabled',false);
       
                $("#guardian_address").prop('disabled',false);
		$("#guardian_address_number").prop('disabled',false);
		$("#guardian_address_number").prop('disabled',false);
		$("#guardian_district").prop('disabled',false);
		$("#guardian_city").prop('disabled',false);
		$("#guardian_state").prop('disabled',false);
        $('#btn-cadastrar').button('loading');
        $.post('<?php echo base_url('online_admission'); ?>',$('#employeeform').serialize(),function(respJson){
            $('#btn-cadastrar').button('reset');
            try{
                
                var resp = JSON.parse(respJson);
                
                if(!resp.status)
                {
                    alert(resp.msg);
                }
                else
                {
                  // alert('Dados Gravados Corretamente!');
                  location.href = location.href;   
                }
                
                
            }catch(e){
                alert(e);
            }
        }).fail(function(err){console.log('Err ', err);alert('Ocorreu um erro! Tente novamente.');$('#btn-cadastrar').button('reset');});
            
        
     };
        
	

});
</script>

