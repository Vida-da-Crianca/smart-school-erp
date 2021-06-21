<style>
    .req{
        color:red;
    }
</style>
<?php
if (!$form_admission)
{
?>
    <div class="alert alert-danger">
       <?php echo $this->lang->line('admission_form_disable_please_contact_to_administrator'); ?>
    </div>
    <?php
    return;
}
?>

<?php
if ($this->session->flashdata('msg'))
{
    $message = $this->session->flashdata('msg');
    echo $message;
}
?>

<form id="form1" class="spaceb60 onlineform" action="<?php echo current_url() ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">

 <h2><?php echo $this->lang->line('admission') . " " . $this->lang->line('online'); ?></h2>
  <?php
if (isset($error_message))
{
    // echo "<div class='alert alert-danger'>" . $error_message . "</div>";
    
}
?>

 <div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
            <select  id="class_id" name="class_id" class="form-control"  >
                <option value=""><?php echo $this->lang->line('select'); ?></option>
                <?php
foreach ($classlist as $class)
{
?>
                    <option value="<?php echo $class['id'] ?>"<?php if (set_value('class_id') == $class['id'])
    {
        echo "selected=selected";
    }
?>><?php 
$count ="";
echo $class['class'] ?></option>
                    <?php
    $count++;
}
?>



            </select>
            <span class="text-danger"><?php echo form_error('class_id'); ?></span>
        </div>
    </div>
    <div class="col-md-3" style="display: none;">

        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('section'); ?></label><small class="req"> *</small>
            <select  id="section_id" name="section_id" class="form-control" >
                <option value=""   ><?php echo $this
    ->lang
    ->line('select'); ?></option>
            </select>
            <span class="text-danger"><?php echo form_error('section_id'); ?></span>
        </div>
    </div>


    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('first_name'); ?></label><small class="req"> *</small>
            <input id="firstname" name="firstname" placeholder="" type="text" class="form-control"  value="<?php echo set_value('firstname'); ?>" />
            <span class="text-danger"><?php echo form_error('firstname'); ?></span>
        </div>
    </div>



    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('last_name'); ?></label>
            <input id="lastname" name="lastname" placeholder="" type="text" class="form-control"  value="<?php echo set_value('lastname'); ?>" />
            <span class="text-danger"><?php echo form_error('lastname'); ?></span>
        </div>
    </div>
  </div><!--./row-->
  <div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputFile"> <?php echo $this
    ->lang
    ->line('gender'); ?></label><small class="req"> *</small>
            <select class="form-control" name="gender">
                <option value=""><?php echo $this
    ->lang
    ->line('select'); ?></option>
                <?php
foreach ($genderList as $key => $value)
{
?>
                    <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key)
    {
        echo "selected";
    }
?>><?php echo $value; ?></option>
                    <?php
}
?>
            </select>
            <span class="text-danger"><?php echo form_error('gender'); ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('date_of_birth'); ?></label><small class="req"> *</small>
            <input  type="text" class="form-control date2" 
                    value="<?php echo set_value('dob'); ?>" id="dob" name="dob"/>
            <span class="text-danger"><?php echo form_error('dob'); ?></span>
        </div>
    </div>
  <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('mobile_no'); ?></label>
            <input  type="tel" class="form-control"  value="<?php echo set_value('mobileno'); ?>" id="mobileno" name="mobileno"/>
            <span class="text-danger"><?php echo form_error('mobileno'); ?></span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('email'); ?></label>
            <input  type="text" class="form-control"  value="<?php echo set_value('email'); ?>" id="email" name="email"/>
            <span class="text-danger"><?php echo form_error('email'); ?></span>
        </div>
    </div>




</div><!--./row-->
    <div class="row">
        <div class="col-md-12"><h4 class="pagetitleh2"><?php echo $this
    ->lang
    ->line('parent_guardian_detail'); ?></h4></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('father_name'); ?></label>
                        <input id="father_name" name="father_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_name'); ?>" />
                        <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('father_phone'); ?></label>
                        <input id="father_phone" name="father_phone" placeholder="" type="tel" class="form-control"  value="<?php echo set_value('father_phone'); ?>" />
                        <span class="text-danger"><?php echo form_error('father_phone'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('father_occupation'); ?></label>
                        <input id="father_occupation" name="father_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('father_occupation'); ?>" />
                        <span class="text-danger"><?php echo form_error('father_occupation'); ?></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('mother_name'); ?></label>
                        <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_name'); ?>" />
                        <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('mother_phone'); ?></label>
                        <input id="mother_phone" name="mother_phone" placeholder="" type="tel" class="form-control"  value="<?php echo set_value('mother_phone'); ?>" />
                        <span class="text-danger"><?php echo form_error('mother_phone'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this
    ->lang
    ->line('mother_occupation'); ?></label>
                        <input id="mother_occupation" name="mother_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('mother_occupation'); ?>" />
                        <span class="text-danger"><?php echo form_error('mother_occupation'); ?></span>
                    </div>
                </div>
        </div><!--./row-->

        <div class="row">
                <div class="form-group col-md-12">
                    <label><?php echo $this
    ->lang
    ->line('if_guardian_is'); ?><small class="req"> *</small>&nbsp;&nbsp;&nbsp;</label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" <?php
echo set_value('guardian_is') == "father" ? "checked" : "";
?>   value="father"> <?php echo $this
    ->lang
    ->line('father'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" <?php
echo set_value('guardian_is') == "mother" ? "checked" : "";
?>   value="mother"> <?php echo $this
    ->lang
    ->line('mother'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" <?php
echo set_value('guardian_is') == "other" ? "checked" : "";
?>   value="other"> <?php echo $this
    ->lang
    ->line('other'); ?>
                    </label>
                    <span class="text-danger"><?php echo form_error('guardian_is'); ?></span>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo $this->lang->line('upload') . " " . $this->lang->line('documents'); ?></label>
                        <input id="document" name="document"  type="file" class="form-control"  value="<?php echo set_value('document'); ?>" />
                        <span class="text-danger"><?php echo form_error('document'); ?></span>
                    </div>
                </div>


						<div class="col-md-4">
						<div class="form-group">
						 <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_document'); ?></label><small class="req"> *</small>
						<input id="guardian_document" name="guardian_document" placeholder="" type="tel" class="form-control" value="<?php echo set_value('guardian_document'); ?>" />
						<span class="text-danger"><?php echo form_error('guardian_document'); ?></span>
						</div>
						</div>
											
											
						<div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_name'); ?></label><small class="req"> *</small>
                                <input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_name'); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_relation'); ?></label>
                                <input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_relation'); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
                            </div>
                        </div>
                </div><!--./row-->
                <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_phone'); ?></label><small class="req"> *</small>
                                <input id="guardian_phone" name="guardian_phone" placeholder="" type="tel" class="form-control"  value="<?php echo set_value('guardian_phone'); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_occupation'); ?></label>
                                <input id="guardian_occupation" name="guardian_occupation" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_occupation'); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_occupation'); ?></span>
                            </div>
                        </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_email'); ?></label>
                        <input id="guardian_email" name="guardian_email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('guardian_email'); ?>" />
                        <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
                    </div>

                </div>

                <!--<div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php //echo $this->lang->line('guardian_address'); ?></label>
                    <textarea id="guardian_address" name="guardian_address" placeholder="" class="form-control" rows="2">
					<?php //echo set_value('guardian_address'); ?>
					</textarea>
                    <span class="text-danger"><?php //echo form_error('guardian_address'); ?></span>
                  </div>-->
                </div>
				
				
				<div class="row">

   <div class="row col-md-12">
     
	 <div class="col-md-2 form-group">
         <label for="exampleInputEmail1">Responsável Cep</label> <small class="req"> *</small>
         <input maxlength="9" 
                id="guardian_postal_code" 
                name="guardian_postal_code" 
                placeholder="Digite o cep" 
                class="form-control" 
                type="tel"
                value="<?php if(isset($_POST['guardian_postal_code'])){ echo $_POST['guardian_postal_code']; };?>">
		 <span class="text-danger"><?php echo form_error('guardian_postal_code'); ?></span>
      </div>
	  <!-- botão pesquisar CEP -->
      <div class="col-md-4 form-group">
         <label for="exampleInputEmail1">&nbsp;</label>
         <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processando" id="trigger-cep" data-target="guardian_postal_code" 
		 style="padding: 3.8px 15px;" type="button" class="btn onlineformbtn" onclick="$(this).pesquisaCep();">Pesquisar endereço</button>
      </div>
   </div>
   
   
   <div class="col-md-4">
      <label for="exampleInputEmail1">Endereço do Responsável Financeiro </label>
      <input maxlength="30" id="guardian_address" name="guardian_address" placeholder="Rua exemplo" class="form-control" 
	  value="<?php echo set_value('guardian_address');?>">
      <span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
   </div>
   <div class="col-md-2">
      <label>Número</label>
      <input onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="30" id="guardian_address_number" name="guardian_address_number" placeholder="23" class="form-control" 
	  value="<?php echo set_value('guardian_address_number');?>">
      <span class="text-danger"><?php echo form_error('guardian_address_number'); ?></span>
   </div>
   <div class="col-md-3">
      <label for="exampleInputEmail1">Responsável Bairro</label>
      <input maxlength="20" id="guardian_district" name="guardian_district" placeholder="" class="form-control" 	  
	  value="<?php echo set_value('guardian_district');?>">
      <span class="text-danger"><?php echo form_error('guardian_district'); ?></span>
   </div>
   <div class="col-md-2">
      <label for="exampleInputEmail1">Responsável Cidade</label>
      <input maxlength="20" id="guardian_city" name="guardian_city" placeholder="Barretos" class="form-control" 
	  value="<?php if(isset($_POST['guardian_city'])){ echo $_POST['guardian_city']; };?>">
      <span class="text-danger"><?php echo form_error('guardian_city'); ?></span>
   </div>
   <div class="col-md-1">
      <label for="exampleInputEmail1">UF</label>
      <input maxlength="2" id="guardian_state" name="guardian_state" placeholder="SP" class="form-control" 
	  value="<?php if(isset($_POST['guardian_state'])){ echo $_POST['guardian_state']; };?>">
       <span class="text-danger"><?php echo form_error('guardian_state'); ?></span>
   </div>
</div>

	<div class="row mt-5">
 
	<div class="col-md-12">
	<div class="form-group pull-right">
	<button type="submit" class="onlineformbtn" style="margin-top:22.8px;"><?php echo $this->lang->line('save'); ?></button>
	</div>
	</div>
	</div><!--./row-->
	
</form>

<!-- Adicionando JQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="<?php echo base_url() ?>backend/plugins/jquery.mask.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {

        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id', 0) ?>';

        getSectionByClass(class_id, section_id);

        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            getSectionByClass(class_id, 0);
        });

        $('.date2').datepicker({
            autoclose: true,
            todayHighlight: true,
            format:'dd/mm/yyyy'
        });

        function getSectionByClass(class_id, section_id) {

            if (class_id !== "") {
                $('#section_id').html("");

                var div_data = '';
                var url = "";

                $.ajax({
                    type: "POST",
                    url: base_url + "welcome/getSections",
                    data: {'class_id': class_id},
                    dataType: "json",
                    beforeSend: function () {
                        $('#section_id').addClass('dropdownloading');
                    },
                    success: function (data) {
                        $.each(data, function (i, obj)
                        {
                            var sel = "";
                            if (section_id === obj.section_id) {
                                sel = "selected";
                            }
                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj.section + "</option>";
                        });
                        $('#section_id').append(div_data);
                    },
                    complete: function () {
                        $('#section_id').removeClass('dropdownloading');
                    }
                });
            }
        }

        function auto_fill_guardian_address() {
            if ($("#autofill_current_address").is(':checked'))
            {
                $('#current_address').val($('#guardian_address').val());
            }
        }
        function auto_fill_address() {
            if ($("#autofill_address").is(':checked'))
            {
                $('#permanent_address').val($('#current_address').val());
            }
        }
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
        
        
         function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#guardian_address").val("");
                $("#guardian_address_number").val("");
                $("#guardian_district").val("");
                $("#guardian_city").val("");
                $("#guardian_state").val("");
            }
		
            
            //Quando o campo cep perde o foco.
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
       


        $('[name="guardian_postal_code"]').mask('00000-000');
        $('[name="guardian_document"]').mask('000.000.000-00');
        $('[name="mobileno"]').mask('(00) 0 0000-0000');

        $('[name="guardian_phone"]').mask('(00) 000000000');    
        $('[name="father_phone"]').mask('(00) 000000000');
        $('[name="mother_phone"]').mask('(00) 000000000');  
        
        $('.date2').mask('00/00/0000'); 


        $('.languageselectpicker').selectpicker();

});
    
</script>

