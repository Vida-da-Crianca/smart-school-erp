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
                    <form role="form" action="<?php echo site_url('user/user/schedule') ?>" method="get" class="">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data Inicial</label>
                                <input class="form-control" name="date_start" type="date"
                                       value="<?= $this->input->get('date_start') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data Final</label>
                                <input class="form-control" name="date_end" type="date"
                                       value="<?= $this->input->get('date_end') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Aluno</label>
                                <input class="form-control" disabled readonly
                                       value="<?= $student['firstname'] ?> <?= $student['lastname'] ?>">
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
                <div class="row">
                    <?php foreach ($agendas as $item) : $item = (object)$item; ?>
                        <div class="col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><?= date('d/m/Y', strtotime($item->date)) ?></div>
                                <div class="panel-body">
                                    <?= $student['class'] ?> <?= $student['section'] ?><br>
                                    <?= $student['firstname'] ?> <?= $student['lastname'] ?>
                                </div>
                                <div class="panel-footer">
                                    <a href="<?= site_url(sprintf('user/user/scheduleShow/%s/%s', $item->id, $item->student)) ?>"
                                      style="width: 100%" class="btn btn-lg btn-success">Abrir Agenda</a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
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
