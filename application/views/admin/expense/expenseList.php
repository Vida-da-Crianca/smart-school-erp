    <?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-credit-card"></i> <?php echo $this->lang->line('expenses'); ?> <small><?php echo $this->lang->line('student_fee'); ?></small></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('expense', 'can_add')) {
            ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php //echo $title;      
                                                    ?><?php echo $this->lang->line('add_expense'); ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo base_url() ?>admin/expense" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('expense_head'); ?></label> <small class="req">*</small>

                                    <select autofocus="" id="exp_head_id" name="exp_head_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($expheadlist as $exphead) {
                                        ?>
                                            <option value="<?php echo $exphead['id'] ?>" <?php
                                                                                            if (set_value('exp_head_id') == $exphead['id']) {
                                                                                                echo "selected =selected";
                                                                                            }
                                                                                            ?>><?php echo $exphead['exp_category'] ?></option>

                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('exp_head_id'); ?></span>
                                </div>
                                <div class="form-group">
                                <input type="hidden" name="owner_id"  value="<?php echo set_value('owner_id') ?>"> 
                                    <label><?php echo $this->lang->line('expense_type'); ?></label> <small class="req">*</small> <br />
                                    <label class="radio-inline">
                                        <input type="radio" name="owner_type" id="owner_type_1" value="F"> Funcionário
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="owner_type" id="owner_type_1" checked value="J"> Fornecedor
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label> <small class="req">*</small>
                                    <input id="name" name="name" placeholder="" type="text" class="form-control" value="<?php echo set_value('name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('invoice_no'); ?></label>
                                    <input id="invoice_no" name="invoice_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('invoice_no'); ?>" />
                                    <span class="text-danger"><?php echo form_error('invoice_no'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label> <small class="req">*</small>
                                    <input id="date" name="date" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('expense_payment_at'); ?></label> <small class="req">*</small>
                                    <input id="date" name="payment_at" placeholder="" type="text" class="form-control date" 
                                    value="<?php echo set_value('payment_at', date($this->customlib->getSchoolDateFormat())); ?>"  />
                                    <span class="text-danger"><?php echo form_error('payment_at'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('amount'); ?></label> <small class="req">*</small>
                                    <input id="amount" name="amount" placeholder="" type="text" class="form-control" value="<?php echo set_value('amount'); ?>" />
                                    <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('attach_document'); ?></label>
                                    <input id="documents" name="documents" placeholder="" type="file" class="filestyle form-control" value="<?php echo set_value('documents'); ?>" />
                                    <span class="text-danger"><?php echo form_error('documents'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div>
                <!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
                                if ($this->rbac->hasPrivilege('expense', 'can_add')) {
                                    echo "8";
                                } else {
                                    echo "12";
                                }
                                ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('expense_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-messages table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('expense_list'); ?></div>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered example">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('name'); ?>
                                            </th>
                                            <th><?php echo $this->lang->line('invoice_no'); ?>
                                            </th>
                                            <th><?php echo $this->lang->line('date'); ?>
                                            </th>
                                            <th><?php echo $this->lang->line('expense_head'); ?>
                                            </th>
                                            <th><?php echo $this->lang->line('amount'); ?>
                                            </th>
                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($expenselist)) {
                                        ?>

                                            <?php
                                        } else {
                                            foreach ($expenselist as $expense) {
                                            ?>
                                                <tr class="<?php  echo $expense['payment_at'] != null ?  'success' : 'danger' ?>">
                                                    <td class="mailbox-name ">
                                                       
                                                        <a href="#" data-toggle="popover" class="detail_popover"><?php echo $expense['name'] ?></a>

                                                        <div class="fee_detail_popover" style="display: none">
                                                            <?php
                                                            if ($expense['note'] == "") {
                                                            ?>
                                                                <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <p class="text text-info"><?php echo $expense['note']; ?></p>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td class="mailbox-name"><?php echo $expense["invoice_no"]; ?></td>
                                                    <td class="mailbox-name">

                                                        <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($expense['date'])) ?></td>

                                                    <td class="mailbox-name">
                                                        <?php echo $expense['exp_category'] ?>

                                                    </td>
                                                    <td class="mailbox-name"><?php echo ($currency_symbol . $expense['amount']); ?></td>
                                                    
                                                    <td class="mailbox-date pull-right">
                                                        <?php if ($expense['documents']) {
                                                        ?>
                                                            <a data-placement="left" href="<?php echo base_url(); ?>admin/expense/download/<?php echo $expense['documents'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        <?php }
                                                        ?>
                                                        <?php
                                                        if ($this->rbac->hasPrivilege('expense', 'can_edit')) {
                                                        ?>
                                                            <a data-placement="left" href="<?php echo base_url(); ?>admin/expense/edit/<?php echo $expense['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        <?php
                                                        }
                                                        if ($this->rbac->hasPrivilege('expense', 'can_delete')) {
                                                        ?>
                                                            <a data-placement="left" href="<?php echo base_url(); ?>admin/expense/delete/<?php echo $expense['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                        <?php } ?>

                                                        <!--por altasis em 07-05-2021 -->
														<?php if($expense['payment_at'] != null){ ?>	
                                                        <a data-placement="left" href="<?php echo base_url(); ?>admin/recibo/gerar/<?php echo $expense['id'] ?>" target="_blank" class="btn btn-default btn-xs" data-toggle="tooltip" title="PDF" onclick="">
															<i class="fa fa-file-pdf-o"></i>
                                                        </a>
														<?php } ?>

                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table><!-- /.table -->

                            </div>

                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div>
            <!--/.col (left) -->

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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="/backend/js/jquery.maskMoney.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {


        $("#btnreset").click(function() {
            $("#form1")[0].reset();
        });

    });
</script>
<script>
    $(document).ready(function() {

        $('input[name="amount"]').maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: true});
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function() {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });

    initializeAutocomplete();

    $('input[name="owner_type"]').on('change', function() {
        initializeAutocomplete()
    })

    function initializeAutocomplete() {

        // $('input[name="name"]').autocomplete( "destroy" );
        $('input[name="name"]').autocomplete({
            minLength: 2,
            select: function( event, ui ) {
               console.log(ui)
               $('input[name="owner_id"]').val(ui.item.id)
            },
            source: function(request, response) {
                $.ajax({
                    url: '<?php echo site_url('/admin/expense/owner_ajax');  ?>?type=' + $('input[name="owner_type"]:checked').val(),
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function({
                        data
                    }) {
                        var items = [];

                        data.forEach(row => {
                            items.push({
                                label: row.name,
                                value: row.name,
                                id: row.id
                            })
                        })
                        //cache[`${term}_${$('input[name="owner_type"]:checked').val()}`] = items
                        response(items);
                    }
                });
            },


        });
    }
</script>