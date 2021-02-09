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
                                    print(form_dropdown('invoice_filter', $options_invoice_filter, $invoice_filter, 'class="form-control" '));
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
                            <table id="deposite_table" class="table table-striped table-bordered table-hover display" data-page-length="<?= count($incomeList); ?>" style="max-width: 100%;">
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
                                    if (!empty($incomeList)) :
                                        foreach ($incomeList as $item) :
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

                                                    printf('%s / %s', $item->input->guardian_name ?? $item->input->guardian_name, isset($item->input->fullname)  ? $item->input->fullname : null);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    print($item->invoice->count() > 0 ?  (!$item->invoice->first()->invoice_number ? 'Processando nota...' : $item->invoice->first()->invoice_number) : 'S/N');
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    print($item->invoice->count() > 0  && isset($item->invoice->first()->billet->bank_bullet_id) ?  $item->invoice->first()->billet->bank_bullet_id : 'S/N');
                                                    ?>
                                                </td>

                                                <td style="width: 80px;">
                                                    <span data-value="<?= $item->feeItem->amount ?>"><?php printf('%s %s', $currency_symbol, number_format($item->feeItem->amount, 2, ',', '.')); ?></span>
                                                </td>

                                                <td>
                                                    <?php print($this->lang->line(strtolower($detail->payment_mode))); ?>
                                                </td>

                                                <td>
                                                    <?php printf('%s', (new DateTime($item->created_at))->format('d/m/Y')); ?>
                                                </td>

                                                <td>
                                                    <span data-value="<?= $detail->amount_discount ?>"> <?php printf('%s %s', $currency_symbol, number_format($detail->amount_discount, 2, ',', '.')); ?></span>

                                                </td>
                                                <td>
                                                    <span data-value="<?= $detail->amount_fine ?>">
                                                        <?php printf('%s %s', $currency_symbol, number_format($detail->amount_fine, 2, ',', '.')); ?>
                                                </td>
                                                </span>

                                                <td style="width: 90px;">
                                                    <small data-total="<?= $row_total ?>"> <?php printf('<strong class="%s">%s %s</strong>', $row_total < 0 ? 'amount_negative' : '', $currency_symbol,  number_format($row_total, 2, ',', '.')); ?></small>
                                                </td>

                                            </tr>
                                    <?php
                                            $count++;
                                        endforeach;
                                    endif;
                                    ?>
                                   <!-- <tr class="row-total odd" style="font-weight: 600;">
                                     <td colspan="3">Total</td>
                                     
                                     
                                     <td>R$ 0,00</td>
                                     <td colspan="2"> &nbsp; </td>
                                     <td>R$ 0,00 </td>
                                     <td>R$ 0,00</td>
                                     <td class="row-">R$ 0,00</td>
                                   </tr> -->
                                </tbody>
                                <tfoot>
                                    <!-- <tr>
                                        <th><?php echo $this->lang->line('report_guardian_name'); ?></th>
                                        <th><?php echo $this->lang->line('report_invoice_no'); ?></th>
                                        <th><?php echo $this->lang->line('report_billet_no'); ?></th>
                                        <th><?php echo $this->lang->line('report_amount'); ?></th>
                                        <th><?php echo $this->lang->line('report_type_payment'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_due_date'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_discount'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_fine'); ?></th>
                                        <th><?php echo $this->lang->line('report_fee_total'); ?></th>
                                    </tr> -->
                                    <!-- <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><strong>Totais</strong></th>
                                        <th>R$ 0,00</th>
                                    </tr> -->

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
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function($) {
        var $table = $('#deposite_table').DataTable({
            // language: {
            //     url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json'
            // },
            ordering: false,
            paging: false,
            info: false,
            // scrollY: 600,
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
            footerCallback: function(row, data, start, end, display) {
                var api = this.api(),
                    data;


                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[R\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                var sum = 0,
                    totalForReceived = 0,
                    totalDiscount = 0,
                    totalFine = 0;
                api
                    .column(8, {
                        page: 'current'
                    })
                    .data()
                    .filter((a,k)=> {
                        return  k < end
                    })
                    .map((a) => {
                        sum += $(a).data('total')
                    })
                api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .filter((a,k)=> {
                        return  k < end
                    })
                    .map((a) => {
                        // console.log($(a).data('value'))
                        totalForReceived += Number($(a).data('value'))
                    })
                api
                    .column(7, {
                        page: 'current'
                    })
                    .data()
                    .filter((a,k)=> {
                        return  k < end
                    })
                    .map((a) => {
                        // console.log($(a).data('value'))
                        totalFine += Number($(a).data('value'))
                    })

                api
                    .column(6, {
                        page: 'current'
                    })
                    .data()
                    .filter((a,k)=> {
                        return  k < end
                    })
                    .map((a) => {
                        // console.log($(a).data('value'))
                        totalDiscount += Number($(a).data('value'))
                    })

                // pageTotal = 0;
                // api
                //     .column(8, {
                //         page: 'current'
                //     })
                //     .data()
                //     .reduce(function(a, b) {
                //         return $(a).data('total') + $(b).data('total');
                //     }, 0);


                //     // Update footer

                // $(api.column(8).footer()).html(
                //     `${accounting.formatMoney(sum, "R$ ", 2, ",", ".")}`
                // );
                // $('.dataTables_wrapper table > foot').show()
                // console.log('..old..')
                var markupHTML = `
                        
                             
                                        <tr id="row_total" class="odd" role="row">
                                            <td colspan="3" >Total</td>
                                            <td style="text-align: left;">${accounting.formatMoney(totalForReceived, "R$ ", 2, ",", ".")}</td>
                                            <td colspan="1" style="width: 21.5%;"> &nbsp; </td>
                                            <td style="width: 80px;">${accounting.formatMoney(totalDiscount, "R$ ", 2, ",", ".")}</td>
                                            <td style="width: 80px;">${accounting.formatMoney(totalFine, "R$ ", 2, ",", ".")}</td>
                                            <td style="width: 90px;">${accounting.formatMoney(sum, "R$ ", 2, ",", ".")}</td>
                                        </tr>
                                
                           `
                // $('.dataTables_wrapper').removeClass('no-footer')
                // $('.dataTables_wrapper table#deposite_table').removeClass('no-footer')
                // console.log('foot...', end)
                // $('.row-total td').get(-1).html(accounting.formatMoney(sum, "R$ ", 2, ",", "."))
                // $('.dataTables_wrapper #row_total').detach()
                // $('.dataTables_wrapper table#deposite_table tbody').append(markupHTML);
                // $(markupHTML).insertAfter('.dataTables_wrapper table#deposite_table')

            }
        });

        // $table.on('draw', function() {
        //     console.log('..old..')

        // })

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