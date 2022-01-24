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

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #222533;
    }

    select[multiple]:focus option:checked {
        background: red linear-gradient(0deg, red 0%, red 100%);
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
                <h3 class="box-title titlefix"> <?php echo
                    $this->lang->line('schedule_frm_create'); ?> </h3>
                <div class="box-tools pull-right">
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
                                            <input v-model="agenda.date" type="date" name="data"
                                                   class="form-control disabled"
                                                   placeholder="Data" readonly="readonly">
                                        </div>
                                        <div class="col-xs-12 col-sm-5 col-md-5 no-padding-right margin-bottom">
                                            <label>Tipo de Refeição</label>
                                            <select class="form-control" required="required" v-model="snack_id">
                                                <option value="">Selecione o tipo de refeição</option>
                                                <option v-for="snack in snacks" :value="snack.id">{{snack.name}}
                                                </option>

                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-5 col-md-5 no-padding-right margin-bottom"
                                             style="max-height: 100px; overflow-y: scroll">
                                            <label>Turma</label>
                                            <?php
                                            foreach ($classes as $key => $class) {
                                                ?>
                                                <div class="checkbox" style="margin-top: -4px;">
                                                    <label>
                                                        <input type="checkbox" value="<?= $class['class_id'] ?>"
                                                               v-model="agenda.class_id">
                                                        <?= $class['class'] ?>
                                                        - <?= $class['section'] ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                            </form>
                            <div class="row" style="text-align: center">
                                <div class="col-md-12" style="color: #0c314e">
                                    <h3 v-if="snackData">{{snackData.name}}</h3>
                                </div>
                            </div>
                            <div class="panel panel-primary row" v-for="student in students" style="padding: 10px;">
                                <div class="col-md-3"><strong>{{student.firstname}} {{student.lastname}}</strong></div>
                                <div class="col-md-9 row" v-if="snackData.code==='alimentacao'">
                                    <div v-for="(agendaOld, index) in student.old_agendas" class="col-md-12 row"
                                         :style="!newRecord || index !== student.old_agendas.length-1 ? 'background: #c0c0c0; border-bottom: 1px; solid #fff' : ''">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Horário</label>
                                                <input @change="update(agendaOld)" v-model="agendaOld.horario"
                                                       class="form-control"
                                                       type="time">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Comportamento</label><br>
                                                <?php
                                                foreach (Schedule_model::$comportamento as $key => $item) { ?>
                                                    <label class="radio-inline">
                                                        <input @change="update(agendaOld)" type="radio"
                                                               v-model="agendaOld.comportamento"
                                                               :name="'comportamento_ag_'+agendaOld.id"
                                                               value="<?= $key ?>"> <?= $item ?>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="update(agendaOld)"
                                                       v-model="agendaOld.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Horário</label>
                                                <input @change="save(student)"
                                                       v-model="student.agenda.alimentacao.horario"
                                                       class="form-control"
                                                       type="time">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Comportamento</label><br>
                                                <?php
                                                foreach (Schedule_model::$comportamento as $key => $item) { ?>
                                                    <label class="radio-inline">
                                                        <input @change="save(student)"
                                                               v-model="student.agenda.alimentacao.comportamento"
                                                               type="radio"
                                                               :name="'comportamento_'+student.id"
                                                               value="<?= $key ?>"> <?= $item ?>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="save(student)"
                                                       v-model="student.agenda.alimentacao.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 row" v-if="snackData.code==='sono'">
                                    <div v-for="(agendaOld, index) in student.old_agendas" class="col-md-12 row"
                                         :style="!newRecord || index !== student.old_agendas.length-1 ? 'background: #c0c0c0; border-bottom: 1px; solid #fff' : ''">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Dormiu</label>
                                                <input @change="update(agendaOld)" v-model="agendaOld.dormiu"
                                                       class="form-control" type="time">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Acordou</label>
                                                <input @change="update(agendaOld)" v-model="agendaOld.acordou"
                                                       class="form-control" type="time">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="update(agendaOld)"
                                                       v-model="agendaOld.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Dormiu</label>
                                                <input @change="save(student)" v-model="student.agenda.sono.dormiu"
                                                       class="form-control" type="time">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Acordou</label>
                                                <input @change="save(student)" v-model="student.agenda.sono.acordou"
                                                       class="form-control" type="time">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="save(student)"
                                                       v-model="student.agenda.sono.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-9 row" v-if="snackData.code==='evacuacao'">
                                    <div v-for="(agendaOld, index) in student.old_agendas" class="col-md-12 row"
                                         :style="!newRecord || index !== student.old_agendas.length-1 ? 'background: #c0c0c0; border-bottom: 1px; solid #fff' : ''">
                                        <div class="col-md-6 item-line">
                                            <label>Textura</label><br>
                                            <?php
                                            foreach (Schedule_model::$evacuacao as $key => $evacuacao) { ?>
                                                <label class="radio-inline">
                                                    <input @change="update(agendaOld)"
                                                           v-model="agendaOld.textura" type="radio"
                                                           :name="'evacuacao_ag_'+agendaOld.id"
                                                           value="<?= $key ?>"> <?= $evacuacao ?>
                                                </label>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="update(agendaOld)"
                                                       v-model="agendaOld.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="col-md-6 item-line">
                                            <label>Textura</label><br>
                                            <?php
                                            foreach (Schedule_model::$evacuacao as $key => $evacuacao) { ?>
                                                <label class="radio-inline">
                                                    <input @change="save(student)"
                                                           v-model="student.agenda.evacuacao.textura" type="radio"
                                                           :name="'evacuacao_'+student.id"
                                                           value="<?= $key ?>"> <?= $evacuacao ?>
                                                </label>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="save(student)"
                                                       v-model="student.agenda.evacuacao.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 row" v-if="snackData.code==='banho'">
                                    <div v-for="(agendaOld, index) in student.old_agendas" class="col-md-12 row"
                                         :style="!newRecord || index !== student.old_agendas.length-1 ? 'background: #c0c0c0; border-bottom: 1px; solid #fff' : ''">
                                        <div class="col-md-4 item-line">
                                            <label>Banho</label><br>
                                            <?php
                                            foreach (Schedule_model::$boolean as $key => $item) { ?>
                                                <label class="radio-inline">
                                                    <input @change="update(agendaOld)" v-model="agendaOld.value"
                                                           type="radio" :name="'banho_ag'+agendaOld.id"
                                                           value="<?= $key ?>"> <?= $item ?>
                                                </label>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="update(agendaOld)"
                                                       v-model="agendaOld.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Horário</label>
                                                <input class="form-control" type="time" readonly disabled
                                                       :value="agendaOld.created_at.substring(11)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Banho</label><br>
                                                <?php
                                                foreach (Schedule_model::$boolean as $key => $item) { ?>
                                                    <label class="radio-inline">
                                                        <input @change="save(student)"
                                                               v-model="student.agenda.banho.value"
                                                               type="radio" :name="'banho_'+student.id"
                                                               value="<?= $key ?>"> <?= $item ?>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Recado</label>
                                                <input @change="save(student)"
                                                       v-model="student.agenda.banho.message"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"
        integrity="sha512-eYSzo+20ajZMRsjxB6L7eyqo5kuXuS2+wEbbOkpaur+sA2shQameiJiWEzCIDwJqaB0a4a6tCuEvCOBHUg3Skg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        data: {
            snack_id: null,
            students: [],
            snacks: JSON.parse('<?=json_encode($snacks)?>'),
            classes: JSON.parse('<?=json_encode($classes)?>'),
            snackData: null,
            agenda: {
                date: null,
                class_id: null,
                snack_id: null,
            },
            schedule: null,
            form: null,
            newRecord: false,
            saving: false,
            interval: null
        },
        watch: {
            snack_id(val) {
                if (val) {
                    this.agenda.snack_id = val;
                    this.getStudentsBySnackId();
                    for (let i = 0; i < this.snacks.length; i++) {
                        if (this.snacks[i].id === val) {
                            this.snackData = this.snacks[i];
                        }
                    }
                }
            },
            'agenda.class_id'(val) {
                if (val) {
                    //this.snack_id = null
                    this.getStudentsBySnackId();
                    this.getSchedule();
                }
            }
        },
        created() {
            Date.prototype.getFullMinutes = function () {
                if (this.getMinutes() < 10) {
                    return '0' + this.getMinutes();
                }
                return this.getMinutes();
            };
            Date.prototype.getFullHours = function () {
                if (this.getHours() < 10) {
                    return '0' + this.getHours();
                }
                return this.getHours();
            };

            Date.prototype.getFullMonth = function () {
                let month = this.getMonth() + 1;
                if (month < 10) {
                    return '0' + month;
                }
                return this.getMonth();
            };

            Date.prototype.getFullDay = function () {
                if (this.getDate() < 10) {
                    return '0' + this.getDate();
                }
                return this.getDate();
            };
            var day = new Date();
            this.agenda.date = day.getFullYear() + '-' + day.getFullMonth() + '-' + day.getFullDay();
            this.agenda.class_id = this.classes.map((classe) => {
                return classe.class_id
            })
        },
        mounted() {
            let app = this;
        },
        methods: {
            isValidSchedule() {
                if (!this.agenda.date) return false;
                if (!this.agenda.snack_id) return false;
                if (!this.agenda.class_id) return false;
                return true;
            },
            async getStudentsBySnackId() {
                if (!this.isValidSchedule()) return;
                let app = this
                await axios.post('/admin/schedule/studentsBySnackId/' + this.agenda.snack_id, {
                    ...this.agenda
                })
                    .then(function (response) {
                        let day = new Date();
                        let minutes = day.getFullMinutes();
                        let hour = day.getFullHours();
                        app.students = response.data.map((student) => {
                            student['agenda'] = {}
                            student['agenda']['alimentacao'] = {
                                id: null,
                                horario: hour + ':' + minutes,
                                comportamento: null
                            }
                            student['agenda']['sono'] = {
                                id: null,
                                dormiu: null,
                                acordou: null,
                                message: null,
                            }
                            student['agenda']['banho'] = {
                                id: null,
                            }
                            student['agenda']['evacuacao'] = {
                                id: null,
                                textura: null,
                            }
                            student['old_agendas'] = []
                            return student;
                        })

                    })
                    .catch(function (error) {
                        console.error(error)
                        alert('Erro ao carregar os alunos')
                    })
                if (this.students.length > 0) {
                    for (let i = 0; i < app.students.length; i++) {
                        app.students[i].old_agendas = await app.getAgendaData(app.students[i])
                    }
                }
            },
            getSchedule() {
                if (!this.agenda.date) return false;
                if (!this.agenda.class_id) return false;
                let app = this
                axios.post('/admin/schedule/getScheduleOrCreate/', {
                    ...this.agenda
                }).then(function (response) {
                    app.schedule = response.data
                }).catch(function (error) {
                    alert('Erro ao carregar os agenda')
                })
            },
            sleep(milliseconds) {
                const date = Date.now();
                let currentDate = null;
                do {
                    currentDate = Date.now();
                } while (currentDate - date < milliseconds);
            },
            async save(student) {
                let app = this;
                if (this.saving) {
                    await this.sleep(500)
                }
                if (this.students.length > 0) {
                    if (student.agenda[app.snackData.code].id) {
                        this.update(student.agenda[app.snackData.code])
                        return;
                    }

                    if (app.snackData.code === 'alimentacao') {
                        if (!student.agenda.alimentacao.comportamento || !student.agenda.alimentacao.horario)
                            return;
                    }

                    await axios.post('/admin/schedule/saveAgenda/', {
                        student: {
                            agenda: student.agenda,
                            id: student.id,
                            snack: app.snackData,
                            agenda_id: app.schedule.id
                        }
                    }).then(function (response) {
                        student.agenda[app.snackData.code].id = response.data
                        showMessage('s', 'Salvo com sucesso!')
                    }).catch(function (error) {
                        console.error(error)
                        alert('Erro ao carregar os agenda')
                    })

                }
            },
            update(agendaOld) {

                let app = this;
                axios.post('/admin/schedule/updateAgenda/', {
                    snack_code: app.snackData.code,
                    data: agendaOld
                }).then(function (response) {
                    showMessage('s', 'Salvo com sucesso!')
                }).catch(function (error) {
                    console.error(error)
                    alert('Erro ao alterar a agenda')
                })

            },
            async getAgendaData(student) {
                let result = []
                let app = this
                await axios.post('/admin/schedule/getAgendaOldData/', {
                    agenda_id: app.schedule.id,
                    student_id: student.id,
                    snack_id: app.snackData.id,
                    snack_code: app.snackData.code,
                })
                    .then(function (response) {
                        result = response.data

                    })
                    .catch(function (error) {
                        console.error(error)
                        alert('Erro ao carregar os alunos')
                    })

                return result
            }
        }
    })
    //2022
    $(document).ready(function () {
        $('#app').show()
    })
</script>