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
                        <div class="col-md-10 col-md-offset-1 text-danger display-errors">
                            <!-- <?php echo validation_errors(); ?> -->
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
                            <div class="form-group ">

                                <label for="document_body"><?php echo $this->lang->line('document_body'); ?>* </label>
                                <div class="main-content-editor">
                                    <div class="main-content-editor__toolbar toolbar-container"></div>
                                    <div id="document_body" class=" main-content-editor__editable-container">
                                        <div class="editor main-content-editor__editable">
                                            <?= $document->body ?? $document->body ?>
                                        </div>

                                    </div>
                                </div>


                                <!-- <textarea name="body" id="document_body" cols="30" rows="10"><?= set_value('body', $document->body ?? $document->body) ?></textarea> -->

                                <!-- <?= form_textarea('body', set_value('body', $document->body ?? $document->body), 'class="hide" id="document_body" '); ?> -->
                            </div>
                        </div>



                        <div class="col-md-10 col-md-offset-1 text-right">


                            <div class="form-group ">
                                <span class="loading-container"></span>
                                <button type="submit" class="btn btn-primary">
                                    Salvar dados
                                </button>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1 mb-4 mt-4">
                            <div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">Variaveis do Aluno</a></li>
                                    <li role="presentation"><a href="#guardian" aria-controls="guardian" role="tab" data-toggle="tab">Variaveis do Responsavel</a></li>
                                    <li role="presentation"><a href="#finance" aria-controls="finance" role="tab" data-toggle="tab">Variaveis do Financeiro</a></li>
                                   
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-2">
                                    <div role="tabpanel" class="tab-pane active" id="student">
                                     <ul class="list-group">
                                       <?=sprintf('%s', implode('', array_map( function($row){ return sprintf('<li class="list-group-item">{{%s}}</li>', $row);}, get_student_var_document()) ))?>
                                      </ul>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="guardian">
                                    <ul class="list-group">
                                       <?=sprintf('%s', implode('', array_map( function($row){ return sprintf('<li class="list-group-item">{{%s}}</li>', $row);}, get_guardian_var_document()) ))?>
                                      </ul>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="finance">
                                    <ul class="list-group">
                                       <?=sprintf('%s', implode('', array_map( function($row){ return sprintf('<li class="list-group-item">{{%s}}</li>', $row);}, get_finance_var_document()) ))?>
                                      </ul>
                                    </div>
                                    
                                </div>

                            </div>

                        </div>
                        <div class="col-md-10 col-md-offset-1 text-right">
                            <div class="form-group text-left pr-2">
                                <strong>Ajuda com as variavéis para uso no Documento</strong><br /><br />
                                <pre class="text-danger">Use <b>{{</b> para o preenchimento das variaveis <br/>Para criar valores dinamicos nas taxas faça a substituição <b>n</b> pelo número. <br/><br/><strong>Ex: </strong><br/>{{parcela_escolar_@n_valor}} => {{parcela_escolar_@<b>1</b>_valor}}
                                </pre>
                                <!-- <code><?= implode(' | ',   array_map(function ($str) {
                                                return sprintf('{%s}', $str);
                                            }, getEditorVariables())) ?></code> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>



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
</style>


<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="/backend/js/summernote-pagebreak.js"></script>
<script>
    $(document).ready(function() {



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



        var options = [
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
        var $summernote = $('.editor').summernote({
            toolbar: options,
            height: '218mm',
            disableDragAndDrop: true,
            fontSize: 12,
            fontSizeUnit: 'pt',
            lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
            // codeviewFilter: false,
            // codeviewIframeFilter: true,
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
                        $img = $('<img>').attr({
                            src: img,
                            width: 150
                        })
                        setTimeout(function() {
                            $summernote.summernote('insertNode', $img[0]);
                        }, 10);
                        // console.log(await fileToBase64(files[0]))
                        // $summernote.summernote('insertImage', img);

                        resolve();
                    })

                }
            }
        });


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
        $('form').on('submit', function(e) {
            e.preventDefault();

            var url = $(this).attr('action')
            $('.loading-container').html('Aguarde...')
            $.ajax({
                url,
                method: 'post',
                dataType: 'json',
                data: {
                    body: $summernote.summernote('code'),
                    title: $('input[name="title"]').val()
                },
                success: function() {
                    window.location.href = '<?= site_url('/admin/documents') ?>';
                },
                error: function({
                    responseJSON: e
                }) {
                    var {
                        errors
                    } = e
                    var $el = $('.display-errors')
                    $el.html(errors)
                    $("html, body").animate({
                        scrollTop: "0"
                    });

                    setTimeout(() => {
                        $el.html('')
                    }, 8000)

                },
                complete: function() {
                    $('.loading-container').html('')
                }
            })


        })
        // DecoupledDocumentEditor
        //     .create(document.querySelector('.editor'), {
        //         // extraPlugins: [MyCustomUploadAdapterPlugin],

        //         toolbar: {
        //             items: [
        //                 'heading',
        //                 '|',
        //                 'fontSize',
        //                 'fontFamily',
        //                 '|',
        //                 'bold',
        //                 'italic',
        //                 'underline',
        //                 'strikethrough',
        //                 'highlight',
        //                 '|',
        //                 'alignment',
        //                 '|',
        //                 'numberedList',
        //                 'bulletedList',
        //                 '|',
        //                 'indent',
        //                 'outdent',
        //                 '|',
        //                 'todoList',
        //                 'link',
        //                 'blockQuote',
        //                 'imageUpload',
        //                 'insertTable',
        //                 // 'mediaEmbed',
        //                 '|',
        //                 'undo',
        //                 'redo',
        //                 // 'imageResize:50',
        //                 // 'imageResize:75',
        //                 // 'imageResize:original',
        //                 'imageTextAlternative',
        //                 'imageStyle:alignLeft',
        //                 'imageStyle:alignCenter',
        //                 'imageStyle:alignRight',
        //                 'imageStyle:full',
        //                 'imageStyle:side',
        //             ]
        //         },
        //         image: {
        //             resizeUnit: 'px',
        //             styles: [
        //                 'alignLeft', 'alignCenter', 'alignRight'
        //             ],
        //         },
        //         pagination: {
        //             // A4
        //             pageWidth: '21cm',
        //             pageHeight: '29.7cm',

        //             pageMargins: {
        //                 top: '3mm',
        //                 bottom: '3mm',
        //                 right: '3mm',
        //                 left: '3mm'
        //             }
        //         },
        //         language: 'pt-br',
        //         // image: {
        //         //     toolbar: [
        //         //         'imageTextAlternative',
        //         //         'imageStyle:full',
        //         //         'imageStyle:side'
        //         //     ]
        //         // },
        //         table: {
        //             contentToolbar: [
        //                 'tableColumn',
        //                 'tableRow',
        //                 'mergeTableCells',

        //                 'tableProperties', 'tableCellProperties'
        //             ]
        //         },
        //         // licenseKey: '',

        //     })
        //     .then(editor => {
        //         window.editor = editor;

        //         const toolbarContainer = document.querySelector('.main-content-editor__toolbar');
        //         toolbarContainer.appendChild(editor.ui.view.toolbar.element);

        //         window.editor = editor;

        //         editor.execute('tableWidth', {
        //             value: '100%'
        //         });

        //     })
        //     .catch(error => {
        //         console.error('Oops, something went wrong!');
        //         // console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
        //         console.warn('Build id: 5v0h87dz5yp4-ucn1dsls94e0');
        //         console.error(error);
        //     });



    })
</script>