<div class="content-wrapper">

    <section class="content">
        <div class="box box-primary">
            <div class="box-header" style="width: 100%;  display: flex; justify-content: space-between;">
                <div style="flex: 1;"><h3
                            class="box-title titlefix text-left"> <?php echo $this->lang->line('schedule_collection_list'); ?> </h3>
                </div>
                <div class="loader-i text-right">

                </div>

                <!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="row" style="margin-bottom: 10px;">
                    <form role="form" action="<?php echo site_url('admin/schedule') ?>" method="get" class="">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Data Inicial</label>
                                <input class="form-control" name="date_start" type="date" value="<?=$this->input->get('date_start')?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Data Final</label>
                                <input class="form-control" name="date_end" type="date" value="<?=$this->input->get('date_end')?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Turma</label> <small class="req"> *</small>
                                <select autofocus="" id="class_id" required name="class_id" class="form-control"
                                        autocomplete="off">
                                    <?php
                                    foreach ($classes as $key=>$class) {
                                        ?>
                                        <option <?=$this->input->get('class_id') == $class['class_id'] ? 'selected' : ''?>  value="<?= $class['class_id'] ?>"><?= $class['class'] ?>
                                            - <?= $class['section'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome do Aluno</label>
                                <select autofocus="" id="student_id" name="student_id" class="form-control"
                                        autocomplete="off">
                                    <option value=""></option>
                                    <?php
                                    foreach ($students as $student) {
                                        ?>
                                        <option <?=$this->input->get('student_id') == $student['id'] ? 'selected' : ''?>  value="<?= $student['id'] ?>">
                                            <?= $student['firstname']?> <?= $student['lastname']?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de Refeição</label> <small class="req"> *</small>
                                <select required autofocus="" id="snack_id" name="snack_id" class="form-control select2"
                                        autocomplete="off">
                                    <?php
                                    foreach ($snacks as $snack) {
                                        ?>
                                        <option <?=$this->input->get('snack_id') == $snack->id ? 'selected' : ''?>  value="<?= $snack->id ?>"><?= $snack->name?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" name="search" value="search_filter"
                                        class="btn btn-primary btn-sm pull-right checkbox-toggle"><i
                                            class="fa fa-search"></i> Pesquisa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive mailbox-messages">
                    <div class="download_label">
                        <?php echo $this->lang->line('snack_generate_collection_list'); ?>
                    </div>
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Tipo Refeição</th>
                            <th>Aluno</th>
                            </th>
                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($agendas as $item) :  $item = (object) $item;?>
                            <tr>
                                <td><?= $item->id ?></td>
                                <td><?= date('d/m/Y', strtotime($item->date)) ?></td>
                                <td><?= $item->snack ?></td>
                                <td><?= $item->firstname ?> <?= $item->lastname ?></td>
                                <td class="text-right border  t-actions" style="width: 100px; text-align: right;">

                                    <!-- <a href="#" data-id="<?= $item->id ?>" on-trigger-click="preview">
                                 <i class="fa fa-file"></i>
                              </a>
                              &nbsp; -->
                                    <a href="<?= site_url(sprintf('admin/schedule/view/%s/%s', $item->id, $item->student)) ?>">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


</div>


<style>
    .t-actions a {
        display: inline-block;
        color: #334;
        size: 1.2rem;
    }
</style>


<script>
    $(document).ready(function () {
        var isAjax = false

        $('[on-trigger-click]').on('click.TriggerClick', function (e) {
            e.preventDefault();
            if (isAjax) return;

            var type = $(this).attr('on-trigger-click'),
                id = $(this).data('id')

            switch (type) {
                case 'delete': {
                    onDelete(id);
                }
            }
        });


        function onDelete(id) {

            if (!confirm('Deseja realizar essa operação ?')) return;
            isAjax = true
            $('.loader-i').html('<i class="fa fa-circle-o-notch fa-spin"></i> Processando...')
            $.ajax({
                url: `<?= site_url('/admin/snack/delete/') ?>${id}`,
                method: 'delete',
                dataType: 'json',
                success: function (e) {
                    window.location.reload();
                },
                complete: function () {
                    $('.loader-i').html('')
                    isAjax = false
                }
            })
        }

    })
</script>