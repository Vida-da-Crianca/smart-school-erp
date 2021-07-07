<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?>     </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
             <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Adicionar Data de Corte</h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo site_url('admin/data_corte'); ?>" 
                              method="post" accept-charset="utf-8">
                            <input type="hidden" name="_submit" value="1" />
                            <div class="box-body">
                                <?php 
                                    echo ($this->session->flashdata('msg')) ? $this->session->flashdata('msg') : ''; 
                                    echo isset($error_message) ? "<div class='alert alert-danger'>" . $error_message . "</div>" : '';
                                ?>
                                <?php //echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('session'); ?></label><small class="req"> *</small>
                                    <?php echo form_dropdown('session_id',$sessionList, $session_id_atual, "id='' class='form-control'"); ?>
                                    <span class="text-danger"><?php echo form_error('session_id'); ?></span>
                                </div>

                                <div class = "row">
                                    <div class = "col-md-6 col-xs-12 col-sm-6">
                                        <label>Data Incial</label><small class="req"> *</small><br />
                                        <input type="text" 
                                               name="dataInicial" 
                                               id="dataInicial" 
                                               value="<?php echo date('d/m/Y'); ?>"
                                               placeholder=""
                                               class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('dataInicial'); ?></span>
                                    </div>
                                    <div class = "col-md-6 col-xs-12 col-sm-6">
                                        <label>Data Final</label><small class="req"> *</small><br />
                                        <input type="text" 
                                               name="dataFinal" 
                                               id="dataFinal" 
                                               value="<?php echo date('d/m/Y'); ?>"
                                               placeholder=""
                                               class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('dataFinal'); ?></span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                    <?php echo form_dropdown('class_id',$classList, '', "id='' class='form-control'"); ?>
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div>
            
            <div class="col-md-8">
                
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Datas de Corte</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label">Datas de Corte</div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>

                                        <th>Sessão
                                        </th>
                                        <th>Data Inicial
                                        </th>
                                        <th>Data Final
                                        </th>
                                        <th>Turma
                                        </th>

                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                 <tbody>
                                     <?php foreach($dataCorteList as $row ): ?>
                                     <tr>
                                         <td>
                                            <?php echo $row->sessionName; ?>
                                         </td>
                                         <td>
                                            <?php echo $row->dataInicialBr; ?>
                                         </td>
                                         <td>
                                            <?php echo $row->dataFinalBr; ?>
                                         </td>
                                         <td>
                                            <?php echo $row->className; ?>
                                         </td>
                                         <td class="mailbox-date pull-right">
                                             <a data-placement="left" href="<?php echo base_url(); ?>admin/data_corte/delete/<?php echo $row->idDataCorte; ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('Confirma a exclusão?');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                         </td>
                                     </tr>
                                     <?php endforeach; ?>
                                 </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
                
            
            
        </div>
    </section>
</div>
<script type='text/javascript'>
$(document).ready(function(){

    var date_format = 'dd/mm/yyyy';
    $('#dataInicial').mask('99/99/9999');
    $('#dataFinal').mask('99/99/9999');        
   

});
</script>
