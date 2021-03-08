<style type="text/css">
    .wrapper {
        overflow: visible;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1><i class="fa fa-gears"></i> <?php echo $this->lang->line('invoice_settings'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">


            <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><i class="fa fa-gear"></i> <?php echo $this->lang->line('invoice_general_settings'); ?></h3>
                        <div class="box-tools pull-right">

                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="">
                        <form role="form" id="schsetting_form" method="post" enctype="multipart/form-data">

                            <div class="box-body">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_school_name'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo search_key_in($result, 'name'); ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_document'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="document" name="document" value="<?php echo search_key_in($result, 'document'); ?>">
                                                <span class="text-danger"><?php echo form_error('document'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_phone'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo search_key_in($result, 'phone'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_ccm'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="invoice_ccm" name="ccm" value="<?php echo search_key_in($result, 'ccm'); ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_crc'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="invoice_crc" name="crc" value="<?php echo search_key_in($result, 'crc'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_crc_state'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-2">
                                                <input type="text" maxlength="2" class="form-control" id="crc_state" name="crc_state" value="<?php echo search_key_in($result, 'crc_state'); ?>">
                                                <span class="text-danger"><?php echo form_error('crc_state'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="settinghr"></div>
                                        <h4 class="session-head">Acessos</h4>
                                    </div>
                                    <!--./col-md-12-->
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_password'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="password" name="password" value="<?php echo search_key_in($result, 'password'); ?>">
                                                <span class="text-danger"><?php echo form_error('password'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-6"><?php echo $this->lang->line('invoice_serie'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="serie" name="serie" value="<?php echo search_key_in($result, 'serie'); ?>">
                                                <span class="text-danger"><?php echo form_error('serie'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="settinghr"></div>
                                        <h4 class="session-head">Serviços</h4>
                                    </div>
                                    <!--./col-md-12-->
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-7"><?php echo $this->lang->line('invoice_code_service'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="code_service" name="code_service" value="<?php echo search_key_in($result, 'code_service'); ?>">
                                                <span class="text-danger"><?php echo form_error('code_service'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_simple_rate'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="rate" name="simple_rate" value="<?php echo search_key_in($result, 'simple_rate'); ?>">
                                                <span class="text-danger"><?php echo form_error('simple_rate'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_iss'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="rate" name="simple_rate" value="<?php echo search_key_in($result, 'simple_rate'); ?>">
                                                <span class="text-danger"><?php echo form_error('simple_rate'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4"><?php echo $this->lang->line('invoice_condition'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="condition" name="condition" value="<?php echo search_key_in($result, 'condition'); ?>">
                                                <span class="text-danger"><?php echo form_error('condition'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <?php
                                if ($this->rbac->hasPrivilege('invoice_setting', 'can_edit')) {
                                ?>
                                    <button type="submit" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $this->lang->line('save'); ?></button>
                                <?php
                                }
                                ?>


                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div>
            <!--/.col (left) -->
            <!-- right column -->

        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<script type="text/javascript">
    var site_url = '<?php echo site_url(); ?>';
    var $form = $("#schsetting_form");
    $form.validate({

        rules: {
            name: {
                required: true
            },
            document: {
                required: true,
                number: true
            },
            phone: {
                required: true,
                number: true
            },
            ccm: {
                required: true,
                // number: true
            },
            crc: {
                required: true,
                // number: true
            },
            crc_state: {
                required: true,
               
            },
            password: {
                required: true,
                
            },
            simple_rate: {
                required: true,
               
            },
            condition: {
                required: true,
                
            },
            serie: {
                required: true,
                
            },
            code_service: {
                required: true,
                
            }
        }
    })

    $form.on('submit', function(e) {
        var $this = $(this);
        e.preventDefault();
        if (!$form.valid()) return;


        $el = $this.find('.box-footer button')
        $el.button('loading');
        $.ajax({
            url: `${site_url}/invoices/onSave`,
            type: 'POST',
            data: $this.serialize(),
            dataType: 'json',
            complete: function(data) {
                $el.button('reset');
            }
        });
    });
</script>