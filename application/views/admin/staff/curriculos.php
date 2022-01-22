<!-- fontawesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="<?=base_url('backend/multiselect/css/multi.select.css')?>" rel="stylesheet" type="text/css">
<script src="<?=base_url('backend/multiselect/js/multi.select.js')?>"></script>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
           Todos os Currículos
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">

        <?php if(!isset($curriculo)) { ?>
         <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                        <div class="box-tools pull-right">
                            
                       </div>
                    </div>

                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="row text-center">

                                    <form role="form" action="<?php echo site_url('admin/curriculos') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <div class="form-group"> 
                                                <label><?php echo $this->lang->line("designation"); ?></label><small class="req"> *</small>

                                                <div class="multi" id="multi"></div>
                                                <input type="hidden" name="designation" id="designation" value="" />

                                                <script>
                                                    $('.multi').multi_select({
                                                      selectColor: 'dark',
                                                      selectSize: 'small',
                                                      selectText: 'Selecione um ou mais cargos para procurar',
                                                      duration: 0,
                                                      easing: 'slide',
                                                      listMaxHeight: 300,
                                                      selectedCount: 4,
                                                      sortByText: true,
                                                        fillButton: false,
                                                        selectedIndexes:
                                                            <?=$designation_selected?>,
                                                        
                                                        data: {
                                                          <?php 
                  foreach($designation as $value)
                      echo '"' . $value["id"] . '": "' . $value["designation"] . '",';
                  
                                                          ?>
             
                                                      },
                                                        onSelect: function (values) {
                                                            
                                                            $("#designation").attr('value', values);


                                                          return true;
                                                      }
                                                      });
                                                    </script>

                                                <span class="text-danger"><?php echo form_error('role'); ?></span>
                                                <span class="text-danger"><?php if ($this->session->flashdata('msg_find')) { ?>  <?php echo $this->session->flashdata('msg_find') ?> <?php } ?></span>
                                            </div>  
                                        </div>


                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                  </div>  
                                
                            </div>
                        </div>
                </div>
            </div>
         </div>
         
             <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php if ($this->session->flashdata('msg')) { ?>  <?php echo $this->session->flashdata('msg') ?> <?php } ?>

                        <?php if(isset($curriculo) and !empty($curriculo)):?>
                            <div class="alert alert-info">
                                Staff email is their login username, password is generated automatically and send to staff email. Superadmin can change staff password on their staff profile page.

                            </div>
                            <form id="form1" action="" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">

                                <div class="box-body">

                                    <div class="tshadow mb25 bozero">

                                        <h4 class="pagetitleh2">Informações Básicas </h4>

                                        <div class="around10">

                                            <div class="col-md-10">
                                                <?=$xcsrf_token?>
                                                <input type="hidden" name="id" value="<?=$curriculo->id?>">
                                                <div class="row">
                                                    <div class="col-md-4">

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Função</label><small class="req"> *</small>
                                                            <select id="role" name="role" class="form-control">
                                                                <option value="">Selecione</option>
                                                                <?php foreach($staffrole as $value): ?>
                                                                    <option value="<?=$value['id']?>" <?=($curriculo->funcao == $value["id"]) ? "selected" : ""?>><?=$value['type']?>
                                                                <?php endforeach;?>
                                                            </select>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="foto" id="foto" value="<?=$curriculo->foto?>" />
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Cargo</label>

                                                            <select id="designation" name="designation" placeholder="" type="text" class="form-control">

                                                                <option value="select">Selecione</option>
                                                                <?php foreach($designation as $value): ?>
                                                                    <option value="<?=$value['id']?>" <?=($curriculo->cargo == $value['id']) ? 'selected' : ''?>><?=$value['designation']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Departamento</label>
                                                            <select id="department" name="department" placeholder="" type="text" class="form-control">
                                                                <option value="">Selecione</option>
                                                                <?php foreach($department as $value): ?>
                                                                    <option value="<?=$value['id']?>" <?=($curriculo->departamento == $value['id']) ? 'selected' : ''?>><?=$value['department_name']?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nome Completo</label><small class="req"> *</small>
                                                            <input id="name" name="name" placeholder="" type="text" class="form-control" value="<?=$curriculo->nome?>">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <!--                                                   <div class="col-md-3">
                                                                   <div class="form-group">
                                                                       <label for="exampleInputEmail1">Último Nome</label>
                                                                       <input id="surname" name="surname" placeholder="" type="text" class="form-control"  value="" />
                                                                       <span class="text-danger"></span>
                                                                   </div>
                                                               </div>-->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nome Do Pai</label>
                                                            <input id="father_name" name="father_name" placeholder="" type="text" class="form-control" value="<?=$curriculo->nome_pai?>">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nome da mãe</label>
                                                        
                                                            <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control" value="<?=$curriculo->nome_mae?>">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">E-Mail (Login Nome De Usuário)</label><small class="req"> *</small>
                                                            <input id="email" name="email" placeholder="" type="text" class="form-control" value="<?=$curriculo->email?>">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputFile"> Sexo</label><small class="req"> *</small>
                                                            <select class="form-control" name="gender">

                                                                <option value="">Selecione</option>
                                                                <?php foreach($genderList as $key => $value): ?>
                                                                    <option value="<?=$key?>" <?=($curriculo->sexo == $key) ? 'selected' : ''?>><?=$value?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Data de Nascimento</label><small class="req"> *</small>
                                                            <input id="dob" name="dob" placeholder="" type="text" class="form-control date" value="<?=date('d/m/Y', strtotime($curriculo->data_nascimento))?>">
                                                            <script>
                                                                $("#dob").datepicker({ showOn: "off" });
                                                                $('#dob').mask('99/99/9999',{placeholder:"mm/dd/yyyy"});
                                                            </script>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Data De Inicío Contrato</label>
                                                            <input id="date_of_joining" name="date_of_joining" placeholder="" type="text" class="form-control date" value="<?php if($curriculo->contrato_inicio != "") date('d/m/Y', strtotime($curriculo->contrato_inicio));?>">
                                                            <script>
                                                                $("#date_of_joining").datepicker({ showOn: "off" });
                                                                $('#date_of_joining').mask('99/99/9999',{placeholder:"mm/dd/yyyy"});
                                                            </script>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Telefone</label>
                                                            <input id="mobileno" name="contactno" placeholder="" type="text" class="form-control" value="<?=$curriculo->telefone?>">
                                                            <script>
                                                                $('#mobileno').mask('(99)99999-9999',{placeholder:"(00)99999-9999"});
                                                            </script>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Número De Contato De Emergência</label>
                                                            <input id="emergency_no" name="emergency_no" placeholder="" type="text" class="form-control" value="<?=$curriculo->telefone_emergencia?>">
                                                            <script>
                                                                $('#emergency_no').mask('(99)99999-9999',{placeholder:"(00)99999-9999"});
                                                            </script>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Estado Civil</label>
                                                            <select class="form-control" name="marital_status">
                                                                <option value="">Selecione</option>
                                                                <?php foreach($marital_status as $key => $value) :?>
                                                                    <option value="<?=$value?>" <?=($curriculo->estado_civil == $value) ? "selected" : ""?>><?=$value?></option>
                                                                <?php endforeach; ?>

                                                            </select>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                               
                                                </div>
                                            </div>
                                             <div class="col-md-2 text-center">
                                                 <div class="form-group">
                                                        <label for="exampleInputFile"><?php echo $this->lang->line('photo'); ?></label>
                                                        <div>
                                                            <img src="<?=base_url('uploads/cv_images/') . $curriculo->foto?>" id="foto-aluno" style="width: 100px; height: 110px;">
                                                            <br /><br />
                                                            <input class="filestyle form-control" type='file' onchange="readURL(this);" name='file' id="file" size='20' accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg" />
                                                            <br />

                                                            <script>
                                                                function readURL(input) {
                                                                  if (input.files && input.files[0]) {
                                                                    var reader = new FileReader();

                                                                    reader.onload = function(e) {
                                                                      $('#foto-aluno')
                                                                        .attr('src', e.target.result);
                                                                      $('#foto-aluno').show();
                                                                    };

                                                                    reader.readAsDataURL(input.files[0]);
                                                                  }
                                                                }
                                                            </script>

                                                        
                                                        
                                                        
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                                    </div>
                                             </div> 
                                            
                                            <div class="row">

                                                <div class="col-md-12 form-group">
                                                    <label for="exampleInputEmail1">CEP</label> <small class="req"> *</small>
                                                    <input maxlength="9" id="postal_code" name="postal_code" placeholder="" onblur="pesquisacep(this.value);" class="form-control" value="<?=$curriculo->cep?>" autocomplete="off">
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Atual Endereço</label>
                                                        <div><textarea name="address" id="address-complete" class="form-control "></textarea>
                                                        </div>
                                                        <span class="text-danger"></span></div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Número</label>
                                                        <input maxlength="9" id="numero" name="numero" placeholder="" class="form-control" value="<?=$curriculo->numero?>" autocomplete="off">
                                                        <span class="text-danger"></span></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Endereço Permanente</label>
                                                        <div><textarea name="permanent_address" id="address-complete1" class="form-control address-complete"></textarea>
                                                        </div>
                                                        <span class="text-danger"></span></div>
                                                </div>

                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Qualificação</label>
                                                        <textarea id="qualification" name="qualification" placeholder="" class="form-control"><?=$curriculo->cursos?></textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Experiência Profissional</label>
                                                        <textarea id="work_exp" name="work_exp" placeholder="" class="form-control"><?=$curriculo->work_exp?></textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Nota</label>
                                                        <div><textarea name="note" class="form-control"><?=$curriculo->outros?></textarea>
                                                        </div>
                                                        <span class="text-danger"></span></div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <?php
                                                    echo display_custom_fields('staff', $curriculo->id);
                                                ?>


                                            </div>


                                            <div class="tshadow mb25 bozero">    
                                                <h4 class="pagetitleh2"><?php echo $this->lang->line('social_media'); ?>
                                                </h4>

                                                <div class="row around10">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('facebook_url'); ?></label>
                                                            <input id="bank_account_no" name="facebook" placeholder="" type="text" class="form-control"  value="<?php echo $curriculo->facebook; ?>" />

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('twitter_url'); ?></label>
                                                            <input id="bank_account_no" name="twitter" placeholder="" type="text" class="form-control"  value="<?php echo $curriculo->twitter ?>" />

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('linkedin_url'); ?></label>
                                                            <input id="bank_name" name="linkedin" placeholder="" type="text" class="form-control"  value="<?php echo $curriculo->linkedin ?>" />

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('instagram_url'); ?></label>
                                                            <input id="instagram" name="instagram" placeholder="" type="text" class="form-control"  value="<?php echo $curriculo->instagram ?>" />

                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                        </div>
                                    </div>


                                </div>
                                <div class="box-footer">
                                    <div class="row pull-right">
                                        <a href="<?=base_url('admin/curriculos/pdf/') . $curriculo->id ?>" target="_blank" class="btn btn-warning" ><?=$this->lang->line('cl_print_pdf');?></a>
                                        <button type="button" class="btn btn-success" onclick="confirmar_efetivacao();"><?=$this->lang->line('cl_effective_cv');?></button>
                                        <button type="submit" class="btn btn-info" ><?=$this->lang->line('cl_save_cv')?></button>
                                    </div>
                                </div>
                            </form>
                        <?php else:?>
                            
                            

                            <?php if(isset($curriculos) and !empty($curriculos)): ?>
                                   
                                <div class="box-header ptbnull"></div>  
                                <div class="tab-pane table-responsive no-padding">
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('name'); ?></th>
                                                <th><?php echo $this->lang->line('designation'); ?></th>
                                                <th>Data de Nascimento</th>
                                                <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                                <th>Data Envio</th>
                                                <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($curriculos as $curriculo):?>
                                                <tr>
                                                    <td><?=$curriculo['nome']?></td>
                                                    <td><?=$this->curriculo_model->getDesignation($curriculo['cargo'])->designation?></td>
                                                    <td><?=date('d/m/Y', strtotime($curriculo['data_nascimento'])) . ' - ' . $this->curriculo_model->calcularIdade($curriculo['data_nascimento']) . ' anos' ?></td>
                                                    <td><i class="fab fa-whatsapp" style="color: #25D366; cursor: pointer;" onclick="callwz(<?=$this->curriculo_model->getWhatsapp($curriculo['telefone'])?>);" aria-hidden="true"></i> <?=$this->curriculo_model->masc_tel($curriculo['telefone'])?></td>
                                                    <td><?=date('d/m/Y H:i', strtotime($curriculo['data_envio']))?></td>
                                                    <td  class="pull-right">
                                                        <a title="<?=$this->lang->line('cl_view_cv')?>" target="_blank" href="<?php echo base_url('admin/curriculos/ver/'.$curriculo['id'])?>"><i class="fa fa-navicon"></i></a>
                                                        <a title="<?=$this->lang->line('cl_delete_cv')?>"  href="javascript:void(0);" style="color: red;" onclick="confirmar_deletar(<?=$curriculo['id']?>);"><i class=" fa fa-trash"></i></a>
                                                        
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            
                                        </tbody>
                                    </table>
                                </div>


                            <?php else: ?>
                                <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                            <?php endif; ?>

                            
                            <!--<table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php



                                  if(isset($curriculos) and !empty($curriculos)):?>
                                <?php



                                      foreach ($curriculos as $values){?>

                                    <tr>
                                        <th scope="row"><?php echo $values['nome']?></th>
                                        <td><?php echo $values['email']?></td>
                                        <td><?php echo $values['cpf']?></td>
                                        <td><a href="<?php echo base_url('admin/curriculos/ver/'.$values['id'])?>" target="_blank" class="btn btn-primary btn-sm">ff</a></td>
                                    </tr>

                                <?php }
                                  endif;?>

                                </tbody>
                            </table>-->

                        <?php endif;?>

        </div>
        </div>
        </div>
        </div>

    </section>


</div>

<script type="text/javascript"> 
    // Abrir whatsapp
    function callwz(telefone) {
        window.open('https://wa.me/' + telefone);
    }

    function limpa_formulário_cep() {
        document.getElementsByClassName('address-complete').value="...";

    }


    function meu_callback(conteudo) {
         if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.

            var dados_endereco = conteudo.logradouro+' '+' '+conteudo.bairro+' '+' '+conteudo.localidade+' '+' '+conteudo.uf;


            document.getElementById('address-complete').value=(dados_endereco);
            document.getElementById('address-complete1').value=(dados_endereco);

         } //end if.
         else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
         }
    }

    function pesquisacep(valor) {

          //Nova variável "cep" somente com dígitos.
          var cep = valor.replace(/\D/g, '');

          //Verifica se campo cep possui valor informado.
          if (cep != "") {

              //Expressão regular para validar o CEP.
              var validacep = /^[0-9]{8}$/;

              //Valida o formato do CEP.
              if(validacep.test(cep)) {

                  //Preenche os campos com "..." enquanto consulta webservice.
                  document.getElementsByClassName('address-complete').value="...";


                  //Cria um elemento javascript.
                  var script = document.createElement('script');

                  //Sincroniza com o callback.
                  script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                  //Insere script no documento e carrega o conteúdo.
                  document.body.appendChild(script);

              } //end if.
              else {
                  //cep é inválido.
                  limpa_formulário_cep();
                  alert("Formato de CEP inválido.");
              }
          } //end if.
          else {
             //cep sem valor, limpa formulário.
             limpa_formulário_cep();
          }
    };

    function confirmar_deletar(id) {
        $.confirm({
            title: '<?=$this->lang->line('cl_confirm_action')?>',
            content: '<?=$this->lang->line('cl_confirm_delete')?>',
            buttons: {
                confirmar: {
                    btnClass: 'btn-success',
                    action: function () {
                        window.location = "<?=base_url('admin/curriculos/deletar/')?>" + id;
                    }
                },

                 cancelar: {
                    btnClass: 'btn-danger',
                    action: function () {
                        $.alert('<?=$this->lang->line('cl_cancelled_delete')?>');
                    }
                }
            }
        });
    }

    function efetivacao_confirmada() {
        $.post('<?=base_url('admin/curriculos/salvar/efetivar')?>', $("#form1").serialize(), function (respJson) {
            try {
                
                var resp = JSON.parse(respJson);
                if (!resp.status)
                    $.alert({
                        'title': 'Error',
                        'content': resp.msg
                    });
                else
                    $.alert({
                        'title': 'Sucesso',
                        'content': resp.msg,
                        buttons: {
                            OK: {
                                action: function () {
                                    window.location.href = '<?=base_url('admin/staff/edit/')?>' + resp.id;
                                }
                            }
                        }
                    });

                
            } catch (e) {
                console.log(e);
            }
        }).fail(function (err) { console.log('Err', err); });
    }

    function confirmar_efetivacao() {
        $.confirm({
            title: '<?=$this->lang->line('cl_confirm_action')?>',
            content: '<?=$this->lang->line('cl_confirm_effective')?>',
            buttons: {
                '<?=$this->lang->line('cl_effective_cv')?>': {
                    btnClass: 'btn-success',
                    action: function () {
                        efetivacao_confirmada();
                    }
                },
                '<?=$this->lang->line('cancel')?>': {
                    btnClass: 'btn-danger',
                    action: function () {

                        $.alert('<?=$this->lang->line('cl_cancelled_effective')?>');
                    }
                }
            }
        })
    }

    function others_actions() {
        $.confirm({
            title: '<?=$this->lang->line('cl_print_pdf');?>',
            content: '<?=$this->lang->line('cl_action_description')?>',
            buttons: {
                '<?=$this->lang->line('cl_action_print_cv')?>': {
                    btnClass: 'btn-info',
                    action: function () {
                    }
                },
                '<?=$this->lang->line('cl_action_download_pdf')?>': {
                    btnClass: 'btn-success',
                    action: function () {
                    }
                },
                '<?=$this->lang->line('cl_action_close')?>': {
                    btnClass: 'btn-danger',
                    action: function () {
                    }
                }
            }
        });
    }

    $(document).ready(function () {
        $("#postal_code").blur();

        $("#form1").on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '<?=base_url('admin/curriculos/salvar/salvar')?>',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (respJson) {
                    try {

                        var resp = JSON.parse(respJson);
                        if (!resp.status)
                            $.alert({
                                'title': 'Error',
                                'content': resp.msg
                            });
                        else
                            $.alert({
                                'title': 'Sucesso',
                                'content': resp.msg
                            });

                        if (resp.foto)
                            $("#foto").val(resp.foto);


                    } catch (e) {
                        console.log(e);
                        $.alert({
                            'title': 'Error',
                            'content': e
                        });
                    }

                },
                error: function (xhr, textStatus, error) {
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);

                    $('#btn-cadastrar').button('reset');

                    $.alert({
                        'title': 'Error',
                        'content': error
                    });
                }
            });

        })

    })


</script>