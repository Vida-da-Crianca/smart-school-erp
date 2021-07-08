<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   
     <!-- Main content -->
    <section class="content">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header ptbnull">
                <h3 class="box-title titlefix">
                    Orçamentos
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm" type="button" onclick="$(this).addUpdateOrcamento('add','Novo Orçamento',0);">
                        <i class="fa fa-plus"></i> Novo Orçamento</button>
                   
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body" style="max-width:100% !important;">

                <form class="form form-inline" id="form-pesquisa-orcamentos" method="POST" action="<?php echo base_url('admin/orcamento/lancados'); ?>" target="_blank" onsubmit="return;">
                    
                    <input type="hidden" name="output" value="screen" />
                    
                    <input type="text" 
                           name="idOrcamento" 
                           id="" 
                           value=""
                           placeholder="nº do Orçamento"
                           class="form-control"/>
                    <input type="text" 
                           name="nome" 
                           id="" 
                           value=""
                           placeholder="Buscar aluno, pai, responsável"
                           class="form-control"/>
                    
                    <input type="text" 
                           name="telefone" 
                           id="filtro-telefone" 
                           value=""
                           placeholder="Buscar telefone"
                           class="form-control"/>
                    <input type="text" 
                           name="data1" 
                           id="data1" 
                           value="<?php echo date('01/m/Y'); ?>"
                           placeholder="Data inicial"
                           class="form-control"/>
                    <input type="text" 
                           name="data2" 
                           id="data2" 
                           value="<?php echo date('t/m/Y'); ?>"
                           placeholder="Data final"
                           class="form-control"/>
                    <?php echo form_dropdown('tipoData',[0=>'Data de Nascimento',1=>'Data do Orçamento'], 1, "id='' class='form-control'"); ?>

                    <button type="button" 
                            class="btn btn-primary submit_schsetting " 
                            onclick="$(this).buscarOrcamentos();"
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> 
                                <?php echo $this->lang->line('search'); ?>
                    </button>
                    
                </form>
                
                <hr />
                
                <div id="output-orcamentos"></div>
                
            </div>
        </div> <!-- general form elements -->
    </section><!-- Main content -->
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>backend/bootstrap-dialog/dist/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>backend/bootstrap-dialog/dist/js/bootstrap-dialog.min.js" type="text/javascript"></script> 

<script type='text/javascript'>
$(document).ready(function(){

    var date_format = 'dd/mm/yyyy';
    $('#data1').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
    });
     $('#data2').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
    });


    $('#filtro-telefone').mask('(99) 9 9999-9999');
    $('#data1').mask('99/99/9999');
    $('#data2').mask('99/99/9999');

    $.fn.addUpdateOrcamento = function(action,title,id){
        $(this)._dialog({ 
            title: title, 
            url: '<?php echo base_url('admin/orcamento/add'); ?>',
            data: {action : action, id : id }

        });
    };   
    
    $.fn.buscarOrcamentos = function(){
        $(this).search({
            output : '#output-orcamentos',
            data: $('#form-pesquisa-orcamentos').serialize(), 
            url: '<?php echo base_url('admin/orcamento/lancados'); ?>'
        });
    };
    $(this).buscarOrcamentos();
    
    $.fn.deleteOrcamento = function(id){
       BootstrapDialog.confirm({
            title: 'Excluir Orçamento',
            message: '<h3 class="text-center">Confirma Exclusão do Orçamento nº: '+id+'?</h3>',
            type: BootstrapDialog.TYPE_DEFAULT, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Fechar', // <-- Default value is 'Cancel',
            btnOKLabel: 'Confirmar', // <-- Default value is 'OK',
            btnOKClass: 'btn-success', // <-- If you didn't specify it, dialog type will be used,
            size: BootstrapDialog.SIZE_SMALL,
            onshown: function(dialogRef){
	               
                       $('.modal-dialog').last().css('z-index',1201);
            },
            callback: function(result) {


                if(result) {


                     $(this)._submit({
                      url : '<?php echo base_url('admin/orcamento/delete'); ?>',
                      data: { id : id, _submit : 'yeap'  },
                      callback: function(resp){

                          if(!resp.status)
                          {
                               alert(resp.msg);
                          }
                          else
                          {
                                $(this).buscarOrcamentos();
                          }

                      }

                  });

                }
            }
         });  
    };    
    
    
    $.fn._enviarOrcamento = function(idOrcamento,email){
        BootstrapDialog.confirm({
                title: 'Enviar por Email',
                message: '<label>Email</label><br /><input type="email" id="emailEnviar" value="'+(email)+'" class="form-control">',
                type: BootstrapDialog.TYPE_DEFAULT, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
                draggable: true, // <-- Default value is false
                btnCancelLabel: 'Fechar', // <-- Default value is 'Cancel',
                btnOKLabel: 'Enviar', // <-- Default value is 'OK',
                btnOKClass: 'btn-success', // <-- If you didn't specify it, dialog type will be used,
                size: BootstrapDialog.SIZE_SMALL,
                 onshown: function(dialogRef){
	               
                       $('.modal-dialog').last().css('z-index',1301);
                },
                callback: function(result) {


                    if(result) {


                         $(this)._submit({
                             url : '<?php echo base_url('admin/orcamento/enviarEmail'); ?>',
                             data: { idOrcamento : idOrcamento, _submit : 'yeap', email: $('#emailEnviar').val()  },
                             callback: function(resp){

                                 if(!resp.status)
                                 {
                                     errorMsg(resp.msg);
                                 }
                                 else
                                 {
                                      successMsg('Email enviado corretamente!');      
                                 }

                             }

                         });  

                    }
                }
             });
    };
    
    
     $.fn.gerarMatricula = function(title,id){
        BootstrapDialog.confirm({
                title: title,
                message: 'Confirma a geração da matrícula e cadastro do aluno no sistema?',
                type: BootstrapDialog.TYPE_DEFAULT, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
                draggable: true, // <-- Default value is false
                btnCancelLabel: 'Cancelar', // <-- Default value is 'Cancel',
                btnOKLabel: 'Confirmar', // <-- Default value is 'OK',
                btnOKClass: 'btn-success', // <-- If you didn't specify it, dialog type will be used,
                size: BootstrapDialog.SIZE_SMALL,
                 onshown: function(dialogRef){
	               
                       $('.modal-dialog').last().css('z-index',1301);
                },
                callback: function(result) {


                    if(result) {


                         $(this)._submit({
                             url : '<?php echo base_url('admin/orcamento/gerarMatricula'); ?>',
                             data: { idOrcamento : id, _submit : 'yeap'  },
                             callback: function(resp){

                                 if(!resp.status)
                                 {
                                     errorMsg(resp.msg);
                                 }
                                 else
                                 {
                                     window.location.href = '<?php echo base_url('admin/onlinestudent/edit/'); ?>'+resp.msg;    
                                 }

                             }

                         });  

                    }
                }
             });
    };  
    
    
    
    
      $('#form-pesquisa-orcamentos').keypress(function(e) {
        if (e.which == '13') {
            e.preventDefault();
            $(this).buscarOrcamentos();
        }
	});
   

});
</script>