<style>
    .checkbox-inline,
    .checkbox-inline + .checkbox-inline,
    .checkbox-inline + .radio-inline,
    .radio-inline,
    .radio-inline + .radio-inline,
    .radio-inline + .checkbox-inline {
        margin-left: 0;
        margin-right: 10px;
    }

    .checkbox-inline:last-child,
    .radio-inline:last-child {
        margin-right: 0;
    }

    .item-line {
        border-bottom: 1px solid #d6d2dc;
        min-height: 80px;
    }

    .topico {
        color: #116fa2
    }

    .message_parent {
        font-size: 10px;
        color: red;
        display: block;
    }

    .message_parent_icon {
        position: absolute;
        right: 5px;
    }

    #snackbar {
        visibility: hidden; /* Hidden by default. Visible on click */
        min-width: 250px; /* Set a default minimum width */
        margin-left: -125px; /* Divide value of min-width by 2 */
        background-color: #333; /* Black background color */
        color: #fff; /* White text color */
        text-align: center; /* Centered text */
        border-radius: 10px; /* Rounded borders */
        padding: 16px; /* Padding */
        position: fixed; /* Sit on top of the screen */
        z-index: 1; /* Add a z-index if needed */
        right: 5%; /* Center the snackbar */
        bottom: 30px; /* 30px from the bottom */
    }

    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }


    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }
        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }
        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }
        to {
            bottom: 0;
            opacity: 0;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }
        to {
            bottom: 0;
            opacity: 0;
        }
    }

</style>
<div class="content-wrapper" id="app" style="display: none">
    <div id="snackbar">Test</div>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header ptbnull">
                <p style="font-size: 20px; font-weight: 600">Agenda detalhada</p>
                <div class="box-tools pull-right">
                    <a href="/user/user/schedule" class="btn btn-info">Listagem</a>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <form autocomplete="off" method="post" action="">
                                <div class="body bg-grayclear">
                                    <div class="form-group" style="padding: 15px; background-color: #dbdbdb;">
                                        <div class="col-xs-12 col-sm-2 col-md-2 no-padding margin-bottom">
                                            <label>Data</label>
                                            <input type="date" name="data"
                                                   class="form-control disabled" value="<?= $agenda['date'] ?>"
                                                   placeholder="Data" readonly="readonly">
                                        </div>

                                        <div class="col-xs-12 col-sm-5 col-md-5 no-padding-right margin-bottom">
                                            <label>Aluno</label>
                                            <input class="form-control" disabled readonly
                                                   value="<?= $student['firstname'] ?> <?= $student['lastname'] ?>">
                                        </div>
                                        <div class="col-xs-12 col-sm-5 col-md-5 no-padding-right margin-bottom">
                                            <label>Turma</label>
                                            <input class="form-control" disabled readonly
                                                   value="<?= $student['class'] ?> -  <?= $student['section'] ?>">
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </form>
                            <?php foreach ($agenda['content'] as $key => $content) : ?>

                                <fieldset>
                                    <legend class="topico"><?= Snack_model::$tipos[$key] ?></legend>
                                    <?php if ($key == "alimentacao") : ?>
                                        <table class="table table-bordered table-striped">
                                            <tr class="active">
                                                <th>Tipo de Refeição</th>
                                                <th>Horário</th>
                                                <th>Comportamento</th>
                                                <th>Recado</th>
                                            </tr>
                                            <?php foreach ($content as $item) :
                                                $id = $item['id'];
                                                ?>
                                                <tr>
                                                    <td><?= (new Snack_model())->nameById($item['snack_id']) ?></td>
                                                    <td><?= date('H:i', strtotime($item['horario'])) ?></td>
                                                    <td><?= Schedule_model::$comportamento[$item['comportamento']] ?></td>
                                                    <td><?= $item['message'] ?>
                                                        <span class="message_parent"><?= $item['message_parent'] ?></span>
                                                        <?php if (!$item['message_parent']): ?>
                                                        <a class="message_parent_icon" data-toggle="modal"
                                                           data-target="#modal-message" href="#"
                                                           @click="setId('<?= $id ?>:<?= $key ?>')"
                                                           title="Escrever recado">
                                                            <span class="fa fa-reply"></span>
                                                        </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                    <?php if ($key == "sono") : ?>
                                        <table class="table table-bordered table-striped">
                                            <tr class="active">
                                                <th>#</th>
                                                <th>Dormiu</th>
                                                <th>Acordou</th>
                                                <th>Recado</th>
                                            </tr>
                                            <?php foreach ($content as $item) :
                                                $id = $item['id'];
                                                ?>
                                                <tr>
                                                    <td><?= (new Snack_model())->nameById($item['snack_id']) ?></td>
                                                    <td><?= date('H:i', strtotime($item['dormiu'])) ?></td>
                                                    <td><?= date('H:i', strtotime($item['acordou'])) ?></td>
                                                    <td><?= $item['message'] ?>
                                                        <span class="message_parent"><?= $item['message_parent'] ?></span>
                                                        <?php if (!$item['message_parent']): ?>
                                                            <a class="message_parent_icon" data-toggle="modal"
                                                               data-target="#modal-message" href="#"
                                                               @click="setId('<?= $id ?>:<?= $key ?>')"
                                                               title="Escrever recado">
                                                                <span class="fa fa-reply"></span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                    <?php if ($key == "evacuacao") : ?>
                                        <table class="table table-bordered table-striped">
                                            <tr class="active">
                                                <th>#</th>
                                                <th>Textura</th>
                                                <th>Recado</th>
                                            </tr>
                                            <?php foreach ($content as $item) :
                                                $id = $item['id'];
                                                ?>
                                                <tr>
                                                    <td><?= (new Snack_model())->nameById($item['snack_id']) ?></td>
                                                    <td><?= Schedule_model::$evacuacao[$item['textura']] ?></td>
                                                    <td><?= $item['message'] ?>
                                                        <span class="message_parent"><?= $item['message_parent'] ?></span>
                                                        <?php if (!$item['message_parent']): ?>
                                                            <a class="message_parent_icon" data-toggle="modal"
                                                               data-target="#modal-message" href="#"
                                                               @click="setId('<?= $id ?>:<?= $key ?>')"
                                                               title="Escrever recado">
                                                                <span class="fa fa-reply"></span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                    <?php if ($key == "banho") : ?>
                                        <table class="table table-bordered table-striped">
                                            <tr class="active">
                                                <th>#</th>
                                                <th>Banhou?</th>
                                                <th>Recado</th>
                                            </tr>
                                            <?php foreach ($content as $item) :
                                                $id = $item['id'];
                                                ?>
                                                <tr>
                                                    <td><?= (new Snack_model())->nameById($item['snack_id']) ?></td>
                                                    <td><?= Schedule_model::$boolean[$item['value']] ?></td>
                                                    <td><?= $item['message'] ?>
                                                        <span class="message_parent"><?= $item['message_parent'] ?></span>
                                                        <?php if (!$item['message_parent']): ?>
                                                            <a class="message_parent_icon" data-toggle="modal"
                                                               data-target="#modal-message" href="#"
                                                               @click="setId('<?= $id ?>:<?= $key ?>')"
                                                               title="Escrever recado">
                                                                <span class="fa fa-reply"></span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endif; ?>
                                </fieldset>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-message">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Recado</h4>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" v-model="message">

                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" @click="update()" class="btn btn-primary">Enviar Recado</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function showMessage(type, message) {
        var x = document.getElementById("snackbar");
        x.innerText = message
        switch (type) {
            case 's':
                x.style.backgroundColor = '#42B983'
                break;
            case 'w':
                x.style.backgroundColor = '#ff8000'
                break
            case 'e':
                x.style.backgroundColor = '#e61919'
                break
            case 'i':
                x.style.backgroundColor = '#96D4D4'
                break
        }
        x.className = "show";
        setTimeout(function () {
            x.className = x.className.replace("show", "");
        }, 3000);
    }

    var app = new Vue({
        el: '#app',
        data() {
            return {
                id: null,
                message: '',
                code: ''
            }
        },
        methods: {
            setId(data) {
                let partials = data.split(':')
                this.id = partials[0];
                this.code = partials[1];
                this.message = ''
            },
            update() {
                let app = this;
                axios.post('<?=base_url()?>user/user/updateAgenda/', {
                    snack_code: this.code,
                    item: {
                        id: this.id,
                        message_parent: this.message
                    }
                }).then(function (response) {
                    showMessage('s', 'Recado enviado com sucesso!')
                    setTimeout(function (){
                        window.location.reload()
                    }, 500)
                }).catch(function (error) {
                    console.error(error)
                    alert('Erro ao enviar recado!')
                })

            },
        }
    })

    $(document).ready(function () {
        $('#app').show()
    })
</script>