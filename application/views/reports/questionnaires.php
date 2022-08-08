<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>

<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
           <div class="col-md-12">
            <div class="box removeboxmius">
             <div class="box-header ptbnull"></div>
            <form id='feesforward' action="<?php echo site_url('report/questionnaires') ?>"  method="post" accept-charset="utf-8">

                        <div class="box-header with-border">

                            <h3 class="box-title"><i class="fa fa-search"></i> Relatório de Questionários</h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>

                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ($this->session->flashdata('msg')) {?>
                                        <?php echo $this->session->flashdata('msg') ?>
                                    <?php }?>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Direcionamento do Questionário *</small></label>
                                        

                                           <?php $role = $this->customlib->getUserData();


                                            if ($role['role_id'] == "2") { ?>

                                                    <select class="form-control" required name="quest_criteria" id="criteria_teacher">
                                                    <option default value="">Selecione uma Opção</option>
                                                    <option value="classes">Para Turmas (Alunos e Responsáveis)</option>
                                                </select>

                                            <?php } else { ?>
                                                <select class="form-control" required name="quest_criteria" id="criteria">
                                                    <option default value="">Selecione uma Opção</option>
                                                    <option value="classes">Para Turmas (Alunos e Responsáveis)</option>
                                                    <option value="teachers">Para Professores</option>
                                                </select>

                                            <?php  } ?>
                                      
                                        <span class="text-danger"><?php echo form_error('exam_id'); ?></span>
                                    </div>
                                </div>

                                <?php $role = $this->customlib->getUserData();


                                if ($role['role_id'] == "2") { ?>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Segmentação</label><small class="req"> *</small>
                                            <select class="form-control" required name="quest_segment" id="segment">                
                                            </select>
                                            <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                        </div>
                                    </div>                   

                                <?php } else { ?>

                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Segmentação</label><small class="req"> *</small>
                                            <select class="form-control" required name="quest_segment" id="segment">                
                                            </select>
                                            <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Horário da Turma</label><small class="req"> *</small>
                                            <select class="form-control" required name="quest_section" id="section">   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                        </div>
                                    </div>

                                <?php  } ?>
                                


                        <div class="col-sm-12">
                          <div class="form-group">
                            <button type="submit" name="action" value ="search" class="btn btn-primary pull-right btn-sm"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
if (isset($questionnaires)) {
    ?>
                        <div class="">
                            <div class="box-header ptbnull"></div>
                            <div class="box-header with-border">
                                <h3 class="box-title titlefix"> Lista de Respostas</h3>

                            </div>
                            <div class="box-body">
                                <div class="download_label">Lista de Respostas</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Questionário</th>
                                    
                                            <th>Data Publicação</th>
                                            <th>Data Resposta</th>
                                            <th>Status</th>
                                            <th><?php echo $this->lang->line('action') ?></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
if (empty($questionnaires)) {
        ?>

                                            <?php
} else {
        $count = 1;

        foreach ($questionnaires as $a) {
            //  print_r($student);

            ?>
                                                <tr>
                                               
                                                    <td>
                                                        <?php

                                                                                                                   
                                                        
                                                            if ($a->quest_student != 0) {
                                                            

                                                                    echo $this->student_model->get($a->quest_student)['firstname']." ".$this->student_model->get($a->quest_student)['lastname'];
                         
                                                            } else {

                                                                echo $this->staff_model->get($a->quest_teacher)['name']." ".$this->staff_model->get($a->quest_teacher)['surname'];
                                                            }
                                                        ?>

                                                
                                                    </td>
                                                    <td> <?=$this->question_model->getQuestionary($a->quest_id)['quest_title']?></td>
                                                 
                                                    <td> <?=$this->question_model->getQuestionary($a->quest_id)['quest_data']?></td>

                                                    <td><?=$a->quest_data?> - <?=$a->quest_time?></td>
                                                    <td><p style="text-transform: uppercase;font-size:10px;margin-top:5px;color:green" >respondida</p></td>
                                                    <td>
                                                        <button style="font-size: 12px;" type="button" data-placement="left" class="btn btn-default btn-xs btn-modal-answer-view " data-toggle="tooltip" id="load" data-recordid="<?=$a->quest_id?>" data-title="<?=$this->question_model->getQuestionary($a->quest_id)['quest_title']?>"  data-description="<?=$this->question_model->getQuestionary($a->quest_id)['quest_description']?>" data-observation="<?=$this->question_model->getQuestionary($a->quest_id)['quest_observation']?>" data-nome=" <?php

                                                                                                                   
                                                        
if ($a->quest_student != 0) {


        echo $this->student_model->get($a->quest_student)['firstname']." ".$this->student_model->get($a->quest_student)['lastname'];

} else {

    echo $this->staff_model->get($a->quest_teacher)['name']." ".$this->staff_model->get($a->quest_teacher)['surname'];
}
?>" data-data="<?=$a->quest_data?> - <?=$a->quest_time?>" data-user="<?=$a->quest_user?>"  title="Visualizar Questionário" > VISUALIZAR <i class="fa fa-arrow-right"></i></button>
                                                        
                                                        <button class="btn btn-default btn-xs " onclick="deleteQuestionaryCheck(<?=$a->id?>)"> <i class="fa fa-remove"></i></button>

                                                    </td>
                                                </tr>
                                                <?php
$count++;
        }
    }
    ?>
                                    </tbody>
                                </table>
                              </div>  
                            </div>

                        </div>
                        <?php
}
?>


            </form>
            </div>
           </div>
        </div>
    </section>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('exam') ?></h4>
            </div>

            <div class="modal-body">
                <div class="result_exam"></div>
            </div>

        </div>

    </div>
</div>



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
                <div class="row">
                    <div class="col-md-6">
                        <h5 style="text-transform:uppercase;font-weight:bold">NOME</h5>
                        <p id="quest_nome_view"></p>
                    </div>
                    <div class="col-md-6">
                        <h5 style="text-transform:uppercase;font-weight:bold">DATA RESPOSTA</h5>
                        <p id="quest_data_view"></p>
                    </div>
                </div>
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

                <form style="display:block" action="<?php echo site_url('admin/questionnaires/add_questionnaries'); ?>" method="POST" id="answer-form">

                    <div id="quest_ask_div_view">

                    </div>

                </form>
           </div>  
        </div>     
    </div>
</div>
<!-- Fim Modal Criar Perguntas View -->



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
                    $('#segment').html("")
                    $('#section').html("")
             

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
                    $('#segment').html("")
                    $('#section').html("")
                   

                    $('#segment').html("")
                    $('#segment').append("<option value='' >Selecione uma Opção</option>")
                    $('#segment').append(data)
                    
                }
            });

        }
    })



    $(document).on('change','#criteria_teacher', function(e) {

        var criteria = $(this).val()
        var base_url = '<?php echo base_url() ?>';

        if (criteria == "classes") {

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/getSectionsRelated",
                data:{teacher_id: <?=$role['id']?>},
                success: function (data) {
                    $('#segment').html("")
                    $('#section').html("")
            

                    $('#segment').html("")
                    $('#segment').append("<option value='' >Selecione uma Opção</option>")
                    $('#segment').append(data)
                    
                }
            });

        }

    
        })

</script>



<script>
     $(document).on('click', '.btn-modal-answer-view', function () {
        $('#quest_ask_div_view').html('  <center><div> <br><br><p><i class="fa fa-spinner"></i> Carregando Respostas...</p> </div></center> ')

            var recordid = $(this).data('recordid');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var observation = $(this).data('observation');
            var nome = $(this).data('nome');
            var data = $(this).data('data');
            var user = $(this).data('user');


            answerGetQuestionView(recordid, user)


            $('#titulo-modal-answer_view').text(title)
            $('#quest_data_view').text(data)

            $('#quest_nome_view').text(nome)
            $('#quest_description_view').text(description)
            $('#quest_observation_view').text(observation)

            // $('#answers-div').html("") 
         

            $('#MyModalAnswer_view').modal('show');

    });


    function answerGetQuestionView(quest_id, quest_user) {

            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/answerGetQuestionView",
                data:{quest_id:quest_id, quest_user:quest_user},
                success: function (data) {
                    // $('#quest_ask_div_view').html("") 
                    $('#quest_ask_div_view').html("") 

                    $('#quest_ask_div_view').append(data) 
                }
            });

    }
</script>


<script>


    function deleteQuestionaryCheck(id) {
      
        if (confirm("Deseja realmente excluir?") == true) {
        
            $.ajax({
                type: "POST",
                url: base_url + "admin/questionnaires/deleteQuestionaryCheck",
                data: {quest_id:id},

                success: function (data) {
                    location.reload()
                }
            });

        } else {

        }  
    
    }
</script>