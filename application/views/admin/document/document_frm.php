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
                        <div class="col-md-10 col-md-offset-1 text-right">
                            <div class="form-group text-right pr-2">
                                <strong>Variavéis para uso no Documento</strong><br />
                                <code>Use <b>{{</b> para o preenchimento das variaveis</code>
                                <!-- <code><?= implode(' | ',   array_map(function($str){  return sprintf('{%s}', $str);}, getEditorVariables() ) )?></code> -->
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
        max-height: 700px;

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
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script> -->
<!-- <script src="/backend/ckeditor5/build/ckeditor.js"></script>
<script src="/backend/ckeditor5/sample/styles.css"></script> -->
<!-- include summernote css/js -->

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {

        // class Adapter {
        //     /**
        //      * Creates a new adapter instance.
        //      *
        //      * @param {module:upload/filerepository~FileLoader} loader
        //      */
        //     constructor(loader) {
        //         /**
        //          * `FileLoader` instance to use during the upload.
        //          *
        //          * @member {module:upload/filerepository~FileLoader} #loader
        //          */
        //         this.loader = loader;
        //     }

        //     /**
        //      * Starts the upload process.
        //      *
        //      * @see module:upload/filerepository~UploadAdapter#upload
        //      * @returns {Promise}
        //      */
        //     upload() {
        //         return new Promise((resolve, reject) => {
        //             const reader = this.reader = new window.FileReader();

        //             reader.addEventListener('load', () => {
        //                 resolve({
        //                     default: reader.result
        //                 });
        //             });

        //             reader.addEventListener('error', err => {
        //                 reject(err);
        //             });

        //             reader.addEventListener('abort', () => {
        //                 reject();
        //             });

        //             this.loader.file.then(file => {
        //                 reader.readAsDataURL(file);
        //             });
        //         });
        //     }

        //     /**
        //      * Aborts the upload process.
        //      *
        //      * @see module:upload/filerepository~UploadAdapter#abort
        //      * @returns {Promise}
        //      */
        //     abort() {
        //         this.reader.abort();
        //     }
        // }

        // function MyCustomUploadAdapterPlugin(editor) {
        //     editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        //         // Configure the URL to the upload script in your back-end here!
        //         return new Adapter(loader);
        //     };
        // }





        var options = [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen']],
        ]
        var $summernote = $('.editor').summernote({
            toolbar: options,
            height: 300,
            hint: {
                mentions: [<?=sprintf("'%s'",implode("','" , getEditorVariables()))?>],
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
                onImageUpload: async (files) => {
                    return new Promise(async (resolve) => {
                        const img = await convertBase64(files[0])
                        $img = $('<img>').attr({
                            src: img,
                            width: 150
                        })
                        $summernote.summernote('insertNode', $img[0]);
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