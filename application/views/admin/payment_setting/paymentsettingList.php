<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?> </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-9">
                <div class="nav-tabs-custom box box-primary theme-shadow">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#tab_9" data-toggle="tab">Banco Inter</a></li>
                        <li><a href="#tab_8" data-toggle="tab">Paytm</a></li>
                        <li><a href="#tab_7" data-toggle="tab">Razorpay</a></li>
                        <li><a href="#tab_6" data-toggle="tab">Paystack</a></li>
                        <li><a href="#tab_5" data-toggle="tab">InstaMojo</a></li>

                        <li><a href="#tab_4" data-toggle="tab">CCAvenue</a></li>
                        <li><a href="#tab_3" data-toggle="tab">PayU</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Stripe</a></li>
                        <li><a href="#tab_1" data-toggle="tab">Paypal</a></li>

                        <li class="pull-left header"><i class="fa fa-mobile"></i> <?php echo $this->lang->line('payment_methods'); ?></li>
                    </ul>
                    <div class="tab-content pb0">

                        <div class="tab-pane" id="tab_1">
                            <form role="form" id="paypal" action="<?php echo site_url('admin/paymentsettings/paypal') ?>" class="form-horizontal" method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $paypal_result = check_in_array('paypal', $paymentlist);
                                                ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paypal_username'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input autofocus="" id="name" name="paypal_username" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paypal_result->api_username) ? $paypal_result->api_username : ""; ?>" />
                                                        <span class=" text text-danger paypal_username_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paypal_password'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input id="name" name="paypal_password" placeholder="" type="password" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paypal_result->api_password) ? $paypal_result->api_password : ""; ?>" />
                                                        <span class=" text text-danger paypal_password_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paypal_signature'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input id="name" name="paypal_signature" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paypal_result->api_signature) ? $paypal_result->api_signature : ""; ?>" />
                                                        <span class=" text text-danger paypal_signature_error"></span>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://www.paypal.com/in/home" target="_blank"><img src="<?php echo base_url() ?>backend/images/paypal.png" width="200">
                                                    <p>https://www.paypal.com</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 paypal_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <form role="form" id="stripe" id="stripe" action="<?php echo site_url('admin/paymentsettings/stripe') ?>" class="form-horizontal" method="post">
                                <div class="box-body minheight149">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $stripe_result = check_in_array('stripe', $paymentlist);
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('stripe_api_secret_key'); ?><small class="req"> *</small></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="api_secret_key" value="<?php echo isset($stripe_result->api_secret_key) ? $stripe_result->api_secret_key : ""; ?>">
                                                        <span class=" text text-danger api_secret_key_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">
                                                        <?php echo $this->lang->line('stripe_publishable_key'); ?><small class="req"> *</small></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="api_publishable_key" value="<?php echo isset($stripe_result->api_publishable_key) ? $stripe_result->api_publishable_key : ""; ?>">
                                                        <span class=" text text-danger api_publishable_key_error"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://stripe.com/" target="_blank"><img src="<?php echo base_url() ?>backend/images/stripe.png">
                                                    <p>https://stripe.com</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 stripe_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            <form role="form" id="payu" id="custom" action="<?php echo site_url('admin/paymentsettings/payu') ?>" class="form-horizontal" method="post">
                                <div class="box-body minheight149">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $payu_result = check_in_array('payu', $paymentlist);
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('payu_money_key'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="key" value="<?php echo isset($payu_result->api_secret_key) ? $payu_result->api_secret_key : ""; ?>">
                                                        <span class="text text-danger key_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('payu_money_salt'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="salt" value="<?php echo isset($payu_result->salt) ? $payu_result->salt : ""; ?>">
                                                        <span class="text text-danger salt_error"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://www.payumoney.com" target="_blank"><img src="<?php echo base_url() ?>backend/images/paym.png">
                                                    <p>https://www.payumoney.com</p>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 payu_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="tab_4">
                            <form role="form" id="ccavenue" action="<?php echo site_url('admin/paymentsettings/ccavenue') ?>" class="form-horizontal" method="post">
                                <div class="box-body minheight149">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $ccavenue_result = check_in_array('ccavenue', $paymentlist);
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('merchant_id'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="ccavenue_secret" value="<?php echo isset($ccavenue_result->api_secret_key) ? $ccavenue_result->api_secret_key : ""; ?>">
                                                        <span class="text text-danger ccavenue_secret_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('working_key'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="ccavenue_salt" value="<?php echo isset($ccavenue_result->salt) ? $ccavenue_result->salt : ""; ?>">
                                                        <span class="text text-danger ccavenue_salt_error"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://www.ccavenue.com" target="_blank"><img src="<?php echo base_url() ?>backend/images/ccavenue.png" width="200">
                                                    <p>https://www.ccavenue.com</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 ccavenue_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="tab_5">
                            <form role="form" id="instamojo" action="<?php echo site_url('admin/paymentsettings/instamojo') ?>" class="form-horizontal" method="post">
                                <div class="box-body minheight149">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $instamojo_result = check_in_array('instamojo', $paymentlist);
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('private_api_key'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="instamojo_apikey" value="<?php echo isset($instamojo_result->api_secret_key) ? $instamojo_result->api_secret_key : ""; ?>">
                                                        <span class="text text-danger instamojo_apikey_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('private_auth_token'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="instamojo_authtoken" value="<?php echo isset($instamojo_result->api_publishable_key) ? $instamojo_result->api_publishable_key : ""; ?>">
                                                        <span class="text text-danger instamojo_authtoken_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label"><?php echo $this->lang->line('private_salt'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="instamojo_salt" value="<?php echo isset($instamojo_result->salt) ? $instamojo_result->salt : ""; ?>">
                                                        <span class="text text-danger instamojo_salt_error"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://www.instamojo.com/" target="_blank"><img src="<?php echo base_url() ?>backend/images/instamojo.png" width="200">
                                                    <p>https://www.instamojo.com/</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 instamojo_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane " id="tab_6">
                            <form role="form" id="paystack" action="<?php echo site_url('admin/paymentsettings/paystack') ?>" class="form-horizontal" method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $paystack_result = check_in_array('paystack', $paymentlist);
                                                //print_r($paystack_result);die;

                                                ?>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paystack_secret_key'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="paystack_secretkey" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paystack_result->api_secret_key) ? $paystack_result->api_secret_key : ""; ?>" />
                                                        <span class=" text text-danger paystack_secretkey_error"></span>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://paystack.com/" target="_blank"><img src="<?php echo base_url(); ?>/backend/images/paystack.png" width="200">
                                                    <p>https://paystack.com</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 paystack_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane " id="tab_7">
                            <form role="form" id="razorpay" action="<?php echo site_url('admin/paymentsettings/razorpay') ?>" class="form-horizontal" method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $razorpay_result = check_in_array('razorpay', $paymentlist);
                                                //print_r($paystack_result);die;

                                                ?>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('razorpay_key_id'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="razorpay_keyid" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($razorpay_result->api_publishable_key) ? $razorpay_result->api_publishable_key : ""; ?>" />
                                                        <span class=" text text-danger razorpay_keyid_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('razorpay_key_secret'); ?><small class="req"> *</small>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="razorpay_secretkey" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($razorpay_result->api_secret_key) ? $razorpay_result->api_secret_key : ""; ?>" />
                                                        <span class=" text text-danger razorpay_secretkey_error"></span>
                                                    </div>
                                                </div>



                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://razorpay.com/" target="_blank"><img src="<?php echo base_url(); ?>/backend/images/razorpay.jpg" width="200">
                                                    <p>https://razorpay.com/</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 razorpay_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane " id="tab_8">
                            <form role="form" id="paytm" action="<?php echo site_url('admin/paymentsettings/paytm') ?>" class="form-horizontal" method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $paytm_result = check_in_array('paytm', $paymentlist);


                                                ?>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paytm_merchant_id'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="paytm_merchantid" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paytm_result->api_publishable_key) ? $paytm_result->api_publishable_key : ""; ?>" />
                                                        <span class=" text text-danger paytm_merchantid_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paytm_merchant_key'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="paytm_merchantkey" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paytm_result->api_secret_key) ? $paytm_result->api_secret_key : ""; ?>" />
                                                        <span class=" text text-danger paytm_merchantkey_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('paytm_website'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="paytm_website" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paytm_result->paytm_website) ? $paytm_result->paytm_website : ""; ?>" />
                                                        <span class=" text text-danger paytm_website_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('indusrty_type'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="paytm_industrytype" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($paytm_result->paytm_industrytype) ? $paytm_result->paytm_industrytype : ""; ?>" />
                                                        <span class=" text text-danger paytm_industrytype_error"></span>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://paytm.com/" target="_blank"><img src="<?php echo base_url(); ?>/backend/images/paytm.jpg" width="200">
                                                    <p>https://paytm.com/</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 paytm_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="tab_9">
                            <form role="form" id="banco_inter" action="<?php echo site_url('admin/paymentsettings/banco_inter') ?>" class="form-horizontal" method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-7">
                                                <?php
                                                $banco_inter_result = check_in_array('banco_inter', $paymentlist);

                                                ?>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('account_no_document'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_api_username" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->api_username) ? $banco_inter_result->api_username : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_api_username_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('account_no'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_account_no" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->account_no) ? $banco_inter_result->account_no : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_account_no_error"></span>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" for="exampleInputEmail1">
                                                        <?php echo $this->lang->line('certificate_pem_path'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_api_secret_key" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->api_secret_key) ? $banco_inter_result->api_secret_key : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_api_secret_key_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                                        <?php echo $this->lang->line('certificate_key_path'); ?>
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_api_publishable_key" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->api_publishable_key) ? $banco_inter_result->api_publishable_key : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_api_publishable_key_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                                        <?php echo $this->lang->line('certificate_key_password'); ?>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_api_password" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->api_password) ? $banco_inter_result->api_password : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_api_password_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                                        <?php echo $this->lang->line('inter_juros'); ?>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_pay_fine" placeholder="" data-mask-reverse="true" data-mask="#0.00%" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->pay_fine) ? $banco_inter_result->pay_fine : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_pay_fee_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                                        <?php echo $this->lang->line('inter_moura'); ?>
                                                    </label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_pay_moura" data-mask="#0.00%" data-mask-reverse="true" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->pay_moura) ? $banco_inter_result->pay_moura : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_pay_moura_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                                        Client ID
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_api_email" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->api_email) ? $banco_inter_result->api_email : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_api_email_error"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                                        Client Secret
                                                        <small class="req"> *</small></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input name="banco_inter_salt" placeholder="" type="text" class="form-control col-md-7 col-xs-12" value="<?php echo isset($banco_inter_result->salt) ? $banco_inter_result->salt : ""; ?>" />
                                                        <span class=" text text-danger banco_inter_salt_error"></span>
                                                    </div>
                                                </div>



                                            </div>
                                            <div class="col-md-5 text text-center disblock">
                                                <a href="https://www.bancointer.com.br/" target="_blank"><img src="<?php echo base_url(); ?>/backend/images/bank-inter.svg" width="200">
                                                    <p>https://www.bancointer.com.br/</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                        <button type="submit" class="btn btn-primary col-md-offset-3 banco_inter_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo site_url('admin/paymentsettings/setting') ?>" id="payment_gateway" method="POST">
                        <div class="box-body minheight199">
                            <div class="form-group">
                                <!-- Radio group !-->
                                <?php
                                $radio_check = check_selected($paymentlist);
                                ?>

                                <label class="control-label"><?php echo $this->lang->line('select_payment_gateway'); ?></label>

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="paypal" <?php
                                                                                                    if ($radio_check == 'paypal') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                        Paypal
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="stripe" <?php
                                                                                                    if ($radio_check == 'stripe') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                        Stripe
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="payu" <?php
                                                                                                if ($radio_check == 'payu') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                                ?>>
                                        PayU
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="ccavenue" <?php
                                                                                                    if ($radio_check == 'ccavenue') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                        CCAvenue
                                    </label>
                                </div>

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="instamojo" <?php
                                                                                                        if ($radio_check == 'instamojo') {
                                                                                                            echo "checked";
                                                                                                        }
                                                                                                        ?>>
                                        Instamojo
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="paystack" <?php
                                                                                                    if ($radio_check == 'paystack') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                        Paystack
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="razorpay" <?php
                                                                                                    if ($radio_check == 'razorpay') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                        Razorpay
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="paytm" <?php
                                                                                                    if ($radio_check == 'paytm') {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                                        Paytm
                                    </label>
                                </div>

                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="banco_inter" <?php
                                                                                                        if ($radio_check == 'banco_inter') {
                                                                                                            echo "checked";
                                                                                                        }
                                                                                                        ?>>
                                        Banco inter
                                    </label>
                                </div>
                                <span class="text text-danger payment_setting_error"></span>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="payment_setting" value="none" <?php
                                                                                                if ($radio_check == 'none') {
                                                                                                    echo "checked";
                                                                                                }
                                                                                                ?>>
                                        None
                                    </label>
                                </div>


                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <?php if ($this->rbac->hasPrivilege('payment_methods', 'can_edit')) { ?>
                                <button type="submit" class="btn btn-primary pull-right payment_gateway_save" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $this->lang->line('save'); ?>"><?php echo $this->lang->line('save'); ?></button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php

function check_selected($array)
{
    $selected = "none";
    if (!empty($array)) {

        foreach ($array as $a => $element) {
            if ($element->is_active == "yes") {
                $selected = $element->payment_type;
            }
        }
    }
    return $selected;
}

function check_in_array($find, $array)
{
    if (!empty($array)) {

        foreach ($array as $element) {

            if ($find == $element->payment_type) {
                return $element;
            }
        }
    }
    $object = new stdClass();
    $object->id = "";
    $object->type = "";
    $object->api_id = "";
    $object->username = "";
    $object->url = "";
    $object->name = "";
    $object->contact = "";
    $object->password = "";
    $object->authkey = "";
    $object->senderid = "";
    $object->is_active = "";
    return $object;
}
?>


<script type="text/javascript">
    $("#payment_gateway").submit(function(e) {
        $("[class$='_error']").html("");

        var $this = $(".payment_gateway_save");
        $this.button('loading');
        var url = $(this).attr('action'); // the script where you handle the form input.

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#payment_gateway").serialize(), // serializes the form's elements.
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
                //if fails      
            },
            complete: function() {
                $this.button('reset');
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });



    $("#paypal").submit(function(e) {
        $("[class$='_error']").html("");

        var $this = $(".paypal_save");
        $this.button('loading');
        var url = $(this).attr('action'); // the script where you handle the form input.

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#paypal").serialize(), // serializes the form's elements.
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
                //if fails      
            },
            complete: function() {
                $this.button('reset');
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#stripe").submit(function(e) {
        $("[class$='_error']").html("");

        var $this = $(".stripe_save");
        $this.button('loading');
        var url = $(this).attr('action'); // the script where you handle the form input.

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#stripe").serialize(), // serializes the form's elements.
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
                //if fails      
            },
            complete: function() {
                $this.button('reset');
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#payu").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".payu_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#payu").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });


    $("#twocheckout").submit(function(e) {
        $("[class$='_twocheckout_error']").html("");
        var $this = $(".twocheckout_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#twocheckout").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_twocheckout_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });



    $("#ccavenue").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".ccavenue_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#ccavenue").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });
    $("#paystack").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".paystack_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#paystack").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });

    $("#instamojo").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".instamojo_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#instamojo").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });



    $("#razorpay").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".razorpay_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#razorpay").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });

    $("#paytm").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".paytm_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#paytm").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });

    $("#banco_inter").submit(function(e) {
        $("[class$='_error']").html("");
        var $this = $(".banco_inter_save");
        $this.button('loading');
        var url = $(this).attr('action');

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: url,
            data: $("#banco_inter").serialize(),
            success: function(data, textStatus, jqXHR) {
                if (data.st === 1) {
                    $.each(data.msg, function(key, value) {
                        $('.' + key + "_error").html(value);
                    });
                } else {
                    successMsg(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".custom_loader").html("");
            },
            complete: function() {
                $this.button('reset');
            }
        });
        e.preventDefault();
    });
</script>