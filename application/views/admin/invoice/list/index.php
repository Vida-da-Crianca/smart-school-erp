<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('invoice_collection'); ?></h1>
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
                    <div class="box-body">
                        <!-- <div class="download_label"><?php echo $this->lang->line('invoice_type_list'); ?></div> -->
                        <div class="mailbox-messages table-responsive">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('invoice_number'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('invoice_student'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_guardian'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_email'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_date'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_price'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list as $item) {
                                    ?>
                                        <tr>
                                            <td class="mailbox-name">
                                                <a href="#" data-toggle="popover" class="detail_popover"><?php echo $item->invoice_number; ?></a>
                                                
                                            </td>
                                            <td class="mailbox-name">
                                              <?php echo $item->student->full_name; ?> 
                                            </td>
                                            <td class="mailbox-name">
                                              <?php echo $item->student->guardian_name; ?> 
                                            </td>
                                            <td class="mailbox-name">
                                              <?php echo $item->student->guardian_email; ?> 
                                            </td>
                                            <td class="mailbox-name">
                                              <?php echo (new \DateTime($item->created_at))->format('d/m/Y'); ?> 
                                            </td>
                                            <td class="mailbox-name">
                                             <a 
                                             target="_blank"
                                             href="<?php
                                                 $bodyJson = json_decode($item->body);
                                                 echo $bodyJson->LinkImpressao;
                                             ?>"> Ver Nota</a>  
                                        
                                            </td>
                                            
                                            <td class="mailbox-name">
                                              <?php echo number_format($item->price,2,',','.'); ?> 
                                            </td>
                                            

                                            <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('invoice_type', 'can_edit')) {
                                                ?>
                                                    <!-- <a data-placement="left" href="<?php echo base_url(); ?>admin/feetype/edit/<?php echo $item['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a> -->
                                                <?php } ?>
                                                <?php
                                                if ($this->rbac->hasPrivilege('invoice_type', 'can_delete')) {
                                                ?>
                                                    <!-- <a data-placement="left" href="<?php echo base_url(); ?>admin/feetype/delete/<?php echo $item['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a> -->
                                                <?php } ?>
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

    });
</script>
<script>
    $(document).ready(function() {
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
</script>