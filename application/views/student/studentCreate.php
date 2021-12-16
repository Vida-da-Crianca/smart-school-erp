<!-- fontawesome -->
<script src="https://kit.fontawesome.com/0409d33244.js"></script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo $this->lang->line('student_information'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="pull-right box-tools impbtntitle">
                        <?php if ($this->rbac->hasPrivilege('import_student', 'can_view')) { ?>
                            <a href="<?php echo site_url('student/import') ?>">
                                <button class="btn btn-primary btn-sm"><i
                                            class="fa fa-upload"></i> <?php echo $this->lang->line('import_student'); ?>
                                </button>
                            </a>
                        <?php }
                        ?>
                    </div>
                    <form id="form1" onsubmit="return;"
                          action="#"
                          name="employeeform"
                          method="post" accept-charset="utf-8" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?php echo (int)$obj->id; ?>"/>
                        <?php if ($action == 'update'): ?>
                            <input type="hidden" name="studentid" value="<?php echo (int)$obj->id; ?>"/>
                        <?php endif; ?>
                        <input type="hidden" name="action" value="<?php echo $action; ?>"/>
                        <input type='hidden' name='_submit' value='yeap'>

                        <div class="">
                            <div class="bozero">
                                <h4 class="pagetitleh-whitebg">
                                    Matricular Aluno
                                </h4>
                                <div class="around10">
                                    <?php if ($this->session->flashdata('msg')) { ?>
                                        <?php echo $this->session->flashdata('msg') ?>
                                    <?php } ?>
                                    <?php if (isset($error_message)) { ?>
                                        <div class="alert alert-warning"><?php echo $error_message; ?></div>
                                    <?php } ?>
                                    <?php echo $this->customlib->getCSRF(); ?>
                                    <input type="hidden" name="sibling_name"
                                           value="<?php echo set_value('sibling_name'); ?>" id="sibling_name_next">
                                    <input type="hidden" name="sibling_id"
                                           value="<?php echo set_value('sibling_id', 0); ?>" id="sibling_id">


                                    <div class="row">
                                        <div class="col-md-10 col-xs-12 col-sm-10">


                                            <div class="row">
                                                <?php if (!$adm_auto_insert) { ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('admission_no'); ?></label>
                                                            <small class="req"> *</small>

                                                            <input autofocus="" id="admission_no"
                                                                   name="admission_no" placeholder="" type="text"
                                                                   class="form-control"
                                                                   value="<?php echo $obj->admission_no; ?>"/>
                                                            <span class="text-danger"><?php echo form_error('admission_no'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($sch_setting->roll_no) { ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('roll_no'); ?></label>
                                                            <input id="roll_no" name="roll_no" placeholder=""
                                                                   type="text" class="form-control"
                                                                   value="<?php echo $obj->roll_no; ?>"/>
                                                            <span class="text-danger"><?php echo form_error('roll_no'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome Completo</label><small
                                                                class="req"> *</small>
                                                        <input id="firstname" name="firstname" placeholder=""
                                                               type="text"
                                                               class="form-control"
                                                               value="<?php echo $obj->firstname; ?> <?php echo $obj->lastname; ?>"/>
                                                        <span class="text-danger"><?php echo form_error('firstname'); ?></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile"> <?php echo $this->lang->line('gender'); ?></label><small
                                                                class="req"> *</small>
                                                        <?php echo form_dropdown('gender', $genderList, $obj->gender, "id='' class='form-control'"); ?>
                                                        <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('date_of_birth'); ?></label><small
                                                                class="req"> *</small>
                                                        <input id="dob" name="dob" placeholder="" type="text"
                                                               class="form-control"
                                                               value="<?php echo $action == 'add' ? '' : $this->tools->formatarData($obj->dob, 'us', 'br'); ?>"/>
                                                        <span class="text-danger"><?php echo form_error('dob'); ?></span>
                                                    </div>
                                                </div>

                                            </div><!-- row -->


                                            <div class="row">

                                                <div class="col-md-2 col-xs-12 col-sm-2">
                                                    <label>Ano da Matrícula</label><small class="req"> *</small><br/>
                                                    <?php echo form_dropdown('session_id', $sessions, '', "id='session_id' class='form-control'"); ?>
                                                    <span class="text-danger"><?php echo form_error('session_id'); ?></span>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small
                                                                class="req"> *</small>
                                                        <?php echo form_dropdown('class_id', ['0' => '## Nenhuma Turma Disponível ###'], '', "id='class_id' class='form-control'"); ?>
                                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Período</label><small
                                                                class="req"> *</small>
                                                        <select id="section_id" name="section_id" class="form-control">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        </select>
                                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('admission_date'); ?></label>
                                                        <input id="admission_date"
                                                               name="admission_date" placeholder="" type="text"
                                                               class="form-control"
                                                               value="<?php echo $this->tools->formatarData($obj->admission_date, 'us', 'br'); ?>"
                                                               readonly="readonly"/>
                                                        <span class="text-danger"><?php echo form_error('admission_date'); ?></span>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row">
                                                <?php
                                                echo $action == 'add' ? display_custom_fields('students') : display_custom_fields('students', $obj->id);
                                                ?>
                                            </div>


                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-2 text-center">
                                            <label>Foto</label><br/>

                                            <input type="hidden" name="image" id="image"
                                                   value="<?php echo str_replace('uploads/student_images/', '', $obj->image); ?>"/>


                                            <img src="<?php $img = $obj->image;
                                            echo empty($img) ? 'https://via.placeholder.com/100x110' : base_url(($action == 'add' ? 'uploads/pre_upload/' . $img : $img)); ?>"
                                                 id="foto-aluno"
                                                 style="width: 100px; height: 110px;"/>


                                            <hr/>
                                            <input type="file" id="fileuploadImage" style="opacity: 1;"
                                                   accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg"
                                                   class="form-control" name="arquivo"/>

                                            <div id="progressImage" class="progress">
                                                <div class="progress-bar progress-bar-success"></div>
                                            </div>


                                            <span class="text-danger"><?php echo form_error('image'); ?></span>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="bozero">
                                <h4 class="pagetitleh2">Dados de Agenda</h4>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Escolha as opções</label><br/>
                                            <?php
                                            foreach ((new Snack_model())->all() as $snack) { ?>
                                                <label class="checkbox-inline">
                                                    <input <?= isset($snacks) && in_array($snack['id'], $snacks) ? 'checked': ''?> type="checkbox" name="snacks[]" value="<?=$snack['id']?>"> <?=$snack['name']?>
                                                </label>
                                            <?php } ?>
                                            <span class="text-danger"><?php echo form_error('snacks'); ?></span>
                                        </div>

                                    </div>

                                </div><!-- <div class="around10"> -->
                            </div>


                            <div class="bozero">
                                <h4 class="pagetitleh2">Dados dos Pais</h4>
                                <div class="around10">
                                    <div class="row">
                                        <?php if ($sch_setting->father_name) { ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('father_name'); ?></label>
                                                    <input id="father_name" name="father_name" placeholder=""
                                                           type="text"
                                                           class="form-control"
                                                           value="<?php echo $obj->father_name; ?>"/>

                                                </div>
                                            </div>
                                        <?php }
                                        if ($sch_setting->father_phone) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">
                                                        <?php if ($action == 'update'): ?>
                                                            <?php
                                                            $nf = str_replace(" ", "", $obj->guardian_phone);
                                                            $nf = str_replace("-", "", $nf);
                                                            $nf = str_replace("(", "", $nf);
                                                            $nf = str_replace(")", "", $nf); ?>
                                                            <i class="fab fa-whatsapp"
                                                               style="color: #25D366; cursor: pointer;"
                                                               onclick="callwz(<?php echo $nf; ?>);"></i>

                                                        <?php endif; ?>
                                                        <?php echo $this->lang->line('father_phone'); ?></label>
                                                    <input id="father_phone" name="father_phone" placeholder=""
                                                           type="text"
                                                           class="form-control"
                                                           value="<?php echo $obj->father_phone; ?>"/>

                                                </div>
                                            </div>
                                        <?php }
                                        if ($sch_setting->father_occupation) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('father_occupation'); ?></label>
                                                    <input id="father_occupation" name="father_occupation"
                                                           placeholder=""
                                                           type="text" class="form-control"
                                                           value="<?php echo $obj->father_occupation; ?>"/>
                                                </div>
                                            </div>
                                        <?php }

                                        ?>
                                    </div>
                                    <div class="row">
                                        <?php if ($sch_setting->mother_name) { ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_name'); ?></label>
                                                    <input id="mother_name" name="mother_name" placeholder=""
                                                           type="text"
                                                           class="form-control"
                                                           value="<?php echo $obj->mother_name; ?>"/>

                                                </div>
                                            </div>
                                        <?php }
                                        if ($sch_setting->mother_phone) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">
                                                        <?php if ($action == 'update'): ?>
                                                            <?php
                                                            $nf = str_replace(" ", "", $obj->mother_phone);
                                                            $nf = str_replace("-", "", $nf);
                                                            $nf = str_replace("(", "", $nf);
                                                            $nf = str_replace(")", "", $nf); ?>
                                                            <i class="fab fa-whatsapp"
                                                               style="color: #25D366; cursor: pointer;"
                                                               onclick="callwz(<?php echo $nf; ?>);"></i>

                                                        <?php endif; ?>
                                                        <?php echo $this->lang->line('mother_phone'); ?></label>
                                                    <input id="mother_phone" name="mother_phone" placeholder=""
                                                           type="text" class="form-control"
                                                           value="<?php echo $obj->mother_phone; ?>"/>

                                                </div>
                                            </div>
                                        <?php }
                                        if ($sch_setting->mother_occupation) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_occupation'); ?></label>
                                                    <input id="mother_occupation" name="mother_occupation"
                                                           placeholder="" type="text" class="form-control"
                                                           value="<?php echo $obj->mother_occupation; ?>"/>

                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div><!-- <div class="around10"> -->
                            </div>


                            <div class="bozero">
                                <h4 class="pagetitleh2">Dados do Responsável Financeiro</h4>
                                <div class="around10">


                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Quem é o(a) Responsável Financeiro?</label><br/>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php
                                                echo $obj->guardian_is == "father" ? "checked" : "";
                                                ?> value="father"> <?php echo $this->lang->line('father'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php
                                                echo $obj->guardian_is == "mother" ? "checked" : "";
                                                ?> value="mother"> <?php echo $this->lang->line('mother'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="guardian_is" <?php
                                                echo $obj->guardian_is == "other" ? "checked" : "";
                                                ?> value="other"> <?php echo $this->lang->line('other'); ?>
                                            </label>
                                            <span class="text-danger"><?php echo form_error('guardian_is'); ?></span>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    Relação com o Aluno
                                                </label> <small class="req"> *</small>
                                                <input id="guardian_relation"
                                                       name="guardian_relation" placeholder="Avô/avó/tio(a) etc..."
                                                       type="text"
                                                       class="form-control"
                                                       value="<?php echo $obj->guardian_relation; ?>"/>

                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_name'); ?></label><small
                                                        class="req"> *</small>
                                                <input id="guardian_name" name="guardian_name" placeholder=""
                                                       type="text"
                                                       class="form-control"
                                                       value="<?php echo $obj->guardian_name; ?>"/>

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_document'); ?></label><small
                                                        class="req"> *</small>
                                                <input id="guardian_document" name="guardian_document" placeholder=""
                                                       type="text" class="form-control"
                                                       value="<?php echo $obj->guardian_document; ?>"/>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    <?php if ($action == 'update'): ?>
                                                        <?php
                                                        $nf = str_replace(" ", "", $obj->guardian_phone);
                                                        $nf = str_replace("-", "", $nf);
                                                        $nf = str_replace("(", "", $nf);
                                                        $nf = str_replace(")", "", $nf); ?>
                                                        <i class="fab fa-whatsapp"
                                                           style="color: #25D366; cursor: pointer;"
                                                           onclick="callwz(<?php echo $nf; ?>);"></i>

                                                    <?php endif; ?>
                                                    <?php echo $this->lang->line('guardian_phone'); ?></label><small
                                                        class="req"> *</small>
                                                <input id="guardian_phone" name="guardian_phone"
                                                       placeholder="Fixo ou Celular" type="text"
                                                       class="form-control"
                                                       value="<?php echo $obj->guardian_phone; ?>"/>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_email'); ?></label><small
                                                        class="req"> *</small>
                                                <input id="guardian_email" name="guardian_email" placeholder=""
                                                       type="text" class="form-control"
                                                       value="<?php echo $obj->guardian_email; ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_occupation'); ?></label>
                                                <input id="guardian_occupation" name="guardian_occupation"
                                                       placeholder="" type="text" class="form-control"
                                                       value="<?php echo $obj->guardian_occupation; ?>"/>
                                            </div>
                                        </div>
                                    </div>


                                </div><!-- <div class="around10"> -->
                            </div><!-- Dados do Responsável Financeiro -->


                            <div class="bozero">
                                <h4 class="pagetitleh2">Endereço</h4>
                                <div class="around10">
                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_postal_code'); ?></label>
                                            <small class="req"> *</small>
                                            <input maxlength="20" id="guardian_postal_code" name="guardian_postal_code"
                                                   placeholder="08342350" class="form-control"
                                                   value="<?php echo $obj->guardian_postal_code; ?>"/>
                                        </div>
                                        <div class="col-md-2 form-group" style="margin-top:22.8px;">
                                            <label for="exampleInputEmail1">&nbsp;</label>
                                            <button
                                                    data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"
                                                    id="trigger-cep" data-target="guardian_postal_code"
                                                    style="padding: 3.8px 15px;"
                                                    type="button" class="btn btn-primary">Pesquisar endereco
                                            </button>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_address'); ?></label>
                                            <input maxlength="30" id="guardian_address"
                                                   name="guardian_address"
                                                   disabled="disabled"
                                                   placeholder="Rua, avenida, travessa etc.."
                                                   class="form-control documento"
                                                   value="<?php echo $obj->guardian_address; ?>"/>
                                        </div>

                                        <div class="col-md-2">
                                            <label><?php echo $this->lang->line('guardian_address_number_f'); ?></label>
                                            <input maxlength="30" id="guardian_address_number"

                                                   name="guardian_address_number" placeholder="23" class="form-control"
                                                   value="<?php echo $obj->guardian_address_number; ?>"/>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_district'); ?></label>
                                            <input maxlength="20" id="guardian_district" name="guardian_district"
                                                   placeholder="" class="form-control documento" disabled="disabled"
                                                   value="<?php echo $obj->guardian_district; ?>"/>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_city'); ?></label>
                                            <input maxlength="20" id="guardian_city" name="guardian_city"
                                                   placeholder="Barretos" class="form-control documento"
                                                   disabled="disabled"
                                                   value="<?php echo $obj->guardian_city; ?>"/>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="exampleInputEmail1"><?php echo explode(' ', $this->lang->line('guardian_state'))[1]; ?></label>
                                            <input maxlength="2" id="guardian_state" name="guardian_state"
                                                   placeholder="SP" class="form-control documento" disabled="disabled"
                                                   value="<?php echo $obj->guardian_state; ?>"/>
                                        </div>
                                    </div>


                                </div>
                            </div><!-- Endereço -->

                            <?php
                            $documentos = [
                                'certidao_nascimento' => 'Certidão de Nascimento',
                                'carteira_vacinacao' => 'Carteira de Vacinação',
                                'cnh_responsavel' => 'CNH do Responsável',
                                'comprovante_residencia' => 'Comprovante de Residência',
                            ]
                            ?>

                            <div class="bozero">
                                <h4 class="pagetitleh2">Documentos</h4>
                                <div class="around10">
                                    <div class="row">
                                        <?php foreach ($documentos as $campo => $label): ?>
                                            <div class="col-md-3 col-xs-12 col-sm-3">
                                                <label><?php echo $label; ?>
                                                    <?php if ($action != 'add' && isset($documentosEnviados[$label])): ?>
                                                        <a href="<?php echo base_url('uploads/student_documents/' . ((int)$obj->id) . '/' . $documentosEnviados[$label]); ?>"
                                                           target="_blank">
                                                            <i class="fa fa-external-link"></i>
                                                        </a>
                                                    <?php endif; ?></label>

                                                <br/>
                                                <input type="text" id="<?php echo $campo; ?>"
                                                       name="<?php echo $campo; ?>"
                                                       value="<?php echo isset($documentosEnviados[$label]) ? $documentosEnviados[$label] : ''; ?>"
                                                       disabled="disabled" class="form-control documento"
                                                       value="<?php echo set_value($campo); ?>"/>
                                                <input type="file" name="<?php echo $campo; ?>_fileupload"
                                                       id="<?php echo $campo; ?>_fileupload"
                                                       accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf"
                                                       style="opacity: 1;"/>
                                                <div id="progress<?php echo $campo; ?>" class="progress">
                                                    <div class="progress-bar progress-bar-success"></div>
                                                </div>

                                                <span class="text-danger"><?php echo form_error($campo); ?></span>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>


                            <div class="box-group collapsed-box">
                                <div class="panel box collapsed-box border0 mb0">
                                    <div class="addmoredetail-title">

                                        <a data-widget="collapse" data-original-title="Collapse"
                                           class="collapsed btn boxplus">
                                            <i class="fa fa-fw fa-plus"></i>Mais Documentos
                                        </a>

                                    </div>
                                    <div class="box-body">
                                        <div class="mb25 bozero">

                                            <div class="row">
                                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                                    <div class="col-md-3">
                                                        <label>Título #<?php echo $i; ?>

                                                            <?php if ($action != 'add' && isset($documentosEnviadosExtraEnviados[$i])): ?>
                                                                <a href="<?php echo base_url('uploads/student_documents/' . ((int)$obj->id) . '/' . $documentosEnviadosExtraEnviados[$i]->doc); ?>"
                                                                   target="_blank">
                                                                    <i class="fa fa-external-link"></i>
                                                                </a>
                                                            <?php endif; ?>

                                                        </label><br/>
                                                        <input type="text" name="doc_titulo_<?php echo $i; ?>"
                                                               class="form-control" id="doc_titulo_<?php echo $i; ?>"
                                                               value="<?php echo isset($documentosEnviadosExtraEnviados[$i]) ? $documentosEnviadosExtraEnviados[$i]->title : ''; ?>"
                                                        />
                                                        <input type="text" name="doc_arquivo_<?php echo $i; ?>"
                                                               id="doc_arquivo_<?php echo $i; ?>"
                                                               value="<?php echo isset($documentosEnviadosExtraEnviados[$i]) ? $documentosEnviadosExtraEnviados[$i]->doc : ''; ?>"
                                                               class="form-control documento" disabled="disabled"/>
                                                        <input type="file" name="doc_fileupload_<?php echo $i; ?>"
                                                               id="doc_fileupload_<?php echo $i; ?>"
                                                               accept=".png,png,.jpeg,jpeg,.jpeg,.jpeg,jpg,.jpg, pdf, .pdf"
                                                               style="opacity: 1;"/>
                                                        <div id="doc_progress_<?php echo $i; ?>" class="progress">
                                                            <div class="progress-bar progress-bar-success"></div>
                                                        </div>


                                                        <?php if ($action != 'add' && isset($documentosEnviadosExtraEnviados[$i])): ?>
                                                            <br/>
                                                            <a href="javascript:" class="btn btn-xs btn-danger"
                                                               onclick="$('#doc_titulo_<?php echo $i; ?>,#doc_arquivo_<?php echo $i; ?>').val('');"
                                                            >
                                                                <i class="fa fa-trash"></i> remover documento
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="box-footer">
                                <button type="button"
                                        id="btn-gravar"
                                        onclick="$(this)._saveStudent();"
                                        class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- jS FileUpload -->
<script type="text/javascript" src="<?php echo base_url(); ?>backend/file-upload/js/jquery.fileupload.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id', 0) ?>';


        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });


    });

    function auto_fill_guardian_address() {
        if ($("#autofill_current_address").is(':checked')) {
            $('#current_address').val($('#guardian_address').val());
        }
    }

    function auto_fill_address() {
        if ($("#autofill_address").is(':checked')) {
            $('#permanent_address').val($('#current_address').val());
        }
    }

    $('input:radio[name="guardian_is"]').change(
        function () {
            if ($(this).is(':checked')) {
                var value = $(this).val();
                if (value == "father") {
                    $('#guardian_name').val($('#father_name').val());
                    $('#guardian_phone').val($('#father_phone').val());
                    $('#guardian_occupation').val($('#father_occupation').val());
                    $('#guardian_relation').val("Pai");
                } else if (value == "mother") {
                    $('#guardian_name').val($('#mother_name').val());
                    $('#guardian_phone').val($('#mother_phone').val());
                    $('#guardian_occupation').val($('#mother_occupation').val());
                    $('#guardian_relation').val("Mãe");
                } else {
                    $('#guardian_name').val("");
                    $('#guardian_phone').val("");
                    $('#guardian_occupation').val("");
                    $('#guardian_relation').val("");
                }
            }
        });
</script>


<script type='text/javascript'>
    $(document).ready(function () {


        /*TURMA E PERIODO ---------------------------------------------------------*/
        /*Carrega o combobox de periodos*/
        $.fn.comboBoxPeriodo = function () {
            $(this).comboBox({
                url: '<?php echo base_url(); ?>welcome/getListaPeriodosPorTurma',
                data: {class_id: $('#class_id').val()},
                combobox: '#section_id',
                selected: '<?php echo isset($obj->section_id) ? $obj->section_id : 0; ?>',
                callback: {
                    function() {
                    }
                }
            });

        };

        /*Verificar a turma com base na data de nascimento*/
        $.fn.carregarComboBoxTurmasDisponiveis = function (dataNascimento) {
            $(this).comboBox({
                url: '<?php echo base_url(); ?>welcome/getListaTurmasPorDataNascimento',
                data: {dataNascimento: dataNascimento, session_id: $('#session_id').val()},
                combobox: '#class_id',
                selected: '<?php echo isset($obj->class_id) ? $obj->class_id : 0; ?>',
                callback: function () {
                    $(this).comboBoxPeriodo();
                }
            });
        };
        $(this).carregarComboBoxTurmasDisponiveis('<?php echo $action == 'add' ? '01/01/2050' : $this->tools->formatarData($obj->dob, 'us', 'br'); ?>');

        $('#session_id').change(function () {
            $(this).carregarComboBoxTurmasDisponiveis($('#dob').val());
        });

        $('#father_phone').mask('(99) 999999999');
        $('#mother_phone').mask('(99) 999999999');
        $('#guardian_phone').mask('(99) 999999999');

        $('#dob').mask('99/99/9999');
        $('#admission_date').mask('99/99/9999');
        let typingTimer;                //timer identifier
        let doneTypingInterval = 1000;  //time in ms (5 seconds)
        let myInput = document.getElementById('dob');

        //on keyup, start the countdown
        $('#dob').keyup(function () {
            clearTimeout(typingTimer);
            if ($('#dob').val()) {
                typingTimer = setTimeout(function () {
                    $(this).carregarComboBoxTurmasDisponiveis($('#dob').val());
                }, doneTypingInterval);
            }
        });


        /*TURMA E PERIODO ---------------------------------------------------------*/

        /*IMAGEM*/

        $('#progressImage').hide();
        $('#fileuploadImage').fileupload({
            url: '<?php echo base_url(); ?>uploader/preUpload',
            formData: {folder: 'student_images', _submit: 'yeap', campo: 'arquivo'},
            dataType: 'json',
            done: function (e, data) {

                if (data.result.status) {
                    $('#image').val(data.result.msg.name);
                    $('#foto-aluno').prop('src', 'data:image/' + data.result.msg.ext + ';base64,' + data.result.msg.base64);

                } else {
                    alert(data.result.msg);
                }

                $('#progressImage').hide();
            },
            progressall: function (e, data) {
                $('#progressImage').show();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progressImage .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
        /*IMAGEM*/

        /*DOCUMENTOS*/
        <?php foreach($documentos as $campo => $label): ?>
        $('#progress<?php echo $campo; ?>').hide();
        $('#<?php echo $campo; ?>_fileupload').fileupload({
            url: '<?php echo base_url(); ?>uploader/preUpload',
            formData: {_submit: 'yeap', campo: '<?php echo $campo; ?>_fileupload'},
            dataType: 'json',
            done: function (e, data) {

                if (data.result.status) {
                    $('#<?php echo $campo; ?>').val(data.result.msg.name);

                } else {
                    alert(data.result.msg);
                }

                $('#progress<?php echo $campo; ?>').hide();
            },
            progressall: function (e, data) {
                $('#progress<?php echo $campo; ?>').show();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress<?php echo $campo; ?> .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
        <?php endforeach; ?>
        /*DOCUMENTOS*/

        /*OUTROS DOCUMENTOS*/
        <?php for($i = 1; $i <= 4; $i++): ?>
        $('#doc_progress_<?php echo $i; ?>').hide();
        $('#doc_fileupload_<?php echo $i; ?>').fileupload({
            url: '<?php echo base_url(); ?>uploader/preUpload',
            formData: {_submit: 'yeap', campo: 'doc_fileupload_<?php echo $i; ?>'},
            dataType: 'json',
            done: function (e, data) {

                if (data.result.status) {
                    $('#doc_arquivo_<?php echo $i; ?>').val(data.result.msg.name);

                } else {
                    alert(data.result.msg);
                }

                $('#doc_progress_<?php echo $i; ?>').hide();
            },
            progressall: function (e, data) {
                $('#doc_progress_<?php echo $i; ?>').show();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#doc_progress_<?php echo $i; ?> > .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
        <?php endfor; ?>
        /*OUTROS DOCUMENTOS*/


        $.fn.save = function () {

            /* if(document.getElementById("certidao_nascimento").value == "") {
                 alert('Carregue a CERTIDÃO DE NASCIMENTO');
                 return;
              }

              if(document.getElementById("carteira_vacinacao").value == "") {
                 alert('Carregue a CARTEIRA DE VACINAÇÃO');
                 return;
              }

              if(document.getElementById("cnh_responsavel").value == "") {
                 alert('Carregue a CNH DO RESPONSÁVEL');
                 return;
              }

              if(document.getElementById("comprovante_residencia").value == "") {
                 alert('Carregue o COMPROVANTE DE RESIDÊNCIA');
                 return;
              }*/

            $('.documento').prop('disabled', false);

            $('#form1').submit();
        };


        $.fn._saveStudent = function () {

            <?php foreach($documentos as $campo => $label): ?>
            $('#<?php echo $campo; ?>').prop('disabled', false);
            <?php endforeach; ?>
            $('.documento').prop('disabled', false);

            $(this)._submit({
                url: '<?php echo base_url('student/create'); ?>',
                data: $('#form1').serialize(),
                button: $('#btn-gravar'),
                callback: function (resp) {

                    if (!resp.status) {
                        alert(resp.msg);
                    } else {
                        // alert('Dados Gravados Corretamente!');
                        location.href = location.href;
                    }

                }

            });
        };


    });
</script>
<script>
    function callwz(telefone) {

        window.open('https://wa.me/55' + telefone);

    }
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/js/postalCodeAutoComplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/js/savemode.js"></script>