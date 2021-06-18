<style type="text/css">
    .wrapper {
        overflow: visible;
    }
</style>


<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-gears"></i>Recebimentos Previstos</h1>
    </section>
    
    
    <!-- Main content -->
    <section class="content">
        
         <!-- Menu de relatorios -->   
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
        </div><!-- Menu de relatorios -->   
        
        <br />
        <!-- Filtros -->
        <div class="box box-primary">
            <div class="box-header ptbnull">
                <h3 class="box-title titlefix"><i class="fa fa-calendar"></i> Recebimentos Previstos</h3>
            </div>
            <form  action="<?php echo site_url('report/recebimentos_previstos') ?>" 
                   method="POST" class="">
                <input type="hidden" name="gerarRelatorio" value="1" />
                <div class="box-body">
                   
                  
                    
                    
                    <div class = "row">
                        <div class="col-md-2 form-group">
                          
                                    <label><?php echo $this->lang->line('session') ; ?></label>
                                    <?php
                                    print(form_dropdown('option_session_id', $options_session, $option_session_id, 'class="form-control" '));
                                    ?>
                                    
                              
                        </div>
                        <div class="col-sm-4 col-md-2">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                <div class="row">
                                    <div class="col-xs-12 dropdown" id="classDropdown">
                                        <div class="button-group w-full" data-toggle="dropdown">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span data-default="Selecione uma turma" class="dropdown-label">Selecione uma turma</span> <span class="caret"></span>
                                            </button>
                                        </div>
                                        <ul class="dropdown-menu">
                                            <?php
                                            foreach ($classlist as $class) {
                                            ?>
                                                <li class="ui-checkbox">
                                                    <label class="small control control-checkbox" data-value="<?php echo $class['id'] ?>">
                                                        <input type="checkbox" 
                                                               data-value="<?php echo $class['id'] ?>" 
                                                               data-label="<?php echo $class['class'] ?>" 
                                                                   <?php if (in_array($class['id'], $class_id_option)) echo "checked" ?> 
                                                               name="class_id_option[]" value="<?php echo $class['id']; ?>" />&nbsp;<?php echo $class['class'] ?>
                                                        <div class="control_indicator"></div>
                                                    </label>
                                                </li>

                                            <?php

                                            }
                                            ?>


                                        </ul>
                                    </div>

                                    <span class="text-danger"><?php echo form_error('class_id_option[]'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Data Venc. Inicial</label>
                            <div class="input-group date">
                                <input type="text" class="form-control idate" id="name" name="start" 
                                       value="<?php echo isset($_POST['start']) ? trim($_POST['start']) : date('01-m-Y');  ?>">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Data Venc. Final</label>
                            <div class="input-group date">
                                <input type="text" class="form-control idate" id="date_end" name="end" 
                                       value="<?php echo isset($_POST['end']) ? trim($_POST['end']) : date('t-m-Y');  ?>">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Boleto?</label>
                            <?php echo form_dropdown('with_billet',[99=>'Todos',1=>'Apenas COM Boleto',2=>'Apenas SEM Boleto'], isset($_POST['with_billet']) ? $_POST['with_billet'] : 99, "id='' class='form-control'"); ?>
                        </div>
                         <div class="col-md-2 form-group">
                            <label>Status</label>
                            <?php echo form_dropdown('status',[99=>'Todos',1=>'Apenas RECEBIDOS',2=>'Apenas EM ABERTO'], isset($_POST['status']) ? $_POST['status'] : 99, "id='' class='form-control'"); ?>
                        </div>
                    </div>
                    
                    
                </div>
                 <div class="box-footer">
                        <?php if ($this->rbac->hasPrivilege('billet_setting', 'can_edit')): ?>
                            <button type="submit" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo $this->lang->line('search'); ?></button>
                        <?php endif; ?>
                </div>
            </form>
        </div><!-- Filtros -->
        
        
        <?php if(isset($results)): ?>
        <div class="box box-primary">
            <div class="box-header ptbnull">
                <h3 class="box-title titlefix">Resultados:</h3>
                <div class="box-tools pull-right"></div>
            </div>
            <div class="box-body" style="max-width:100% !important;">
                <div class="table table-responsive">

                    <table id="results_table" class="dataTable display" role="grid" style="width: 100%;">
                            <thead class="header">
                                <tr>
                                    <th>Aluno</th>
                                    <th>Item</th>
                                    
                                    <th>nº Boleto</th>
                                    <th>nº Nota</th>
                                    
                                    <th>Vencimento</th>
                                    
                                    <th class="text-right">Valor</th>
                                    <th class="text-right">Valor Recebido</th>
                                    <th class="text-right">Valor à Receber</th>
                                    
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = $recebido = $receber = 0; foreach ($results as $row): 
                                    
                                    $exibir = true;
                                    
                                
                                    if($exibir):
                                  ?>
                                    <tr <?php echo $row->pago ? 'dark-gray' : 'danger font12'; ?>>
                                        <td>
                                            <?php echo $row->alunoNome; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->recebimentoNome; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->boletoNumero == 0 ? '---' : $row->boletoNumero; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->notaNumero == 0 ? '---' : $row->notaNumero; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->recebimentoDataVencimentoBr; ?>
                                        </td>
                                        
                                         <td class="text-right">
                                            <span class="small">R$</span> 
                                            <?php echo number_format($row->recebimentoValor, 2, ',', '.');  $total += $row->recebimentoValor; ?>
                                         </td>
                                         <td class="text-right">
                                            <span class="small">R$</span> 
                                            <?php echo number_format($row->valorRecebido, 2, ',', '.'); $recebido += $row->valorRecebido; ?>
                                         </td>
                                         <td class="text-right">
                                            <span class="small">R$</span> 
                                            <?php echo number_format($row->balanco, 2, ',', '.'); $receber += $row->balanco; ?>
                                         </td>
                                         <td class="text-right small">
                                             &nbsp;
                                              <?php echo $row->pago ? '<b class="text-success">RECEBIDO</b>' : '<b class="text-danger">EM ABERTO</b>'; ?>
                                         </td>
                                    </tr>
                                <?php endif; endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="bg-info text-right">
                                        <b>
                                            <span class='small'>R$</span>
                                            <?php echo number_format($total, 2, ',', '.'); ?>
                                        </b>
                                    </td>
                                    <td class="bg-info text-right">
                                        <b>
                                            <span class='small'>R$</span>
                                            <?php echo number_format($recebido, 2, ',', '.'); ?>
                                        </b>
                                    </td>
                                    <td class="bg-info text-right">
                                        <b>
                                            <span class='small'>R$</span>
                                            <?php echo number_format($receber, 2, ',', '.'); ?>
                                        </b>
                                    </td>
                                    <td></td>
                                </tr>
                             </tfoot>
                        </table>

                    </div>
            </div>
        </div>
        <?php endif; ?>
        
        
    </section><!-- Main content --> 
</div><!-- content-wrapper -->
<script type='text/javascript'>
$(document).ready(function(){
    
    
    function dropdownLabel() {
                var $element = $('#classDropdown .dropdown-label');
                var checkedOptions = [];
                var checkedIdOptions = [];
                var label = $element.data('default')
                $('#classDropdown input:checked').each(function(e) {

                    checkedOptions.push($(this).data('label'));
                    checkedIdOptions.push($(this).data('value'));
                })

                if (checkedOptions.length > 0) {
                    label = checkedOptions.slice(0, 2).join(', ');
                    if (checkedOptions.length > 2) {
                        label = `${label} <b> (+${checkedOptions.length - 2})</b>`
                    }

                    //getSectionByClass(checkedIdOptions);
                }

                $element.html(label);
                initializeObserveDropdown();
            }
            dropdownLabel();


            function initializeObserveDropdown() {
                $('.control').off('click.classID').on('click.classID', function(event) {
                    var $element = $(this).find('input');
                    var checked = $element.prop('checked');
                    $element.prop('checked', !checked);
                    // $(event.target).blur();
                    setTimeout(function() {
                        dropdownLabel();
                    }, 50)
                    // event.preventDefault();
                    return false;
                });
            };

   <?php if(isset($results)): ?>          
   var $table = $('#results_table').DataTable({
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
                { "sType": "date-uk" },               
                null,
                null,
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
                
                $('.dataTables_wrapper table > tfoot').show();
            }
        });
       <?php endif; ?> 

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
 <style>
        .w-full {
            width: 100% !important;
        }

        .w-full button {
            width: 100% !important;
            text-align: left;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        .ui-checkbox {
            padding: 0px 5px;
            
        }

        .control {
            font-family: arial;
            display: block;
            position: relative;
            padding-left: 25px;
            margin-bottom: 3px;
            padding-top: 1px;
            cursor: pointer;
            font-size: 13px;
        }

        .control input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .control_indicator {
            position: absolute;
            top: 1px;
            left: 0;
            height: 15px;
            width: 15px;
            background: #e6e6e6;
            border: 0px solid #000000;
            border-radius: 0px;
        }

        .control:hover input~.control_indicator,
        .control input:focus~.control_indicator {
            background: #cccccc;
        }

        .control input:checked~.control_indicator {
            background: #2a6a7b;
        }

        .control:hover input:not([disabled]):checked~.control_indicator,
        .control input:checked:focus~.control_indicator {
            background: '#0e6647d';
        }

        .control input:disabled~.control_indicator {
            background: #e6e6e6;
            opacity: 0.6;
            pointer-events: none;
        }

        .control_indicator:after {
            box-sizing: unset;
            content: '';
            position: absolute;
            display: none;
        }

        .control input:checked~.control_indicator:after {
            display: block;
        }

        .control-checkbox .control_indicator:after {
            left: 5px;
            top: 2px;
            width: 3px;
            height: 8px;
            border: solid #ffffff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .control-checkbox input:disabled~.control_indicator:after {
            border-color: #7b7b7b;
        }

        .control-checkbox .control_indicator::before {
            content: '';
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 4.5rem;
            height: 4.5rem;
            margin-left: -1.3rem;
            margin-top: -1.3rem;
            background: #2aa1c0;
            border-radius: 3rem;
            opacity: 0.6;
            z-index: 99999;
            transform: scale(0);
        }

        @keyframes s-ripple {
            0% {
                transform: scale(0);
            }

            20% {
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(1);
            }
        }

        @keyframes s-ripple-dup {
            0% {
                transform: scale(0);
            }

            30% {
                transform: scale(1);
            }

            60% {
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(1);
            }
        }

        .control-checkbox input+.control_indicator::before {
            animation: s-ripple 250ms ease-out;
        }

        .control-checkbox input:checked+.control_indicator::before {
            animation-name: s-ripple-dup;
        }

        .dropdown-menu{

            overflow-y: auto;
        }
    </style>

