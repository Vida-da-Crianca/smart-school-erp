<style type="text/css">
    .wrapper {
        overflow: visible;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1><i class="fa fa-gears"></i> <?php echo $this->lang->line('billet_title'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">


            <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><i class="fa fa-calendar"></i> <?php echo $this->lang->line('billet_title'); ?></h3>
                        <div class="box-tools pull-right">

                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="">
                        <form role="form" id="schsetting_form" method="post" enctype="multipart/form-data">

                            <div class="box-body">

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12"><?php echo $this->lang->line('billet_date_start'); ?><small class="req"> *</small></label>
                                            <div class="col-sm-10 input-group date">
                                                <input type="text" class="form-control idate" id="name" name="start" value="<?php  ?>">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-12"><?php echo $this->lang->line('billet_date_end'); ?></label>
                                            <div class="col-sm-10 input-group date">
                                                <input type="text" class="form-control idate" id="date_end" name="end" value="<?php  ?>">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <?php
                                if ($this->rbac->hasPrivilege('billet_setting', 'can_edit')) :
                                ?>
                                    <button type="submit" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $this->lang->line('save'); ?></button>
                                <?php
                                endif;
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
    $(document).ready(function() {



        var $form = $("#schsetting_form");
        $.datepicker.regional['pt-BR'] = {
                    closeText: 'Fechar',
                    prevText: '&#x3c;Anterior',
                    nextText: 'Pr&oacute;ximo&#x3e;',
                    currentText: 'Hoje',
                    monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                    'Jul','Ago','Set','Out','Nov','Dez'],
                    dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                    dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                    weekHeader: 'Sm',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 0,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
            $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

        $(".date").datepicker({
            autoclose: true,
            todayHighlight: true,
        
          
        });
        $form.validate({

            rules: {
                start: {
                    date: true,
                    required: true
                },
                end: {
                    date: true,
                    required: true
                }
            }
        })


        $(".date").rules('remove', 'date')

        $form.on('submit', function(e) {
            var $this = $(this);
            e.preventDefault();
            if (!$form.valid()) return;


            // $el = $this.find('.box-footer button')
            // $el.button('loading');
            // $.ajax({
            //     url: `${site_url}/billet/onSave`,
            //     type: 'POST',
            //     data: $this.serialize(),
            //     dataType: 'json',
            //     complete: function(data) {
            //         $el.button('reset');
            //     }
            // });
        });

    })
</script>