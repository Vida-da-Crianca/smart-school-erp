<style type="text/css">
    .wrapper {
        overflow: visible;
    }
</style>




<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">



    <section class="content-header">
        <h1><i class="fa fa-gears"></i>Boletos Emitidos</h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
	<div class="row">
    <div class="col-md-12">
        <div class="box box-primary border0 mb0 margesection">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('finance') ?></h3>

            </div>
            <div class="">
                <ul class="reportlists">

                    <?php
                    if ($this->rbac->hasPrivilege('fees_statement', 'can_view')) {
                    ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/reportbyname'); ?>"><a href="<?php echo base_url(); ?>studentfee/reportbyname"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('fees_statement'); ?></a></li>
                    <?php
                    }
                    if ($this->rbac->hasPrivilege('balance_fees_report', 'can_view')) {
                    ?>

                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/studentacademicreport'); ?>"><a href="<?php echo base_url(); ?>admin/transaction/studentacademicreport"><i class="fa fa-file-text-o"></i>
                                <?php echo $this->lang->line('balance_fees_report'); ?></a></li>
                    <?php
                    }
                    if ($this->rbac->hasPrivilege('fees_collection_report', 'can_view')) {

                    ?>

                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/collection_report'); ?>"><a href="<?php echo base_url(); ?>studentfee/collection_report"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('fees') . " " . $this->lang->line('collection') . " " . $this->lang->line('report'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('online_fees_collection_report', 'can_view')) { ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/onlinefees_report'); ?>"><a href="<?php echo base_url(); ?>report/onlinefees_report"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('online') . " " . $this->lang->line('fees') . " " . $this->lang->line('collection') . " " . $this->lang->line('report'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('income_report', 'can_view')) { ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/income'); ?>"><a href="<?php echo base_url(); ?>report/income"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('income') . " " . $this->lang->line('report'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('expense_report', 'can_view')) { ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/expense'); ?>"><a href="<?php echo base_url(); ?>report/expense"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('expense') . ' ' . $this->lang->line('report'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('payroll_report', 'can_view')) { ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/payroll'); ?>"><a href="<?php echo base_url(); ?>report/payroll"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('payroll') . " " . $this->lang->line('report'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('income_group_report', 'can_view')) { ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/incomegroup'); ?>"><a href="<?php echo base_url(); ?>report/incomegroup"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('income') . " " . $this->lang->line('group') . " " . $this->lang->line('report'); ?></a></li>
                    <?php }
                    if ($this->rbac->hasPrivilege('expense_group_report', 'can_view')) { ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/expensegroup'); ?>"><a href="<?php echo base_url(); ?>report/expensegroup"><i class="fa fa-file-text-o"></i> <?php echo $this->lang->line('expense') . " " . $this->lang->line('group') . " " . $this->lang->line('report'); ?></a></li>
                    <?php } ?>
					
					<li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/expensegroup'); ?>">
					
					
					<a href="<?php echo base_url(); ?>report/boletos_emitidos"><i class="fa fa-file-text-o"></i> 
					Boletos emitidos
					</a>
					
					<a href="<?php echo base_url(); ?>report/recebimentos_previstos"><i class="fa fa-file-text-o"></i> 
					Recebimentos previstos
					</a>
					
					<a href="<?php echo base_url(); ?>report/lista_de_documentos"><i class="fa fa-file-text-o"></i> 
					Lista de documentos
					</a>
					
					
					
					
					
					</li>

                    <?php if ($this->rbac->hasPrivilege('expense_received_report', 'can_view')) : ?>
                        <li class="col-lg-4 col-md-4 col-sm-6 <?php echo set_SubSubmenu('Reports/finance/received'); ?>">
                            <a href="<?php echo base_url(); ?>report/received"><i class="fa fa-file-text-o "></i> 
                            <?php echo $this->lang->line('received_finance')  ?>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
</div>


        <div class="row">

	
            <div class="col-xs-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><i class="fa fa-calendar"></i> Boletos Emitidos</h3>
						
							<?php
							if(isset($_POST['start'])){
								
                                                            $dst = str_replace(' ', '', $_POST['start']);	
                                                            $den = str_replace(' ', '', $_POST['end']);
                                                            $type_date = trim($_POST['type_date']);

                                                            $dats = new DateTime($dst);
                                                            $start = $dats->format('Y-m-d');

                                                            $date = new DateTime($den);
                                                            $end = $date->format('Y-m-d');


                                                            //echo $start."<br>";
                                                            //echo $end."<br>";
                                                            
                                                            $status = (isset($_POST['status']) ? $_POST['status'] : []);

                                                            $this->db->select("
                                                            students.guardian_name,
                                                            students.guardian_document,
                                                            students.firstname,
                                                            students.lastname,
                                                            billets.id,
                                                            billets.price as PRECO_BOLETO,
                                                            billets.created_at,
                                                            billets.due_date,
                                                            billets.status,
                                                            billets.bank_bullet_id 
                                                            FROM
                                                            students,
                                                            billets
                                                            WHERE
                                                            ($type_date BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59') AND
                                                            billets.user_id =  students.id ". (is_array($status) && count($status) > 0 ? " AND billets.status IN ('". implode("','", $status)."')" : ''), FALSE);

                                                            $query = $this->db->get();	
                                                            
                                                           // echo $this->db->last_query();

                                                            $show_table = true;
							}
							else{
								$dst = date('d-m-Y',strtotime('-30 days',strtotime(date('d-m-Y')))) . PHP_EOL;
								$den = date('d-m-Y') . PHP_EOL;
                                                                $type_date = 1;
								$show_table = false;
                                                                $status = [];
							}
							?>
							<div class="box-tools pull-right">

							</div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="">
                        
						<form  action="<?php echo site_url('report/boletos_emitidos') ?>" method="POST" class="">

                            <div class="box-body">

                                <div class="row d-flex align-items-center border">
                                    <div class="col-md-3 form-group">
                                        <label>Data Inicial<small class="req"> *</small></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control idate" id="name" name="start" value="<?php
                                                                                                                        echo $dst;
                                                                                                                        ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Data Final</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control idate" id="date_end" name="end" value="<?php
                                                                                                                            echo $den ;
                                                                                                                            ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Tipo de Data</label>
                                        <div class="input-group">
                                            <?php echo form_dropdown('type_date',array('billets.due_date'=>'Data de Vencimento','billets.created_at'=>'Data de Emissão'), $type_date, "id='type_date' class='form-control'"); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Status</label>
                                        <div class="row">
                                                <div class="col-xs-12 dropdown" id="classDropdown">
                                                    <div class="button-group w-full" data-toggle="dropdown">
                                                        <button type="button" class="btn btn-default btn-sm">
                                                            <span data-default="Selecione um Status" 
                                                                  class="dropdown-label">Selecione um Status</span> 
                                                                  <span class="caret"></span>
                                                        </button>
                                                    </div>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        $statusList = $this->db->group_by('status')->order_by('status')->get('billets')->result();
                                                        foreach ($statusList as $boleto) { if(!empty($boleto->status)){
                                                        ?>
                                                            <li class="ui-checkbox">
                                                                <label class="small control control-checkbox" data-value="<?php echo $boleto->status ?>">
                                                                    <input type="checkbox" 
                                                                           data-value="<?php echo $boleto->status ?>" 
                                                                           data-label="<?php echo $boleto->status ?>" 
                                                                               <?php echo (in_array($boleto->status, $status)) ? "checked" : ''; ?> name="status[]" 
                                                                               value="<?php echo $boleto->status; ?>" />&nbsp;<?php echo $boleto->status ?>
                                                                    <div class="control_indicator"></div>
                                                                </label>
                                                            </li>

                                                        <?php

                                                        }}
                                                        ?>


                                                    </ul>
                                                </div>

                                                <span class="text-danger"><?php //echo form_error('class_id_option[]'); ?></span>
                                            </div>
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

        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Resultados:</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="max-width:100% !important;">
                        <!-- <div class="download_label"><?php echo $this->lang->line('invoice_type_list'); ?></div> -->
                        <div class="table-responsive">
                            <table id="invoice_table" class="dataTable display" role="grid" style="width: 100%;">
                                <thead>
                                    <tr>
                                        </th>
                                        <th>Nome Responsável financeiro</th>
										<th>CPF</th>
                                        <th>Aluno</th>
                                        <th>Nº do Boleto</th>
                                        <th>Nº da Nota</th>
                                        <!--<th>valor original</th>
                                        <th>desconto</th>-->
                                                                                <th>Emissão</th>
										<th>Vencimento</th>
										<th>Status</th>
										<th>Valor</th>
                                    </tr>
                                </thead>
                                
								
								<tbody>
                                    <?php
                                    $total = 0;
									
									if($show_table){
										$total = 0;
										foreach ($query->result() as $row)
										{
											
											//verificamos se tem nota.
											$this->db->select("invoice_id FROM invoice_billet where billet_id = ".$row->id ."", FALSE);
											$query2 = $this->db->get();	
											
											foreach ($query2->result() as $row2){
												$temInvoice = $row2->invoice_id;
											}
											
											if(isset($temInvoice)){
												if(($temInvoice != null)OR($temInvoice != "")){
													//pegando numero da nota
													$this->db->select("invoice_number FROM `invoices` where id = ".$temInvoice."", FALSE);
													$query3 = $this->db->get();	
													
													foreach ($query3->result() as $row3){
														$ninvoice = $row3->invoice_number;
													}
													
												}
												else{
													$ninvoice = "Sem Nota associada";
												}
											}
											else{
												$ninvoice = "Sem Nota associada";
											}
												
											
											
											
												//print_r($row);
												echo
												"
												<tr>
												<td align='left'>
												".$row->guardian_name ."
												</td>
												<td>
												".mask($row->guardian_document,'###.###.###-##') ."
												</td>
												<td>
												".$row->firstname." ".$row->lastname ."
												</td>
                                                                                                <td>
												".$row->bank_bullet_id."
												</td>
												<td>
												".$ninvoice."
												</td>
                                                                                                <td>
												".(new \DateTime($row->created_at))->format('d/m/Y')."
												</td>
												<td>
												".(new \DateTime($row->due_date))->format('d/m/Y')."
												</td>
												<td>
												".$row->status ."
												</td>
												  <td>
													<span data-total=".$row->PRECO_BOLETO .">
														R$ ".number_format($row->PRECO_BOLETO, 2, ',', '.')."";
														$total += $row->PRECO_BOLETO; 	
													echo"
													   
													</span>

												</td>
												
												</tr>";
												
												 
										}
										?>
										

									</tbody>
									<tfoot>
										<tr>
											<th colspan="8">Total</th>

											<th id="totalValor"><?= number_format($total, 2, ',', '.'); ?></th>
										</tr>
									</tfoot>
								</table><!-- /.table -->
							
							<?php
								}
							?>


                                                                
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
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>-->
<style>
    .dataTables_wrapper,
    .dataTables_filter {
        text-align: right;
        float: left !important;
    }

    .dataTables_wrapper {
        position: relative;
        clear: both;
        *zoom: 1;
        zoom: 1;
        width: 100%;
        text-align: left;
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

        //$.fn.dataTable.moment( 'DD/MM/YYYY' );
        var $table = $('#invoice_table').DataTable({
            ordering: true,
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
            columns: [
                null,
                null,
                null,
                null,
                null,
                { "sType": "date-uk" },
                { "sType": "date-uk" },
                null,
                null
            ],
            language: {
                "url": "<?php echo base_url('backend/dist/datatables/Portuguese-Brasil.json'); ?>",
                 "decimal": ",",
                "thousands": "."
            },
            footerCallback: function(row, data, start, end, display) {
                var api = this.api(),data;


                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[R\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                var sum = 0;
               

                api
                    .column(8, {
                        page: 'current'
                    })
                    .data()
                    .filter((a, k) => {
                        return k < end
                    })
                    .map((a) => {
                     
                        sum += $(a).data('total')
                    })


                $('.dataTables_wrapper table > tfoot').show()
              

               // $(api.column(8).footer()).html(accounting.formatMoney(sum, "", 2, ".", ","))
                $(api.column(8).footer()).html( "R$ <?php echo number_format($total, 2, ',', '.'); ?>" );

                
            }
        });
        
        
    
	$("#totalValor").html("R$ <?php echo number_format($total, 2, ',', '.'); ?>");
	
});
	
        
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-uk-pre": function ( a ) {
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            },

            "date-uk-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-uk-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        } );
	
	
</script>

