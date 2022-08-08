
<?php

$student_data = $student;

?>

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
                        <h3 class="box-title titlefix">Lista de Questionários</h3>
                      
                        <!-- <button class="btn btn-primary btn-sm pull-right question-btn" data-recordid="0"><i class="fa fa-plus"></i> Novo Questionário</button> -->
                           

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
                                        <th>Data Resposta</th>
                                        <th>Status</th>
                                        
                                        <th class="pull-right no-print">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($questionnaires as $q) { ?>
                                        <tr>
                                            <td class="mailbox-name"> <?=$q->quest_title?></td>
                                            <td class="mailbox-name" > 
                                                <p style="text-transform: uppercase;font-size:10px;margin-top:5px">
                                                <?php if ($q->quest_criteria == "teachers") {echo " Professores";} else if ($q->quest_criteria == "classes") {echo " Turmas";} else if ($q->quest_criteria == "all") { echo " Todos";} ?>
                                                </p>
                                            </td>
                                            <td class="mailbox-name"> <?=$q->quest_data?></td>

                                            <td class="mailbox-name"> 
                                                
                                                    <?php if ($this->question_model->user_answer_check($q->id, $student_data['id'])) {  ?>
                                                        <?php $info = $this->question_model->user_answer_check($q->id, $student_data['id'])?>
                                                        <p  ><?=$info['quest_data']?> - <?=$info['quest_time']?></p>

                                                    <?php } else { ?>
                                                        <p  >-</p>

                                                    <?php } ?>
                                            </td>

                                            <td class="mailbox-name"> 

                                                    <?php if ($this->question_model->user_answer_check($q->id, $student_data['id'])) {  ?>
                                                        <p style="text-transform: uppercase;font-size:10px;margin-top:5px;color:green" >respondida</p>

                                                    <?php } else { ?>
                                                        <p style="text-transform: uppercase;font-size:10px;margin-top:5px;color:red" >Pendente</p>

                                                    <?php } ?>
                                               
                                                
                                            </td>
                                          
                                            <td class="pull-right">

                                                    <?php if ($this->question_model->user_answer_check($q->id, $student_data['id'])) {  ?>

                                                        <button style="font-size: 12px;" type="button" data-placement="left" class="btn btn-default btn-xs btn-modal-answer-view " data-toggle="tooltip" id="load" data-recordid="<?=$q->id?>" data-title="<?=$q->quest_title?>" data-description="<?=$q->quest_description?>" data-observation="<?=$q->quest_observation?>" title="Visualizar Questionário" > VISUALIZAR <i class="fa fa-arrow-right"></i></button>

                                                    <?php } else { ?>

                                                        <button style="font-size: 12px;" type="button" data-placement="left" class="btn btn-default btn-xs btn-modal-answer " data-toggle="tooltip" id="load" data-recordid="<?=$q->id?>" data-title="<?=$q->quest_title?>" data-description="<?=$q->quest_description?>" data-observation="<?=$q->quest_observation?>"  data-segment="<?=$q->quest_segment?>" data-section="<?=$q->quest_section?>" data-criteria="<?=$q->quest_criteria?>" data-teacher="<?=$q->quest_teacher?>" title="Responder Questionário" > RESPONDER <i class="fa fa-arrow-right"></i></button>

                                                    <?php } ?>
                                        
                                          
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




<!-- Inicio Modal Criar Perguntas -->
<div id="MyModalAnswer" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="titulo-modal-answer"></h4>
            </div>
           <div class="modal-body">
                <div>
                    <h5 style="text-transform:uppercase;font-weight:bold">Descrição</h5>
                    <p id="quest_description"></p>
                </div>
          
                <div>
                    <h5 style="text-transform:uppercase;font-weight:bold">OBSERVAÇÕES</h5>
                    <p id="quest_observation"></p>
                </div>
                <br>
                <div>
                    <h5 style="text-transform:uppercase;font-weight:bold">RESPONDA AS PERGUNTAS ABAIXO :</h5>
                </div>
                <div class="row"  style="border-bottom:1px solid #555 ;">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3">
                        <h5 style="text-transform:uppercase;text-align:center">RESPOSTAS</h5>
                    </div>
                </div>

                <form style="display:block" action="" method="POST" id="answer-form">

                    <div id="quest_ask_div">

                    </div>
                    <input type="hidden" name="quest_id" id="quest_id" > 

                    <input type="hidden" name="quest_criteria" id="quest_criteria" > 
                    <input type="hidden" name="quest_segment" id="quest_segment" > 
                    <input type="hidden" name="quest_section" id="quest_section" > 
                    <input type="hidden" name="quest_teacher" id="quest_teacher" > 
                    <input type="hidden" name="quest_student" id="quest_student" value="<?=$student_data['id']?>" > 



                    <div style="margin-bottom: 59px">
                        <br>
                        <button class="btn btn-primary pull-right  btn-lg " type="submit">Enviar Questionário</button>

                    </div>
               
                </form>
           </div>  
        </div>     
    </div>
</div>
<!-- Fim Modal Criar Perguntas -->




<!-- Inicio Modal Criar Perguntas View -->
<div id="MyModalAnswer_view" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="titulo-modal-answer_view"></h4>
            </div>
           <div class="modal-body">
                <div>
                    <h5 style="text-transform:uppercase;font-weight:bold">Descrição</h5>
                    <p id="quest_description_view"></p>
                </div>
          
                <div>
                    <h5 style="text-transform:uppercase;font-weight:bold">OBSERVAÇÕES</h5>
                    <p id="quest_observation_view"></p>
                </div>
                <br>
                <div>
                    <h5 style="text-transform:uppercase;font-weight:bold">RESPONDA AS PERGUNTAS ABAIXO :</h5>
                </div>
                <div class="row"  style="border-bottom:1px solid #555 ;">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3">
                        <h5 style="text-transform:uppercase;text-align:center">RESPOSTAS</h5>
                    </div>
                </div>

                <form style="display:block" action="" method="POST" id="answer-form">

                    <div id="quest_ask_div_view">

                    </div>

                </form>
           </div>  
        </div>     
    </div>
</div>
<!-- Fim Modal Criar Perguntas View -->





<!-- Form -->
<script>

    $("form#answer-form").submit(function (e) {

        e.preventDefault(); 
        var base_url = '<?php echo base_url() ?>';

        $.ajax({
            type: "POST",
            url: base_url+'user/exam/answerAddAnswerUser',
            data: $(this).serialize(),
            success: function (data)
            {
                location.reload()
            },
            error: function (xhr) { 
                alert("Error occured.please try again");

            }
        });

    });
</script>
<!-- Form -->


<!-- Open -->
<script>
     var base_url = '<?php echo base_url() ?>';

     $(document).on('click', '.btn-modal-answer', function () {

             $('#quest_ask_div').html('  <center><div> <br><br><p><i class="fa fa-spinner"></i> Carregando Perguntas...</p> </div></center> ')

            var recordid = $(this).data('recordid');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var observation = $(this).data('observation');

            var criteria =  $(this).data('criteria');
            var segment =  $(this).data('segment');
            var section =  $(this).data('section');
            var teacher =  $(this).data('teacher');

            answerGetQuestion(recordid)


            $('#titulo-modal-answer').text(title)
            $('#quest_description').text(description)
            $('#quest_observation').text(observation)

            $('#quest_criteria').val(criteria)
            $('#quest_segment').val(segment)
            $('#quest_section').val(section)
            $('#quest_teacher').val(teacher)



            $('#quest_id').val(recordid)

            // $('#answers-div').html("") 
         

            $('#MyModalAnswer').modal('show');

    });


    $(document).on('click', '.btn-modal-answer-view', function () {
        $('#quest_ask_div_view').html('  <center><div> <br><br><p><i class="fa fa-spinner"></i> Carregando Respostas...</p> </div></center> ')

            var recordid = $(this).data('recordid');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var observation = $(this).data('observation');

            answerGetQuestionView(recordid)


            $('#titulo-modal-answer_view').text(title)
            $('#quest_description_view').text(description)
            $('#quest_observation_view').text(observation)

            // $('#answers-div').html("") 
         

            $('#MyModalAnswer_view').modal('show');

    });

</script>
<!-- Open -->

<!-- Action -->
<script>

    function answerGetQuestion(quest_id) {

        $.ajax({
                type: "POST",
                url: base_url + "user/exam/answerGetQuestion",
                data:{quest_id:quest_id},
                success: function (data) {

                    $('#quest_ask_div').html("") 
                    $('#quest_ask_div').append(data) 

                }
            });

    }

    function answerGetQuestionView(quest_id) {

        $.ajax({
                type: "POST",
                url: base_url + "user/exam/answerGetQuestionView",
                data:{quest_id:quest_id},
                success: function (data) {
                    // $('#quest_ask_div_view').html("") 
                    $('#quest_ask_div_view').html("") 

                    $('#quest_ask_div_view').append(data) 
                }
            });

    }

</script>
<!-- Action -->