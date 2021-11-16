    <?php error_reporting(E_ALL & ~E_NOTICE); ?>
    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                <i class="fa fa-line-chart"></i> <?php echo $this->lang->line('reports'); ?> <small> <?php echo $this->lang->line('filter_by_name1'); ?></small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            
            
        
            
            
            <div class="row">
                <div class="col-md-12">

                    <div class="box removeboxmius">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i>
Relatório de Custo por Turma/Aluno</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" action="<?php echo site_url('report/custo_turma_aluno') ?>" method="post" class="">
                                <div class="row">

                                    <?php echo $this->customlib->getCSRF(); ?>

                                    <div class="col-sm-2 col-md-2">
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
                                                                           data-value="<?php echo $class['id'] ?>" data-label="<?php echo $class['class'] ?>" <?php if (in_array($class['id'], $class_id_option)) echo "checked" ?> name="class_id_option[]" value="<?php echo $class['id']; ?>" />&nbsp;<?php echo $class['class'] ?>
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
                                        <label>Data Inicial<small class="req"> *</small></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control idate" id="name" name="start" value="<?php
                                                                                                                        echo set_value('start',date('01-m-Y'))
                                                                                                                        ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Data Final</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control idate" id="date_end" name="end" value="<?php
                                                                                                                        echo set_value('end',date('01-m-Y'))
                                                                                                                        ?>">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Tipo de Data</label>
                                        <div class="input-group">
                                            <?php echo form_dropdown('type_date',array(1=>'Data de Vencimento',2=>'Data de Recebimento'), $type_date, "id='type_date' class='form-control'"); ?>

                                        </div>
                                    </div>
                                        
                                   
                                    <div class="col-sm-2 col-md-2">
                                        <Br />
                                         <div class="row">
                                                <div class="col-xs-12 ">
                                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                     
                                                </div>
                                         </div>
                                             
                                    </div>
                                   
                                </div>
                                <!--./row-->
                            </form>
                        </div>
                        <!--./box-body-->
                        
                        
                        
                        
                        
                        <?php if($despesas || $vagasTurmas): ?>
                            <div class="box box-primary">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix">Resultados:</h3>
                                    <div class="box-tools pull-right">
                                    </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body" style="max-width:100% !important;">
                                    
                                    <div class="table table-responsive">

                                            <table class="table table-bordered table-hover table-striped">

                                                <thead>
                                                    <tr>
                                                        <th>Tipo de Despesa</th>
                                                        <th class="text-right">Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $totalDespesas = 0 ; foreach ($despesas as $row): ?>
                                                        <tr>
                                                            <td><?php echo $row->exp_category; ?></td>
                                                            <td class="text-right">
                                                                <span class="small">R$</span> 
                                                                <?php echo number_format($row->total_amount, 2, ',', '.'); $totalDespesas+=$row->total_amount; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                
                                                    <tr>
                                                        <td></td>
                                                        <td class="bg-info text-right">
                                                            <b>
                                                                <span class='small'>R$</span>
                                                                    <?php echo number_format($totalDespesas, 2, ',', '.'); ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                               
                                            </table>
                                        
                                        <hr />
                                        
                                        
                                         <div class="table table-responsive">

                                            <table class="table table-bordered table-hover table-striped">

                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="2" class="text-center th-group">
                                                            TOTAL
                                                        </th>
                                                        <th colspan="2" class="text-center th-group">
                                                            OCUPADAS
                                                        </th>
                                                        <th colspan="2" class="text-center th-group">
                                                            DISPONÍVEIS
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Turma</th>
                                                        <th class="text-center">Vagas</th>
                                                        <th class="text-right">Custo</th>
                                                        <th class="text-center">Vagas</th>
                                                        <th class="text-right">Custo</th>
                                                        <th class="text-center">Vagas</th>
                                                        <th class="text-right">Custo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $v = $o = $d = $t1 = $t2 = $t3 = 0;foreach ($vagasTurmas as $row): ?>
                                                        <tr>
                                                            <td><?php echo $row->className; ?></td>
                                                            <td class="text-center"><?php echo $row->quantidadeVagas; $v+= $row->quantidadeVagas; ?></td>
                                                            <td class="text-right">
                                                                <span class="small">R$</span> 
                                                                <?php echo number_format($totalDespesas  / ($row->quantidadeVagas > 0 ? $row->quantidadeVagas :  1), 2, ',', '.');  $t1 += ($totalDespesas  / ($row->quantidadeVagas > 0 ? $row->quantidadeVagas :  1));?>
                                                            </td>
                                                            <td class="text-center"><?php echo ($row->alunosNaoIntegral/2) + $row->alunosIntegral; $o += (($row->alunosNaoIntegral/2) + $row->alunosIntegral);?></td>
                                                            <td class="text-right">
                                                                <span class="small">R$</span> 
                                                                <?php  $v1 = (($row->alunosNaoIntegral/2) + $row->alunosIntegral); ?>
                                                                <?php echo number_format($totalDespesas / ($v1 > 0 ? $v1 : 1), 2, ',', '.'); $t2 += ($totalDespesas / ($v1 > 0 ? $v1 : 1));?>
                                                            </td>
                                                            <td class="text-center"><?php echo $row->quantidadeVagas - (($row->alunosNaoIntegral/2) + $row->alunosIntegral); $d += ($row->quantidadeVagas - (($row->alunosNaoIntegral/2) + $row->alunosIntegral)); ?></td>
                                                            <td class="text-right">
                                                                <span class="small">R$</span> 
                                                                <?php $v1 = ($row->quantidadeVagas - (($row->alunosNaoIntegral/2) + $row->alunosIntegral)); ?>
                                                                <?php echo number_format($totalDespesas / ($v1 > 0 ? $v1 : 1), 2, ',', '.'); $t3 += ($totalDespesas / ($v1 > 0 ? $v1 : 1));?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                               
                                                    <tr>
                                                        <td></td>
                                                        <td class="bg-info text-center">
                                                            <b>
                                                               <?php echo $v; ?>
                                                            </b>
                                                        </td>
                                                         <td class="bg-info text-right">
                                                            <b>
                                                                <span class="small">R$</span> 
                                                                    <?php echo number_format($totalDespesas / ($v > 0 ? $v : 1), 2, ',', '.'); ?>
                                                            </b>
                                                        </td>
                                                        <td class="bg-info text-center">
                                                            <b>
                                                               <?php echo $o; ?>
                                                            </b>
                                                        </td>
                                                         <td class="bg-info text-right">
                                                            <b>
                                                                <span class="small">R$</span> 
                                                                    <?php //echo number_format($t2, 2, ',', '.'); ?>
                                                                 <?php echo number_format($totalDespesas / ($o > 0 ? $o : 1), 2, ',', '.'); ?>
                                                            </b>
                                                        </td>
                                                        <td class="bg-info text-center">
                                                            <b>
                                                               <?php echo $d; ?>
                                                            </b>
                                                        </td>
                                                         <td class="bg-info text-right">
                                                            <b>
                                                                <span class="small">R$</span> 
                                                                    <?php //echo number_format($t3, 2, ',', '.'); ?>
                                                                  <?php echo number_format($totalDespesas / ($d > 0 ? $d : 1), 2, ',', '.'); ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                               
                                            </table>

                                        </div>
                                    

                                        </div>
                                    
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
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

});
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
