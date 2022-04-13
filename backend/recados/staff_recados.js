$(document).ready(function(){
    
    $.ajax({
        url: baseurl + 'admin/admin/recados',
        method: 'GET',
        success: function(resp){

            if(resp.result === true && resp.data.length > 0){

                var form = '<form action="" class="recadosSend">';
                resp.data.forEach(recado => {
                    console.log(recado.estudante);
                    form += `<div class="form-group"><label>Agenda do aluno(a): ${recado.estudante.firstname} ${recado.estudante.lastname}  -  ` + Date.parse(recado[0].created_at).toString('dd-MM-yyyy') + `<br>Classe: ${recado.estudante.class}<br><code>Recado: ${recado[0].message_parent}</code></label>`;
                    form += `<textarea placeholder="Insira um recado para o responsável do aluno receber." class="recado form-control" required data-id='${recado[0].id}' data-tabela='${recado.tabela}' data-remove='${recado.internal_id}'></textarea></div>`;
                });
                
                $.confirm({
                    title: 'Responda os recados abaixo para prosseguir.',
                    columnClass: "medium",
                    theme: 'supervan',
                    content: '' +
                    '<form action="" class="formName">' +
                    form +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Enviar Recados',
                            btnClass: 'btn-green',
                            action: function () {
                                var data_request = [];
                                var can_continue = true;
                                this.$content.find('.recado').each(function(){
                                    if(!$(this).val()){
                                        can_continue = false;
                                        $.alert('Por favor, responda todos os recados.');
                                        return false;
                                    }
                                    var data_send = {
                                        id: $(this).attr('data-id'),
                                        message: $(this).val(),
                                        internal_id: $(this).attr('data-remove'),
                                        tabela: $(this).attr('data-tabela')
                                    };

                                    data_request.push(data_send);  
                                });

                                if(!can_continue)
                                    return false;

                                $.ajax({
                                    url: baseurl + 'admin/admin/send_recados',
                                    method: 'POST',
                                    data: { data: data_request },
                                    success: function(response){
                                        $.alert({
                                            title: 'Sucesso',
                                            content: 'Recados enviados com sucesso.'
                                        });

                                        return true;
                                    },
                                    error: function(err){
                                        console.error(err);
                                    }
                                });
                            }
                        }
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click');
                        });
                    }
                });

            }
        },
        error: function(err){
            console.error(err);
        }
    })
})