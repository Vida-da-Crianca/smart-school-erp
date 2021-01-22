<div class="content-wrapper">



    <section class="content">
        <div class="box box-primary">
            <div class="box-header ptbnull">
                <h3 class="box-title titlefix"> <?php echo $document->id > 0 ? $this->lang->line('document_frm_update') : $this->lang->line('document_frm_create'); ?></h3>
                <div class="box-tools pull-right">
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form method="post" action="<?php ?>">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 text-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="document_title"><?php echo $this->lang->line('document_title'); ?> *</label>
                                <?= form_input('title', set_value('title', $document->title ?? $document->title), 'class="form-control" '); ?>
                            </div>
                        </div>

                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group main-content-editor">

                                <label for="document_body"><?php echo $this->lang->line('document_body'); ?>* </label>
                                <div id="toolbar-container"></div>
                                <textarea name="body" class="hide" id="document_body" cols="30" rows="10"><?= set_value('body', $document->body ?? $document->body) ?></textarea>

                                <!-- <?= form_textarea('body', set_value('body', $document->body ?? $document->body), 'class="hide" id="document_body" '); ?> -->
                            </div>
                        </div>



                        <div class="col-md-10 col-md-offset-1 text-right">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Salvar dados
                                </button>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1 text-right">
                            <div class="form-group text-right pr-2">
                                <strong>Variavéis para uso no Documento</strong><br/>
                                <code><?=getEditorVariables()?></code>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>



</div>


<style>
    .ck.ck-content {
        height: 100vh;
    }

    .main-content-editor {
        min-height: 100vh;
    }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
    $(document).ready(function() {


        ClassicEditor
            .create(document.querySelector('#document_body'))
            .then(editor => {
                const toolbarContainer = document.querySelector('#toolbar-container');

                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            })
            .catch(error => {
                console.error(error);
            });
    })
</script>