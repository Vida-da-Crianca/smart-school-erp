<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- left column -->
                <form id="form1" action="<?php echo site_url('admin/notification/setting') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-commenting-o"></i> <?php echo $this->lang->line('notification_setting'); ?></h3>
                        </div>
                        <div class="around10">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">


                            <!-- Button HTML (to Trigger Modal) -->
                            <div class="table-responsive">

                                <table class="table table-hover">
                                    <thead>
                                    <th><?php echo $this->lang->line('event'); ?></th>
                                    <th><?php echo $this->lang->line('option'); ?></th>
                                    <th><?php echo $this->lang->line('sample_message'); ?></th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        $last_key = count($notificationlist);
                                        foreach ($notificationlist as $note_key => $note_value) {
                                            $hr = "";

                                            if ($i != $last_key) {
                                                $hr = "<hr>";
                                            }
                                            ?>

                                            <tr>
                                                <td width="15%">
                                                    <input type="hidden" name="ids[]" value="<?php echo $note_value->id; ?>">
                                                    <?php echo $this->lang->line($note_value->type); ?>
                                                </td>
                                                <td width="25%">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="mail_<?php echo $note_value->id; ?>" value="1" <?php echo set_checkbox('mail_' . $note_value->id, 1, set_value('mail_' . $note_value->id, $note_value->is_mail) ? true : false); ?>> <?php echo $this->lang->line('email'); ?>
                                                    </label>
                                                    <?php
                                                    if ($note_value->display_sms) {
                                                        ?>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="sms_<?php echo $note_value->id; ?>" value="1" <?php echo set_checkbox('sms_' . $note_value->id, 1, set_value('sms_' . $note_value->id, $note_value->is_sms) ? true : false); ?>>
                                                            <?php echo $this->lang->line('sms'); ?>
                                                        </label>
                                                        <?php
                                                    }

                                                    if ($note_value->display_notification) {
                                                        ?>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="notification_<?php echo $note_value->id; ?>" value="1" <?php echo set_checkbox('notification_' . $note_value->id, 1, set_value('notification_' . $note_value->id, $note_value->is_notification) ? true : false); ?>>
                                                            <?php echo $this->lang->line('mobile_app') ?>
                                                        </label>

                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td width="60%">
                                                    <?php
                                                    if (!empty($note_value)) {
                                                        echo $note_value->template;
                                                    }
                                                    ?>
                                                    <br/>
                                                    <button type="button" class="button_template btn btn-primary btn-xs" id="load" data-record-id="<?php echo $note_value->id; ?>" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait.."><i class="fa fa-pencil-square-o"></i></button>

                                                </td>
                                            </tr>


                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <?php if ($this->rbac->hasPrivilege('notification_setting', 'can_edit')) {
                                ?>
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            <?php }
                            ?>

                        </div>
                </form>
            </div>

        </div>
</div><!--./wrapper-->

</section><!-- /.content -->
</div>


<div class="modal fade" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo site_url('admin/notification/savetemplate') ?>" method="post" id="templateForm">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> <?php echo $this->lang->line('template'); ?></h4>
                </div>
                <div class="modal-body template_modal_body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="template_update btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing.."><?php echo $this->lang->line('save'); ?></button>

                </div>
            </form>
        </div>
    </div>
</div>
<style>
    /* .ck.ck-content {
        height: 100vh;
    }

    .main-content-editor,
    .ql-editor {
        min-height: 100vh;
    } */

    #container {
        display: flex;
        position: relative;
    }

    #container .ck.ck-editor {
        width: 100%;
        max-width: 700px;
    }

    .main-content-editor {
        border: 1px solid var(--ck-color-base-border);
        border-radius: var(--ck-border-radius);

        /* Set vertical boundaries for the document editor. */
        /* max-height: 700px; */

        /* This element is a flex container for easier rendering. */
        display: flex;
        flex-flow: column nowrap;
    }

    .main-content-editor__toolbar {
        /* Make sure the toolbar container is always above the editable. */
        z-index: 1;

        /* Create the illusion of the toolbar floating over the editable. */
        box-shadow: 0 0 5px hsla(0, 0%, 0%, .2);

        /* Use the CKEditor CSS variables to keep the UI consistent. */
        border-bottom: 1px solid var(--ck-color-toolbar-border);
    }

    /* Adjust the look of the toolbar inside the container. */
    .main-content-editor__toolbar .ck-toolbar {
        border: 0;
        border-radius: 0;
    }

    .main-content-editor__editable-container {
        padding: calc(2 * var(--ck-spacing-large));
        background: var(--ck-color-base-foreground);

        /* Make it possible to scroll the "page" of the edited content. */
        overflow-y: scroll;
    }

    .main-content-editor__editable-container .ck-editor__editable {
        /* Set the dimensions of the "page". */
        width: 18cm;
        min-height: 21cm;

        /* Keep the "page" off the boundaries of the container. */
        padding: 1cm 2cm 2cm;

        border: 1px hsl(0, 0%, 82.7%) solid;
        border-radius: var(--ck-border-radius);
        background: white;

        /* The "page" should cast a slight shadow (3D illusion). */
        box-shadow: 0 0 5px hsla(0, 0%, 0%, .1);

        /* Center the "page". */
        margin: 0 auto;
        margin-bottom: 15px;
    ;


    }

    .main-content-editor .image figcaption {
        display: none !important;
    }

    .note-modal .note-group-image-url {

        display: none;

    }

    .note-modal .note-form-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #222;
        color: #ddd;
        border-radius: 3px;
        padding: 10px 20px;
    }

    .note-modal .modal-footer {
        display: none;
    }

    .note-editable table{
        width: auto !important;
    }

    .note-editable .table-bordered tr td,
    .note-editable .table-bordered tr th {

        border: 1px solid #bbb;

    }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-pt-BR.min.js"></script>
<script src="/backend/js/summernote-pagebreak.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        function CleanPastedHTML(input) {
            // 1. remove line breaks / Mso classes
            var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
            var output = input.replace(stringStripper, ' ');
            // 2. strip Word generated HTML comments
            var commentSripper = new RegExp('<!--(.*?)-->', 'g');
            var output = output.replace(commentSripper, '');
            var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>', 'gi');
            // 3. remove tags leave content if any
            output = output.replace(tagStripper, '');
            // 4. Remove everything in between and including tags '<style(.)style(.)>'
            var badTags = ['style', 'script', 'applet', 'embed', 'noframes', 'noscript'];

            for (var i = 0; i < badTags.length; i++) {
                tagStripper = new RegExp('<' + badTags[i] + '.*?' + badTags[i] + '(.*?)>', 'gi');
                output = output.replace(tagStripper, '');
            }
            // 5. remove attributes ' style="..."'
            var badAttributes = ['style', 'start'];
            for (var i = 0; i < badAttributes.length; i++) {
                var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"', 'gi');
                output = output.replace(attributeStripper, '');
            }
            return output;
        }



        var toolbar = [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            // ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['pagebreak', ['pagebreak']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']],
        ]

        var $summernote = null;


        async function convertBase64(file) {
            return new Promise(async (resolve) => {
                const reader = new FileReader();
                reader.onloadend = () => {
                    const base64String = reader.result;
                    // .replace("data:", "")
                    // .replace(/^.+,/, "");
                    resolve(base64String);
                };
                reader.readAsDataURL(file);
            })

        }

        $(document).on('click', '.button_template', function () {
            $('.template_message_error').html("");
            var $this = $(this);
            var id = $this.data('recordId');
            $this.button('loading');
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: baseurl + "admin/notification/gettemplate",
                data: {'id': id},
                beforeSend: function () {
                },
                success: function (data) {
                    if (data.status) {
                        $('#templateModal').modal('show');
                        $('.template_modal_body').html(data.template);
                        $summernote = $('.editor').summernote({
                            toolbar: toolbar,
                            height: 200,
                            lang: 'pt-BR',
                            disableDragAndDrop: true,
                            hint: {
                                mentions: [<?= sprintf("'%s'", implode("','", getEditorVariables())) ?>],
                                match: /\B\{\{(\w*)$/,
                                search: function(keyword, callback) {
                                    callback($.grep(this.mentions, function(item) {
                                        return item.indexOf(keyword) == 0;
                                    }));
                                },
                                content: function(item) {
                                    return `{{${item}}}`;
                                }
                            },
                            codemirror: {
                                mode: 'text/html',
                                htmlMode: true,
                                lineNumbers: true,
                                theme: 'monokai'
                            },
                            popover: {
                                image: [
                                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                                    ['remove', ['removeMedia']]
                                ],
                            },
                            callbacks: {
                                onPaste: function(e) {
                                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                                    e.preventDefault();
                                    setTimeout(function() {
                                        document.execCommand('insertText', false, bufferText);
                                    }, 10);
                                },
                                onImageUpload: async (files) => {
                                    return new Promise(async (resolve) => {
                                        const img = await convertBase64(files[0])
                                        await axios.post('/uploader/uploadBase64/', {
                                            "filename": files[0].name,
                                            "file": img
                                        })
                                            .then(function (response) {
                                                if (response.data.status === true) {
                                                    $img = $('<img>').attr({
                                                        src: response.data.msg,
                                                        width: 150
                                                    })
                                                    setTimeout(function () {
                                                        $summernote.summernote('insertNode', $img[0]);
                                                    }, 10);
                                                }
                                            })
                                            .catch(function (error) {
                                                console.error(error)
                                                alert('Erro ao carregar imagem')
                                            })

                                        resolve();
                                    })
                                },
                                onInit: function() {
                                    // $placeholder.show();
                                },
                                onFocus: function() {
                                    // $placeholder.hide();
                                },
                                onBlur: function() {
                                    var $self = $(this);
                                    setTimeout(function() {
                                        if ($self.summernote('isEmpty') && !$self.summernote('codeview.isActivated')) {
                                            // $placeholder.show();
                                        }
                                    }, 300);
                                }
                            }
                        });
                    }
                },
                error: function (xhr) { // if error occured
                    alert("Error occured.please try again");
                    $this.button('reset');
                },
                complete: function () {
                    $this.button('reset');
                }
            });
        });
    });

    $("#templateForm").submit(function (e) {
        $('.template_message_error').html("");
        var submit_btn = $(this).find("button[type=submit]:focus");
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                temp_id: $('#temp_id').val(),
                template_message: $('.note-editable').html(),
            }, // serializes the form's elements.
            beforeSend: function () {
                submit_btn.button('loading');
            },
            success: function (data) {
                if (data.status) {
                    successMsg(data.message);
                    window.location.reload(true);
                } else {
                    $.each(data.error, function (key, val) {
                        $('.' + key + '_error').html(val);

                    });
                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                submit_btn.button('reset');
            },
            complete: function () {
                submit_btn.button('reset');
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

</script>