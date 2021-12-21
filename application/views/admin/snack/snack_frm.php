<div class="content-wrapper">

    <section class="content">
        <div class="box box-primary">
            <div class="box-header ptbnull">
                <h3 class="box-title titlefix"> <?php echo isset($snack->id) ? $this->lang->line('snack_frm_update') : $this->lang->line('snack_frm_create'); ?></h3>
                <div class="box-tools pull-right">
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="snack" method="post"
                      action="<?php echo isset($snack->id) ? site_url('admin/snack/update/' . $snack->id) : site_url('admin/snack/store') ?>">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 text-danger display-errors">
                            <!-- <?php echo validation_errors(); ?> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="snack_name"><?php echo $this->lang->line('snack_name'); ?> *</label>
                                <?= form_input('name', set_value('name', $snack->name ?? ''), 'class="form-control" '); ?>
                            </div>
                        </div>

                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label>Tipo</label><br>
                                <?php
                                foreach (Snack_model::$tipos as $key => $item) {
                                    $selected = !$snack->code && $key == 'alimentacao' ? 'checked' : '';
                                    $selected = $key == $snack->code ? 'checked' : $selected;
                                    ?>
                                    <label class="radio-inline">
                                        <input <?= $selected ?> type="radio" name="code"
                                                                                             value="<?= $key ?>"> <?= $item ?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-10 col-md-offset-1 text-right">


                            <div class="form-group ">
                                <span class="loading-container"></span>
                                <button type="submit" class="btn btn-primary">
                                    Salvar dados
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>


</div>