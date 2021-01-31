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


            <div class="col-xs-12">
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

                                <div class="row d-flex align-items-center border">
                                    <div class="col-md-4 form-group">
                                        <label><?php echo $this->lang->line('billet_date_start'); ?><small class="req"> *</small></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control idate" id="name" name="start" value="<?php
                                                                                                                        echo (new DateTime())->format('01/m/Y');
                                                                                                                        ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><?php echo $this->lang->line('billet_date_end'); ?></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control idate" id="date_end" name="end" value="<?php
                                                                                                                            echo (new DateTime())->format('t/m/Y');
                                                                                                                            ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex">
                                    <div class="col-md-4 form-group">
                                        <label for="">Série</label>
                                        <select name="classe_id" class="form-control">
                                            <option>Todos</option>
                                            <?php foreach ($listOfSeries as $row) : ?>
                                                <option value="<?php echo $row['id'];  ?>"><?php echo $row['class']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="">Motivo</label>

                                        <select name="motive_id" class="form-control">
                                            <option>Todos</option>
                                            <?php foreach ($listOfMotive as $key => $row) : ?>
                                                <option value="<?php echo $key;  ?>"><?php echo $row; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <?php
                                if ($this->rbac->hasPrivilege('billet_setting', 'can_edit')) :
                                ?>
                                    <button type="submit" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $this->lang->line('search'); ?></button>
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



<!-- begin: modal -->
<div id="listBilletModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="billet_generate_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('billet_generate'); ?></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary payment_collect" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing"><i class="fa fa-barcode"></i> <?php echo $this->lang->line('billet_button_generate'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- end: modal -->
<script type="text/javascript">
    $(document).ready(function() {
        var site_url = "<?php echo site_url('admin'); ?>";


        var $form = $("#schsetting_form");
        $.datepicker.regional['pt-BR'] = {
            closeText: 'Fechar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Hoje',
            monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
            ],
            dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

        $(".date").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',


        });
        $form.validate({

            rules: {
                start: {

                    required: true
                },
                end: {

                    required: true
                }
            }
        })


        $(".date").rules('remove', 'date')

        function initializeSearch(data) {

            var table = ['<table class="table">',

                `<thead>
               <tr>
                 <th>
                
                    <label>
                     <input name="billet_select_all" type="checkbox"> Todos
                    </label>
               
                 </th>
                 <th></th>
                 <th>Descricao</th>
                 <th>Vencimento</th>
                 <th>Valor</th>
               </tr>
             </thead>
             <tbody>`
            ]
            var total = 0
            for (var i in data) {
                var listOfItems = data[i]
                
                var user = listOfItems[0];
                
                table.push(`
                   <tr class="">
                    <th colspan="5" style="background-color: #f8f8f8;">
                    Estudante : ${user.session.student.firstname} ${user.session.student.lastname}</td>
                   </tr>
                `)

                for(let row of listOfItems){
                    total += row.amount_raw;
                    table.push(`
                   <tr class="${!row.is_valid ? 'text-danger': ''}">
                    <td >
                    
                        <label>
                        <input name="student_fee_item_id[]" value="${row.id}" ${!row.is_valid ? 'disabled': ''} type="checkbox">
                        <small class="text-danger">${!row.is_valid ? 'Vencido': ''}</small>
                        </label>
                   
                    </td>
                    
                    <td colspan="2">${row.title}</td>
                    <td>${row.due_date}</td>
                    <td  style="text-align:right;">${row.amount}</td>
                   </tr>
                `)
                }
                
                
            }
            table.push(`
                   </tbody>
                   </tfoot>
                   <tr>
                    <th colspan="4" style="text-align:right;">
                        Total
                   
                    </th>
                  
                    <th  style="text-align:right;">${accounting.formatNumber(total, 2, ".", ",")}</th>
                   </tr></tfoot>
                `)
            table.push(`</table>`)

            var html = `
                <div class="row">
                <div class="form-group">
                </div>
                    <div class="table-responsive">
                    ${table.join('')}
                    </div>
                </div>
              
            `;
            var $modalFooter = $("#listBilletModal .modal-footer");
            $("#listBilletModal .modal-body").html(html);
            $("#listBilletModal").modal('show');

            $('input[name="student_fee_item_id[]"]').on('click.OnSingleCheck', function() {
                var countChecked = $('input[name="student_fee_item_id[]"]:checked').size()
                var countNotChecked = $('input[name="student_fee_item_id[]"]:not(:checked)').size()

                if (countChecked > 0 && countChecked != countNotChecked) {
                    $('input[name="billet_select_all"]').prop('checked', false)
                }

            })

            $('input[name="billet_select_all"]').on('click.OnCheck', function() {
                var checked = $(this).is(':checked')

                $('input[name="student_fee_item_id[]"]').each(function() {
                    if (!$(this).prop('disabled'))
                        $(this).prop('checked', checked)


                })
            })
            var $formBillet = $('form#billet_generate_form');

            $formBillet.validate({
                rules: {
                    'student_fee_item_id[]': {
                        required: true,
                        minlength: 1
                    }
                },
                messages: {
                    'student_fee_item_id[]': {
                        minlength: 'Selecione pelo menos um item',
                        required: "Selecione pelo 1 item ",
                    }
                }
            })
            var loadBillet = false

            $formBillet.off('submit').on('submit', function(e) {
                e.preventDefault();

                if (!$formBillet.valid() || loadBillet || $formBillet.find('input[name="student_fee_item_id[]"]:checked').size() == 0) return;

                loadBillet = true;
                var $button = $modalFooter.find('button')
                $button.button('loading')
                $.ajax({
                    url: `${site_url}/billet/generate`,
                    type: 'POST',
                    data: $formBillet.serialize(),
                    dataType: 'json',
                    success: function() {

                        $("#listBilletModal").modal('hide');
                        $button.button('reset')
                        $formBillet.trigger('reset')
                        $("#listBilletModal .modal-body").html('');
                        $formBillet.reset();

                    },
                    complete: function() {
                        $button.button('reset')
                        loadBillet = false;
                    }
                });


            })


        }


        $form.submit(function(e) {
            var $this = $(this);
            e.preventDefault();
            if (!$form.valid()) return;

            $el = $this.find('.box-footer button')
            $el.button('loading');
            $.ajax({
                url: `${site_url}/billet/listOfFees`,
                type: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function({
                    data
                }) {
                    initializeSearch(data);
                },
                complete: function() {

                    $el.button('reset');
                }
            });
        });

    })
</script>