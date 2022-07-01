<style type="text/css">
    .lead_template {

        font-size: 16px;
        font-weight: 300;
        line-height: 1.4;
        padding: 0px;
        margin-bottom: 5px;
    }

    .lead_template_variable {
        font-size: 16px;
        font-weight: 300;
        line-height: 1.4;
        padding: 0px;
        margin-bottom: 5px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <p class="lead_template"><?php echo $this->lang->line($record->type); ?></p>
        <input type="hidden" id="temp_id" name="temp_id" value="<?php echo $record->id; ?>">
        <div class="form-group">
            <label for="form_message"><?php echo $this->lang->line('template'); ?>* </label>
            <div class="text text-danger template_message_error"></div>
            <div class="main-content-editor">
                <div class="main-content-editor__toolbar toolbar-container"></div>
                <div id="form_message" class=" main-content-editor__editable-container">
                    <div class="editor main-content-editor__editable">
                        <?php echo $record->template; ?>
                    </div>

                </div>
            </div>
            <div class="hide_in_read">
                <p class="lead_template_variable"><?php echo $this->lang->line('you_can_use_variables'); ?></p>
                <div class="col-md-12">
                    <div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#student" aria-controls="student" role="tab"
                                                                      data-toggle="tab">Variaveis do Aluno</a></li>
                            <li role="presentation"><a href="#guardian" aria-controls="guardian" role="tab"
                                                       data-toggle="tab">Variaveis do Responsavel</a></li>
                            <li role="presentation"><a href="#finance" aria-controls="finance" role="tab"
                                                       data-toggle="tab">Variaveis do Financeiro</a></li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-2">
                            <div role="tabpanel" class="tab-pane active" id="student">
                                <ul class="list-group">
                                    <?= sprintf('%s', implode('', array_map(function ($row) {
                                        return sprintf('<li class="list-group-item">{{%s}}</li>', $row);
                                    }, get_student_var_document()))) ?>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="guardian">
                                <ul class="list-group">
                                    <?= sprintf('%s', implode('', array_map(function ($row) {
                                        return sprintf('<li class="list-group-item">{{%s}}</li>', $row);
                                    }, get_guardian_var_document()))) ?>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="finance">
                                <ul class="list-group" style="list-style: none; word-wrap: break-word; ">
                                    <?= sprintf('%s', implode('', array_map(function ($row) {
                                        return sprintf('<li class="col-md-3 col-xs-6" style="margin-bottom: 5px;"><span class="list-group-item"> {{%s}}</span></li>', $row);
                                    }, get_finance_var_document()))) ?>
                                </ul>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

