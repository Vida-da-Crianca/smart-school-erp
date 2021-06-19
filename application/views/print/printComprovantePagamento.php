<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style type="text/css">
    .page-break	{ display: block; page-break-before: always; }
    
</style>

<html lang="en">
    <head>
        <title><?php echo $this->lang->line('fees_receipt'); ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/AdminLTE.min.css">
    </head>
    <body style="padding: 0px; margin: 0px;">     
       
        
        <div class="container" style="width: 100%;">
    
    <div id="content" class="col-lg-12 col-sm-12 ">
        <div class="invoice">
            <div class="header ">
               
                    <?php
                    ?>

                    <img  src="<?php echo base_url(); ?>/uploads/print_headerfooter/student_receipt/<?php $this->setting_model->get_receiptheader(); ?>" style="height: 100px;width: 100%;">
                    <?php
                    ?>
              

            </div>
            
            
         
            <table class="table table-striped mb0 font13">
                        <tbody>
                            <tr>
                                <th class="bozero"><?php echo $this->lang->line('name'); ?></th>
                                <td class="bozero"><?php echo $student['firstname'] . " " . $student['lastname'] ?></td>

                                <th class="bozero"><?php echo $this->lang->line('class_section'); ?></th>
                                <td class="bozero"><?php echo $student['class'] . " (" . $student['section'] . ")" ?> </td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('guardian_name'); ?></th>
                                <td><?php echo $student['guardian_name']; ?></td>
                                <th><?php echo $this->lang->line('admission_no'); ?></th>
                                <td><?php echo $student['admission_no']; ?> | <b>RA: </b> <?php echo $student['roll_no']; ?></td>
                            </tr>


                        </tbody>
                    </table>
                
            <hr />
            
           
                      <?php 
                      
                        //var_dump($fee_value);
                      
                        $fee_paid = 0;
                        $fee_discount = 0;
                        $fee_fine = 0;
                        $feetype_balance = -1;
                        $description = $fee_value->name . " (" . $fee_value->type . ")";
                        
                        
                        if ($fee_value->deposite) {
                            $fee_deposits = json_decode(($fee_value->deposite->amount_detail));

                            foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                $fee_paid = $fee_paid + ($fee_deposits_value->amount - $fee_deposits_value->amount_discount) + $fee_deposits_value->amount_fine;
                                $fee_discount +=  $fee_deposits_value->amount_discount;
                                $fee_fine +=  $fee_deposits_value->amount_fine;
                            }
                        }
                        
                        $feetype_balance = number_format($fee_value->amount, 2) - number_format(($fee_paid + $fee_discount), 2) + $fee_fine;
                                           
                      ?>
                      
                      <div class="table table-responsive">

                          <table class="table table-striped mb0 " style="font-size: 12px;">
                                <thead class="header">
                                    <tr>
                                        
                                        <th align="left"><?php echo $this->lang->line('fees_item_code'); ?></th>
                                        <th align="left"><?php echo $this->lang->line('fees_group'); ?></th>
                                        <!-- <th align="left"><?php echo $this->lang->line('fees_code'); ?></th> -->
                                        <th align="left" class="text text-left"><?php $this->lang->line('due_date'); ?></th>
                                        <th align="left" class="text text-left"><?php echo $this->lang->line('status'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('amount') ?>
                                            <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <!-- <th class="text text-left"><?php echo $this->lang->line('payment_id'); ?></th> -->
                                        <th class="text text-left"><?php echo $this->lang->line('mode'); ?></th>
                                        <th class="text text-left"><?php echo $this->lang->line('date'); ?></th>
                                        <th class="text text-right"><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('paid'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                       
                                    </tr>
                                </thead>
                              
                              <?php
                                            if ($feetype_balance > 0 && strtotime($fee_value->due_date) < strtotime(date('Y-m-d'))) {
                                            ?>
                                   <tr class="danger font12">
                                                <?php
                                            } else {
                                                ?>
                                   <tr class="dark-gray">
                                                <?php
                                            }
                                                ?>
                                               
                                                <td align="left">
                                                    <?php
                                                    echo $fee_value->id;
                                                    if ($fee_value->billet->count() > 0) {
                                                        echo '<br/><small class="text-success">' . $fee_value->billet->first()->bank_bullet_id . '</small>';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="left"><?php
                                                                    echo $fee_value->title;
                                                                    ?></td>
                                                <!-- <td align="left"><?php echo $fee_value->code; ?></td> -->
                                                <td align="left" class="text text-left">

                                                    <?php
                                                    if ($fee_value->due_date == "0000-00-00") {
                                                    } else {

                                                        echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_value->due_date));
                                                    }
                                                    ?>
                                                </td>
                                                <td align="left" class="text text-left width85">
                                                    <?php
                                                   
                                                    if ($feetype_balance == 0) {
                                                    ?><span class="label label-success"><?php echo $this->lang->line('paid'); ?>
                                                        </span>
                                                    <?php } else if (!empty($fee_value->deposite)) { ?>
                                                        <span class="label label-warning">
                                                            <?php echo $this->lang->line('partial'); ?></span>
                                                    <?php
                                                    } else { ?>
                                                        <span class="label label-danger">
                                                            <?php echo $this->lang->line('unpaid'); ?>
                                                        </span><?php
                                                            }
                                                                ?>
                                                </td>
                                                <td class="text text-right"><?php echo $fee_value->amountReal; ?></td>

                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-left"></td>
                                                <td class="text text-right"><?php
                                                                            echo (number_format($fee_discount, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"><?php
                                                                            echo (number_format($fee_fine, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"><?php
                                                                            echo (number_format($fee_paid, 2, '.', ''));
                                                                            ?></td>
                                                <td class="text text-right"><?php
                                                                            $display_none = "ss-none";
                                                                            if ($feetype_balance > 0) {
                                                                                $display_none = "";

                                                                                echo (number_format($feetype_balance, 2, '.', ''));
                                                                            }
                                                                            ?>

                                                </td>
                                 </tr>
                                 
                                 
                                 
                                 <?php
                                                  
                                                $recebidoPorId = 0;
                                                $recebidoPorText = '';
                                                $dataRecebimento = '';
                                 
                                                if (($fee_value->deposite)) {

                                                    $fee_deposits = json_decode(($fee_value->deposite->amount_detail));


                                                    foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                                                ?>
                                                        <tr class="white-td">

                                                           
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td align="left"></td>
                                                            <td class="text-right"><img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                                                            <td class="text text-left">


                                                                <?php echo $fee_value->student_fees_deposite_id . "/" . $fee_deposits_value->inv_no; ?>
                                                                <div class="fee_detail_popover" style="display: none">
                                                                    <?php
                                                                    if ($fee_deposits_value->description == "") {
                                                                    ?>
                                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <p class="text text-info"><?php echo $fee_deposits_value->description; ?> </p>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>


                                                            </td>

                                                            <td class="text text-left">
                                                                <?php 

                                                                        $recebidoPorId = isset($fee_deposits_value->received_by) ? (int) $fee_deposits_value->received_by : 0;
                                                                        $recebidoPorTexto = isset($fee_deposits_value->received_by) ? $fee_deposits_value->received_by : '';
                                                                        $dataRecebimento = isset($fee_deposits_value->date) ? $fee_deposits_value->date : date('Y-m-d');   
                                                                ?>
                                                                <?php

                                                                echo $this->lang->line(strtolower($fee_deposits_value->payment_mode)); ?></td>
                                                            <td class="text text-left">

                                                                <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_deposits_value->date)); ?>
                                                            </td>
                                                            <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_discount, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_fine, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount, 2, '.', '')); ?></td>
                                                            <td></td>
                                                           
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                 
                              
                              
                              
                          </table>

                      </div>
                      
                   
            <br /><br /><br />
            <b>Recebido por: </b>
            <?php if((int)$recebidoPorId > 0){ 
                
                    $res = $this->db->where('id',$recebidoPorId)->get('staff')->result();
                    echo count($res) > 0 ? $res[0]->name : $recebidoPorTexto;
                    
                }else{
                    echo $recebidoPorTexto;
                }
            
            ?>
            
            &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; <b>Data:</b>
            <?php 
                $dt = new DateTime($dataRecebimento);
                echo   $dt->format('d/m/Y');
            ?>
                
                
                
                
                
                
            
            <?php //var_dump($student); ?>
            
        </div>
    </div>
    
    
    
  </div>
        <div class="clearfix"></div>
        <footer>           
        </footer>
    </body>
</html>
    
            
            
            
            