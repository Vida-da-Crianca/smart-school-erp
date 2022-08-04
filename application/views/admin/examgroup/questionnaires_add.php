<style type="text/css">
    .loading-overlay {
    display: none;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    background: rgba(255,255,255,0.7);
}
.overlay-content {
    position: absolute;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    top: 50%;
    left: 0;
    right: 0;
    text-align: center;
    color: #555;
}
.div_load{position: relative;}

</style>
<script src="<?php echo base_url(); ?>backend/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>backend/js/ckeditor_config.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-bus"></i> <?php echo $this->lang->line('question'); ?></h1>
    </section>
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary" id="route">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Gerenciar Questionários</h3>
                      
                        <button class="btn btn-primary btn-sm pull-right question-btn" data-recordid="0"><i class="fa fa-plus"></i> Novo Questionário</button>
                           

                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="mailbox-messages table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('question') . " " . $this->lang->line('bank'); ?></div>
                            <!-- <textarea class="form-control question" id="question" name="question"></textarea> -->
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Direcionamento</th>
                                        <th>Data Publicação</th>
                                        <th>Status</th>
                                        <th>Respostas</th>
                                        <th>Perguntas</th>
                                        <th class="pull-right no-print">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->question_model->getQuestionnaires() as $q) { ?>
                                        <tr>
                                            <td class="mailbox-name"> <?=$q->quest_title?></td>
                                            <td class="mailbox-name" style="text-transform: uppercase;font-size:10px"> <?php if ($q->quest_criteria == "teachers") {echo " Professores";} else if ($q->quest_criteria == "classes") {echo " Turmas";} else if ($q->quest_criteria == "all") { echo " Todos";} ?></td>
                                            <td class="mailbox-name"> 
                                                

                                                <?php if ($q->quest_status == "1") { ?>
                                                    <?=$q->quest_data?> - <?=$q->quest_time?>
                                                <?php } else { ?>
                                                        -
                                                <?php }?>
                                            
                                            </td>
                                            <td class="mailbox-name">
                                                <?php if ($q->quest_status == "1") { ?>
                                                    <p style="text-transform: uppercase;font-size:10px;margin-top:5px;color:green" >PUBLICADO</p>

                                                <?php } else { ?>
                                                    <p style="text-transform: uppercase;font-size:10px;margin-top:5px;color:orange" >RASCUNHO</p>

                                                <?php }?>
                                            </td>
                                            <td class="mailbox-name"> 
                                                <center>
                                                    <button type="button" data-placement="left" class="btn btn-default btn-xs btn-modal-respostas" data-toggle="tooltip" id="load" data-recordid="<?=$q->id?>" data-title="<?=$q->quest_title?>" title="Criar Respostas"  ><i class="fa fa-pencil"></i></button>
                                                </center>
                                            </td>
                                            <td class="mailbox-name "> 
                                                <center>
                                                    <button type="button" data-placement="left" class="btn btn-default btn-xs btn-modal-perguntas" data-toggle="tooltip" id="load" data-recordid="<?=$q->id?>" data-title="<?=$q->quest_title?>" title="Criar Perguntas"  ><i class="fa fa-pencil"></i></button>
                                                </center>
                                            </td>
                                            <td class="pull-right">

                                                <button type="button" data-placement="right" title="Editar" class="btn btn-default btn-xs btn-modal-edit" data-toggle="tooltip"  id="load" data-recordid="<?=$q->id?>" data-title="<?=$q->quest_title?>"  data-observation="<?=$q->quest_observation?>"   data-description="<?=$q->quest_description?>"><i class="fa fa-pencil"></i></button>
                                        
                                                <button class="btn btn-default btn-xs " data-toggle="tooltip" title="Excluir" onclick="deleteQuestionary(<?=$q->id?>)"> <i class="fa fa-remove"></i></button>

                                                <button type="button" data-placement="left" class="btn btn-default btn-xs" onclick="Duplicar(<?=$q->id?>)"  data-toggle="tooltip" id="load" data-recordid="<?=$q->id?>" title="Duplicar"  ><i class="fa fa-files-o"></i></button>

                                          
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</div>



<!-- Inicio Modal Criar Questionarios -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Novo Questionário</h4>
            </div>
           <div class="modal-body">
                <form style="display:block" action="<?php echo site_url('admin/questionnaires/add_questionnaries'); ?>" method="POST" id="formsubject">
                <div class="row">
                    <div class="col-md-6"  >
                        <label for="">Status</label>
                        <select class="form-control" name="quest_status" id="">
                            <option value="1">Publicar</option>
                            <option value="0">Rascunho</option>
                        </select><br>

                        <label for="">Título do Questionário</label>
                        <input  class="form-control" type="text" maxlength="1000" style="padding-top:3px" required name="quest_title"><br>
                        <label for="">Descrição do Questionário</label>
                        <textarea class="form-control"name="quest_description"  style="padding-top:8px" required maxlength="1000" id="" cols="30" rows="5"></textarea><br>
                        <label for="">Observações (opcional)</label>
                        <textarea class="form-control" name="quest_observation"  style="padding-top:8px"  maxlength="1000" id="" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 ml-2" >
                        <label for="">Direcionamento do Questionário</label>
                            <select class="form-control" required name="quest_criteria" id="criteria">
                                <option default value="">Selecione uma Opção</option>
                                <option value="classes">Para Turmas (Alunos e Responsáveis)</option>
                                <option value="teachers">Para Professores</option>
                            </select>
                        <br>
                        <div id="segment-div" style="display:none;">
                            <label for="">Segmentação</label>                        
                            <select class="form-control" required name="quest_segment" id="segment">                
                            </select>
                        </div>
                        <br>
                        <div id="section-div" style="display:none;">
                            <label for="">Horário da Turma</label>                        
                            <select class="form-control" required name="quest_section" id="section">   
                            </select>
                        </div>
                        <br>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div>
                    <button class="btn btn-primary  btn-lg " type="submit">Criar Questionário</button>
                </div>
                </form>
           </div> 
        </div>      
    </div>
</div>
<!-- Fim Modal Criar Questionarios -->





<!-- Inicio Modal Editar Questionarios -->
<div id="modal-edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title-update"></h4>
            </div>
           <div class="modal-body">
           <form style="display:block" action="<?php echo site_url('admin/questionnaires/add_questionnaries'); ?>" method="POST" id="formupdate">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <input type="hidden" name="quest_id" id="quest_id_update" required>
                        <label for="">Direcionamento</label>
                        <p id="direcionamento-update"></p>
                        <label for="">Status</label>
                        <select class="form-control" name="quest_status" id="">
                            <option value="1">Publicar</option>
                            <option value="0">Rascunho</option>
                        </select><br>

                        <label for="">Título do Questionário</label>
                        <input  class="form-control" type="text" maxlength="1000" style="padding-top:3px" required name="quest_title" id="quest_title_update"><br>
                        <label for="">Descrição do Questionário</label>
                        <textarea class="form-control"name="quest_description" id="quest_description_update"  style="padding-top:8px" required maxlength="1000" id="" cols="30" rows="5"></textarea><br>
                        <label for="">Observações (opcional)</label>
                        <textarea class="form-control" name="quest_observation" id="quest_observation_update"   style="padding-top:8px"  maxlength="1000" id="" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md-1"></div>

                  
                </div>
               <br>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    <button class="btn btn-primary  btn-lg " type="submit">Atualizar Questionário</button>

                    </div>
                    <div class="col-md-1"></div>
                </div>
               
                
                </form>
           </div> 
        </div>      
    </div>
</div>
<!-- Fim Modal Editar Questionarios -->



<!-- Inicio Modal Criar Respostas -->
<div id="MyModalRespostas" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="titulo-modal-respostas"></h4>
            </div>
           <div class="modal-body">
                <form style="display:block" action="<?php echo site_url('admin/questionnaires/add_questionnaries'); ?>" method="POST" id="addanswer-form">
                <div class="row">
                    <div class="col-md-6">

                        <input type="hidden" name="quest_id" id="quest_id" > 
                        
                        <label for="">Insira a Opção de Resposta</label>
                        <textarea class="form-control" name="quest_answer_title" id="quest_answer_title" style="padding-top: 12px" required maxlength="200" id="" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 ml-2 " >
                        <br>
                        <button class="btn btn-primary  btn-lg " style="margin-top: 5px;height:70px" type="submit"><i class="fa fa-plus"></i></button>

                    </div>
                </div>
           
                <hr>
                <h4>Lista de Respostas</h4>
                    <div style="width: 70%;" id="answers-div">
                       
                              
                        
                    </div>        
                </form>
           </div>  
        </div>     
    </div>
</div>
<!-- Fim Modal Criar Respostas -->


<!-- Inicio Modal Criar Perguntas -->
<div id="MyModalPerguntas" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="titulo-modal-perguntas"></h4>
            </div>
           <div class="modal-body">
                <form style="display:block" action="<?php echo site_url('admin/questionnaires/add_questionnaries'); ?>" method="POST" id="addasks-form">
                <div class="row">
                    <div class="col-md-9">

                        <input type="hidden" name="quest_id" id="quest_id_ask" > 
                        
                        <label for="">Insira a Pergunta</label>
                        <textarea class="form-control" name="quest_ask_title" id="quest_ask_title" style="padding-top: 12px" required maxlength="1000" id="" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md-3 ml-2 " >
                        <br>
                        <button class="btn btn-primary  btn-lg " style="margin-top: 5px;height:70px" type="submit"><i class="fa fa-plus"></i></button>

                    </div>
                </div>
           
                <hr>
                <h4>Lista de Perguntas</h4>
                    <div style="width: 80%;" id="asks-div">
                       
                              
                        
                    </div>        
                </form>
           </div>  
        </div>     
    </div>
</div>
<!-- Fim Modal Criar Perguntas -->









<script type="text/javascript">


        $("form#addasks-form").submit(function (e) {

            e.preventDefault(); 
            var base_url = '<?php echo base_url() ?>';

            $.ajax({
                type: "POST",
                url: base_url+'admin/questionnaires/addasks',
                data: $(this).serialize(),
                success: function (data)
                {
                    $('#quest_ask_title').val('')
                    getAsks()

                },
                error: function (xhr) { 
                    alert("Error occured.please try again");

                }
            });

        });
        
        $("form#addanswer-form").submit(function (e) {

            e.preventDefault(); 
            var base_url = '<?php echo base_url() ?>';

            $.ajax({
                type: "POST",
                url: base_url+'admin/questionnaires/addanswers',
                data: $(this).serialize(),
                success: function (data)
                {
                    $('#quest_answer_title').val('')
                    getAnswers()

                },
                error: function (xhr) { 
                    alert("Error occured.please try again");

                }
            
            });


    });
    
    $("form#formsubject").submit(function (e) {

        e.preventDefault(); 
        var form = $(this);
        var url = form.attr('action');
        var submit_button = form.find(':submit');
        var post_params = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            beforeSend: function () {
                $("[class$='_error']").html("");
                submit_button.button('loading');
            },
            success: function (data)
            {
                    location.reload();

            },
            error: function (xhr) { 
                alert("Error occured.please try again");

            },
            complete: function () {
                submit_button.button('reset');
            }
        });


    });



    $("form#formupdate").submit(function (e) {

        e.preventDefault(); 
        var base_url = '<?php echo base_url() ?>';


        $.ajax({
            type: "POST",
            url: base_url+'admin/questionnaires/updateQuestionary',
            data: $(this).serialize(),
         
            success: function (data)
            {
                    location.reload();

            },
            error: function (xhr) { 
                alert("Error occured.please try again");

            },
         
        });


    });

</script>


<script>

    $(document).on('change','#segment', function (e) {
        var criteria = $('#criteria').val()
        var segment = $('#segment').val()

        var class_id = $(this).val()

        if (criteria == "classes") {

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getSections",
                data: {class_id:class_id},
                success: function (data) {
                    $('#section-div').css('display','block')

                    $('#section').html("")
                    $('#section').append("<option value='' >Selecione uma Opção</option>")
                    $('#section').append(data)
                    
                }
            });

        } else if (criteria == "teachers") {
          
            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getSectionsRelated",
                data: {teacher_id:segment},
                success: function (data) {
                    $('#section-div').css('display','block')

                    $('#section').html("")
                    $('#section').append("<option value='' >Selecione uma Opção</option>")
                    $('#section').append(data)
                    
                }
            });
        }
        
       

    })

    $(document).on('change','#criteria', function(e) {

        var criteria = $(this).val()
        var base_url = '<?php echo base_url() ?>';

        if (criteria == "classes") {

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getClasses",
                success: function (data) {
                    $('#segment-div').css('display','none')
                    $('#section-div').css('display','none')
                    $('#segment-div').css('display','block')

                    $('#segment').html("")
                    $('#segment').append("<option value='' >Selecione uma Opção</option>")
                    $('#segment').append(data)
                    
                }
            });

        } else if (criteria == "teachers") {

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getTeachers",
                success: function (data) {
                    $('#segment-div').css('display','none')
                    $('#section-div').css('display','none')
                    $('#segment-div').css('display','block')

                    $('#segment').html("")
                    $('#segment').append("<option value='' >Selecione uma Opção</option>")
                    $('#segment').append(data)
                    
                }
            });

        } else if (criteria == "all") {
            $('#segment-div').css('display','none')
            $('#section-div').css('display','none')



        }
    })


</script>


<script>

    // Open Modal Criar Questionarios
    $(document).on('click', '.question-btn', function () {
            var recordid = $(this).data('recordid');
            $('input[name=recordid]').val(recordid);
            $('#myModal').modal('show');

    });
    // Open Modal Criar Questionarios

    // Open Modal Criar Respostas
    $(document).on('click', '.btn-modal-respostas', function () {
            var recordid = $(this).data('recordid');
            var title = $(this).data('title');


            $('#answers-div').html('  <center><div> <p><i class="fa fa-spinner"></i> Carregando Respostas...</p> </div></center> ')
           

            $('#titulo-modal-respostas').text(title)
            $('#quest_id').val(recordid)

            // $('#answers-div').html("") 
            getAnswers()

            $('#MyModalRespostas').modal('show');

    });
    // Open Modal Criar Respostas

     // Open Modal Criar Perguntas
     $(document).on('click', '.btn-modal-perguntas', function () {
            var recordid = $(this).data('recordid');
            var title = $(this).data('title');


            $('#asks-div').html('  <center><div> <p><i class="fa fa-spinner"></i> Carregando Perguntas...</p> </div></center> ')
           

            $('#titulo-modal-perguntas').text(title)
            $('#quest_id_ask').val(recordid)

            // $('#answers-div').html("") 
            getAsks()

            $('#MyModalPerguntas').modal('show');

    });
    // Open Modal Criar Perguntas

    
     // Open Modal Editar Perguntas
     $(document).on('click', '.btn-modal-edit', function () {

            var recordid = $(this).data('recordid');
            var title = $(this).data('title')
            var description = $(this).data('description')
            var observation = $(this).data('observation')

            // var title = $(this).data('title');


            // $('#asks-div').html('  <center><div> <p><i class="fa fa-spinner"></i> Titu Perguntas...</p> </div></center> ')
           

            $('.modal-title-update').text(title)
            $('#quest_title_update').val(title)
            $('#quest_description_update').val(description)
            $('#quest_observation_update').val(observation)
            $('#quest_id_update').val(recordid)

            // $('#quest_id_ask').val(recordid)

            // getAsks()

            $('#modal-edit').modal('show');

    });
    // Open Modal Editar Perguntas


    // function addAnswers(id) {
    //     // openAnswerModal()
    //     // $('#btn-modal-respostas').click()
    //     // $('#MyModal').modal('show');


    // }

    
</script>


                                                       


<!-- Actions -->
<script>
    function deleteQuestionary(id) {
        if (confirm("Deseja realmente excluir?") == true) {
        
            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/deleteQuestionary",
                data: {quest_id:id},

                success: function (data) {
                    location.reload()
                }
            });

        } else {

        }  
    }


    // Inicio Aciton Respostas
    function getAnswers() {

        var quest_id = $('#quest_id').val()

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getAnswers",
                data:{quest_id:quest_id},
                success: function (data) {
                    $('#answers-div').html("") 
                    $('#answers-div').append(data) 
                }
            });
    }



    function deleteAnswers(id) {
        if (confirm("Deseja realmente excluir?") == true) {
        
            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/deleteanswers",
                data: {answer_id:id},

                success: function (data) {
                    getAnswers() 
                }
            });

        } else {

        }  

    }


    // Fim Action Respotas


    // Inicio Action Perguntas

    function getAsks() {

        var quest_id = $('#quest_id_ask').val()

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getAsks",
                data:{quest_id:quest_id},
                success: function (data) {
                    $('#asks-div').html("") 
                    $('#asks-div').append(data) 
                }
            });
        }



        function deleteAsks(id) {
        if (confirm("Deseja realmente excluir?") == true) {

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/deleteAsks",
                data: {ask_id:id},

                success: function (data) {
                    getAsks() 
                }
            });

        } else {

        }  

        }


    

    function Duplicar(id) {

        $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/duplicar",
                data: {quest_id:id},

                success: function (data) {
                    location.reload()
                }
            });
      
    }
</script>