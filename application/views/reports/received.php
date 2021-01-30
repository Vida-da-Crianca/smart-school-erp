<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<style type="text/css">
    /*REQUIRED*/
    .carousel-row {
        margin-bottom: 10px;
    }

    .slide-row {
        padding: 0;
        background-color: #ffffff;
        min-height: 150px;
        border: 1px solid #e7e7e7;
        overflow: hidden;
        height: auto;
        position: relative;
    }

    .slide-carousel {
        width: 20%;
        float: left;
        display: inline-block;
    }

    .slide-carousel .carousel-indicators {
        margin-bottom: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
    }

    .slide-carousel .carousel-indicators li {
        border-radius: 0;
        width: 20px;
        height: 6px;
    }

    .slide-carousel .carousel-indicators .active {
        margin: 1px;
    }

    .slide-content {
        position: absolute;
        top: 0;
        left: 20%;
        display: block;
        float: left;
        width: 80%;
        max-height: 76%;
        padding: 1.5% 2% 2% 2%;
        overflow-y: auto;
    }

    .slide-content h4 {
        margin-bottom: 3px;
        margin-top: 0;
    }

    .slide-footer {
        position: absolute;
        bottom: 0;
        left: 20%;
        width: 78%;
        height: 20%;
        margin: 1%;
    }

    /* Scrollbars */
    .slide-content::-webkit-scrollbar {
        width: 5px;
    }

    .slide-content::-webkit-scrollbar-thumb:vertical {
        margin: 5px;
        background-color: #999;
        -webkit-border-radius: 5px;
    }

    .slide-content::-webkit-scrollbar-button:start:decrement,
    .slide-content::-webkit-scrollbar-button:end:increment {
        height: 5px;
        display: block;
    }

    .amount_negative {
        color: red;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">

    <section class="content-header">
        <h1>
            <i class="fa fa-bus"></i> <?php echo $this->lang->line('transport'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('reports/_finance'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>

                    <form role="form" action="<?php echo site_url('report/received') ?>" method="post" class="">
                        <div class="box-body row">

                            <?php echo $this->customlib->getCSRF(); ?>

                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('search') . " " . $this->lang->line('type'); ?></label>
                                    <select class="form-control" name="search_type" onchange="showdate(this.value)">

                                        <?php foreach ($searchlist as $key => $search) {
                                        ?>
                                            <option value="<?php echo $key ?>" <?php
                                                                                if ((isset($search_type)) && ($search_type == $key)) {

                                                                                    echo "selected";
                                                                                }
                                                                                ?>><?php echo $search ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('search_type'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('search') . " " . $this->lang->line('class'); ?></label>
                                    <?php
                                    print(form_dropdown('class_id', $options_classe, $class_id, 'class="form-control" '));
                                    ?>
                                    <!-- <select class="form-control" name="class_id">

                                        
                                    </select> -->
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('search') . " " . $this->lang->line('invoice_or_no'); ?></label>
                                    <?php
                                    $options_invoice_filter = [
                                        null => 'Todos',
                                        1  => 'Com Nota',
                                        2  => 'Sem nota'
                                    ];
                                    print(form_dropdown('invoioce_filter', $options_invoice_filter, $invoioce_filter, 'class="form-control" '));
                                    ?>
                                    <!-- <select class="form-control" name="class_id">

                                        
                                    </select> -->
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                            </div>

                            <div id='date_result'>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"><i class="fa fa-money"></i> <?php echo $this->lang->line('income') . " " . $this->lang->line('report'); ?></h3>
                        </div>
                        <div class="box-body table-responsive">
                            <div class="download_label">
                                <?php echo  $this->lang->line('income') . " " . $this->lang->line('report') . "<br>";
                                $this->customlib->get_postmessage();
                                ?>
                            </div>
                            <table id="deposite_table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('report_guardian_name'); ?></th>
                                        <th><?php echo $this->lang->line('report_invoice_no'); ?></th>
                                        <th><?php echo $this->lang->line('report_billet_no'); ?></th>
                                        <th><?php echo $this->lang->line('report_amount'); ?></th>
                                        <th><?php echo $this->lang->line('report_type_payment'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_due_date'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_discount'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_fine'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_total'); ?></th>

                                        <!-- <th class="text text-right"><?php echo $this->lang->line('amount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $grand_total = 0;
                                    $sum_amount = 0;
                                    $sum_discount = 0;
                                    $sum_fine = 0;
                                    $sum_total = 0;
                                    if (empty($incomeList)) {
                                    ?>

                                        <?php
                                    } else {
                                        foreach ($incomeList as $item) {
                                            $detail = $item->detail;
                                            $sum_amount += $item->feeItem->amount;
                                            $sum_discount += $detail->amount_discount;
                                            $sum_fine +=  $detail->amount_fine;
                                            $sum_total += ($item->feeItem->amount - $detail->amount_discount) + $detail->amount_fine;
                                            $row_total = ($item->feeItem->amount - $detail->amount_discount) + $detail->amount_fine;

                                            // dump(isset($item->student->guardian_name) ? $item->student->guardian_name : $item->id);
                                        ?>

                                            <tr>

                                                <td align="left">
                                                    <?php

                                                    printf('%s / %s', $item->student->guardian_name ?? $item->student->guardian_name, $item->student->fullname ?? $item->student->fullname);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php print($item->invoice ?  $item->invoice->invoice_number : 'S/N'); ?>
                                                </td>

                                                <td>
                                                    <?php print(isset($item->invoice->billet) ?  $item->invoice->billet->bank_bullet_id : 'S/N'); ?>
                                                </td>

                                                <td>
                                                    <?php printf('%s %s', $currency_symbol, number_format($item->feeItem->amount, 2, ',', '.')); ?>
                                                </td>

                                                <td>
                                                    <?php print($this->lang->line(strtolower($detail->payment_mode))); ?>
                                                </td>

                                                <td>
                                                    <?php printf('%s', (new DateTime($item->created_at))->format('d/m/Y')); ?>
                                                </td>

                                                <td>
                                                    <?php printf('%s %s', $currency_symbol, number_format($detail->amount_discount, 2, ',', '.')); ?>
                                                </td>
                                                <td>
                                                    <?php printf('%s %s', $currency_symbol, number_format($detail->amount_fine, 2, ',', '.')); ?>
                                                </td>
                                                <td>
                                                    <?php printf('<strong class="%s">%s %s</strong>', $row_total < 0 ? 'amount_negative' : '', $currency_symbol,  number_format($row_total, 2, ',', '.')); ?>
                                                </td>

                                            </tr>
                                        <?php
                                            $count++;
                                        }
                                        ?>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9"></td>
                                    </tr>
                                    <tr class="box box-solid total-bg">
                                        <td colspan="4" align="left"></td>
                                        <td class="text-right"><?php echo $this->lang->line('grand_total'); ?></td>
                                        <td class="text">
                                            <?php echo ($currency_symbol . number_format($sum_amount, 2, ',', '.')); ?>
                                        </td>
                                        <td class="text">
                                            <?php printf('%s %s', $currency_symbol, number_format($sum_discount, 2, ',', '.')); ?>
                                        </td>
                                        <td class="text">
                                            <?php printf('%s %s', $currency_symbol, number_format($sum_fine, 2, ',', '.')); ?>
                                        </td>
                                        <td class="text text-right">
                                            <?php printf('<span class="%s"> %s %s</span>', $sum_total < 0 ? 'amount_negative' : '',  $currency_symbol, number_format($sum_total, 2, ',', '.')); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<script>
    $(document).ready(function($) {
        $('#deposite_table').DataTable({
            dom: "Bfrtip",
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',

                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'CSV',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'

                    }
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    title: $('.download_label').html(),
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    titleAttr: 'Columns',
                    title: $('.download_label').html(),
                    postfixButtons: ['colvisRestore']
                },
            ],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                console.log(data)

                // Remove the formatting to get integer data for summation
                // var intVal = function(i) {
                //     return typeof i === 'string' ?
                //         i.replace(/[\$,]/g, '') * 1 :
                //         typeof i === 'number' ?
                //         i : 0;
                // };

                // // Total over all pages
                // total = api
                //     .column(4)
                //     .data()
                //     .reduce(function(a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0);

                // // Total over this page
                // pageTotal = api
                //     .column(4, {
                //         page: 'current'
                //     })
                //     .data()
                //     .reduce(function(a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0);

                // // Update footer
                // $(api.column(4).footer()).html(
                //     '$' + pageTotal + ' ( $' + total + ' total)'
                // );
            }
        });

    })
    // $('#deposite_table').DataTable();
    <?php
    if ($search_type == 'period') {
    ?>

        $(document).ready(function() {
            showdate('period');
        });

    <?php
    }
    ?>
</script>