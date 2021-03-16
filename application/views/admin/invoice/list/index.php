<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('invoice_collection'); ?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('invoice_type_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="max-width:100% !important;">
                        <!-- <div class="download_label"><?php echo $this->lang->line('invoice_type_list'); ?></div> -->
                        <div class="table-responsive">
                            <table id="invoice_table" class="dataTable display" role="grid">
                                <thead>
                                    <tr>
                                        <th style="width: 100px; padding-left: 0px;">
                                            <?php echo $this->lang->line('invoice_number'); ?> / <br />
                                            <small><?php echo $this->lang->line('billet'); ?></small>
                                        </th>
                                        <th><?php echo $this->lang->line('invoice_student'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_guardian'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_email'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_date'); ?></th>
                                        <th><?php echo $this->lang->line('invoice'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_price'); ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list as $item) {
                                    ?>
                                        <tr>
                                            <td align="left">
                                                <a href="#" data-toggle="popover" class="detail_popover"><?php echo $item->invoice_number; ?></a>

                                                <?php if ($item->billet->count() > 0) : ?>
                                                    <small class="text-success " style="display:block;"><?php echo $item->billet->first()->bank_bullet_id; ?><small>
                                                        <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo $item->student->full_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $item->student->guardian_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $item->student->guardian_email; ?>
                                            </td>
                                            <td>
                                                <?php echo (new \DateTime($item->due_date))->format('d/m/Y'); ?>
                                            </td>
                                            <td>
                                                <a target="_blank" href="<?php
                                                                            $bodyJson = json_decode($item->body);
                                                                            echo $bodyJson->LinkImpressao;
                                                                            ?>"> Ver Nota</a>

                                            </td>
                                            <td>
                                                <?php echo number_format($item->price, 2, ',', '.'); ?>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div>
            <!--/.col (left) -->
            <!-- right column -->

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div>
            <!--/.col (right) -->
        </div> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
<!-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->

<style>
    .dataTables_wrapper,
    .dataTables_filter {
        text-align: right;
        float: left !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('#date').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function() {
            $("#form1")[0].reset();
        });

        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function() {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });

        var $table = $('#invoice_table').DataTable({
            ordering: false,
            paging: false,
            info: false,
            filter: true,
            dom: 'fBrtip<"clear">',
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    footer: true,
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'CSV',
                    footer: true,
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    footer: true,
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF',
                    title: $('.download_label').html(),
                    exportOptions: {
                        //  columns: ':all'

                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    footer: true,
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    titleAttr: 'Columns',
                    footer: true,
                    title: $('.download_label').html(),
                    postfixButtons: ['colvisRestore']
                },
            ],
            // footerCallback: function(row, data, start, end, display) {
            //     var api = this.api(),
            //         data;


            //     // Remove the formatting to get integer data for summation
            //     var intVal = function(i) {
            //         return typeof i === 'string' ?
            //             i.replace(/[R\$,]/g, '') * 1 :
            //             typeof i === 'number' ?
            //             i : 0;
            //     };

            //     var sum = 0,
            //         totalForReceived = 0,
            //         totalDiscount = 0,
            //         totalFine = 0;
            //     api
            //         .column(8, {
            //             page: 'current'
            //         })
            //         .data()
            //         .filter((a, k) => {
            //             return k < end
            //         })
            //         .map((a) => {
            //             sum += $(a).data('total')
            //         })
            //     api
            //         .column(3, {
            //             page: 'current'
            //         })
            //         .data()
            //         .filter((a, k) => {
            //             return k < end
            //         })
            //         .map((a) => {
            //             // console.log($(a).data('value'))
            //             totalForReceived += Number($(a).data('value'))
            //         })
            //     api
            //         .column(7, {
            //             page: 'current'
            //         })
            //         .data()
            //         .filter((a, k) => {
            //             return k < end
            //         })
            //         .map((a) => {
            //             // console.log($(a).data('value'))
            //             totalFine += Number($(a).data('value'))
            //         })

            //     api
            //         .column(6, {
            //             page: 'current'
            //         })
            //         .data()
            //         .filter((a, k) => {
            //             return k < end
            //         })
            //         .map((a) => {
            //             // console.log($(a).data('value'))
            //             totalDiscount += Number($(a).data('value'))
            //         })

            //     $('.dataTables_wrapper table > tfoot').show()
            //     $(api.column(3).footer()).html(accounting.formatMoney(totalForReceived, "", 2, ".", ","))
            //     $(api.column(6).footer()).html(accounting.formatMoney(totalDiscount, "", 2, ".", ","))
            //     $(api.column(7).footer()).html(accounting.formatMoney(totalFine, "", 2, ".", ","))
            //     $(api.column(8).footer()).html(accounting.formatMoney(sum, "", 2, ".", ","))


            // }
        });
    });
</script>