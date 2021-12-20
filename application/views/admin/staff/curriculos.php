<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
           Todos os Currículos
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">

                        <?php if(isset($_GET['ver']) and !empty($_GET['ver'])):?>

                            <form id="form1" action="<?php echo base_url('admin/curriculos')?>" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="box-body">

                                    <div class="tshadow mb25 bozero">

                                        <h4 class="pagetitleh2">Informações Básicas </h4>


                                        <div class="around10">


                                            <input type="hidden" name="ci_csrf_token" value="">
                                            <div class="row">
                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Função</label><small class="req"> *</small>
                                                        <select id="role" name="role" class="form-control">
                                                            <option value="">Selecione</option>
                                                            <option value="1">Admin</option>
                                                            <option value="2">Teacher</option>
                                                            <option value="3">Accountant</option>
                                                            <option value="4">Librarian</option>
                                                            <option value="6">Receptionist</option>
                                                            <option value="7">Super Admin</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Cargo</label>

                                                        <select id="designation" name="designation" placeholder="" type="text" class="form-control">
                                                            <option value="select">Selecione</option>
                                                            <option value="4">Administrador (a)</option>
                                                            <option value="5">Atendente</option>
                                                            <option value="10">Auxiliar Administrativo </option>
                                                            <option value="8">Auxiliar de Limpeza</option>
                                                            <option value="2">Auxiliar Professor (a)</option>
                                                            <option value="7">Berçarista (a)</option>
                                                            <option value="11">Cuidadora PCD</option>
                                                            <option value="3">Estagiário (a)</option>
                                                            <option value="9">Monitor (a) Infantil</option>
                                                            <option value="1">Professor (a)</option>
                                                            <option value="6">Vendedor (a)</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Departamento</label>
                                                        <select id="department" name="department" placeholder="" type="text" class="form-control">
                                                            <option value="select">Selecione</option>
                                                            <option value="1">Diretoria</option>
                                                            <option value="3">Financeiro</option>
                                                            <option value="4">Pedagógico</option>
                                                            <option value="2">Secretária</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome Completo</label><small class="req"> *</small>
                                                        <input id="name" name="name" placeholder="" type="text" class="form-control" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <!--                                                   <div class="col-md-3">
                                                               <div class="form-group">
                                                                   <label for="exampleInputEmail1">Último Nome</label>
                                                                   <input id="surname" name="surname" placeholder="" type="text" class="form-control"  value="" />
                                                                   <span class="text-danger"></span>
                                                               </div>
                                                           </div>-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome Do Pai</label>
                                                        <input id="father_name" name="father_name" placeholder="" type="text" class="form-control" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome da mãe</label>
                                                        <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">E-Mail (Login Nome De Usuário)</label><small class="req"> *</small>
                                                        <input id="email" name="email" placeholder="" type="text" class="form-control" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile"> Sexo</label><small class="req"> *</small>
                                                        <select class="form-control" name="gender">
                                                            <option value="">Selecione</option>
                                                            <option value="Male">Masculino</option>
                                                            <option value="Female">Feminino</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Data de Nascimento</label><small class="req"> *</small>
                                                        <input id="dob" name="dob" placeholder="" type="text" class="form-control date" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Data De Inicío Contrato</label>
                                                        <input id="date_of_joining" name="date_of_joining" placeholder="" type="text" class="form-control date" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Telefone</label>
                                                        <input id="mobileno" name="contactno" placeholder="" type="text" class="form-control" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Número De Contato De Emergência</label>
                                                        <input id="mobileno" name="emergency_no" placeholder="" type="text" class="form-control" value="">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Estado Civil</label>
                                                        <select class="form-control" name="marital_status">
                                                            <option value="">Selecione</option>
                                                            <option value="Único">Único</option>

                                                            <option value="Casado">Casado</option>

                                                            <option value="Viúva">Viúva</option>

                                                            <option value="Separados">Separados</option>

                                                            <option value="Não Especificado">Não Especificado</option>



                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Foto</label>
                                                        <div><div class="dropify-wrapper"><div class="dropify-message"><p><i class="fa fa-cloud-upload dropi18"></i>Drag and drop a file here or click</p><p class="dropify-error">Ooops, something wrong appended.</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input class="filestyle form-control" type="file" name="file" id="file" size="20"><button type="button" class="dropify-clear">Remove</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">Drag and drop or click to replace</p></div></div></div></div>
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">




                                                <script>

                                                    function limpa_formulário_cep() {
                                                        //Limpa valores do formulário de cep.
                                                        document.getElementsByClassName('address-complete').value="...";

                                                    }

                                                    function meu_callback(conteudo) {
                                                        if (!("erro" in conteudo)) {
                                                            //Atualiza os campos com os valores.

                                                            var dados_endereco = conteudo.logradouro+' '+' '+conteudo.bairro+' '+' '+conteudo.localidade+' '+' '+conteudo.uf;


                                                            document.getElementById('address-complete').value=(dados_endereco);
                                                            document.getElementById('address-complete1').value=(dados_endereco);

                                                        } //end if.
                                                        else {
                                                            //CEP não Encontrado.
                                                            limpa_formulário_cep();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    }

                                                    function pesquisacep(valor) {

                                                        //Nova variável "cep" somente com dígitos.
                                                        var cep = valor.replace(/\D/g, '');

                                                        //Verifica se campo cep possui valor informado.
                                                        if (cep != "") {

                                                            //Expressão regular para validar o CEP.
                                                            var validacep = /^[0-9]{8}$/;

                                                            //Valida o formato do CEP.
                                                            if(validacep.test(cep)) {

                                                                //Preenche os campos com "..." enquanto consulta webservice.
                                                                document.getElementsByClassName('address-complete').value="...";


                                                                //Cria um elemento javascript.
                                                                var script = document.createElement('script');

                                                                //Sincroniza com o callback.
                                                                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                                                                //Insere script no documento e carrega o conteúdo.
                                                                document.body.appendChild(script);

                                                            } //end if.
                                                            else {
                                                                //cep é inválido.
                                                                limpa_formulário_cep();
                                                                alert("Formato de CEP inválido.");
                                                            }
                                                        } //end if.
                                                        else {
                                                            //cep sem valor, limpa formulário.
                                                            limpa_formulário_cep();
                                                        }
                                                    };

                                                </script>


                                                <div class="col-md-12 form-group">
                                                    <label for="exampleInputEmail1">CEP</label> <small class="req"> *</small>
                                                    <input maxlength="9" id="guardian_postal_code" name="guardian_postal_code" placeholder="" onblur="pesquisacep(this.value);" class="form-control" value="" autocomplete="off">
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Atual Endereço</label>
                                                        <div><textarea name="address" id="address-complete" class="form-control "></textarea>
                                                        </div>
                                                        <span class="text-danger"></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Endereço Permanente</label>
                                                        <div><textarea name="permanent_address" id="address-complete1" class="form-control address-complete"></textarea>
                                                        </div>
                                                        <span class="text-danger"></span></div>
                                                </div>

                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Qualificação</label>
                                                        <textarea id="qualification" name="qualification" placeholder="" class="form-control"></textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Experiência Profissional</label>
                                                        <textarea id="work_exp" name="work_exp" placeholder="" class="form-control"></textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Nota</label>
                                                        <div><textarea name="note" class="form-control"></textarea>
                                                        </div>
                                                        <span class="text-danger"></span></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6"><div class="form-group"><label for="custom_fields[staff][12]" class="control-label">RG</label><input type="text" id="custom_fields[staff][12]" name="custom_fields[staff][12]" class="form-control" value=""><span class="text-danger"></span></div></div><div class="col-md-12"><div class="form-group"><label for="custom_fields[staff][13]" class="control-label">Considerações Finais</label><textarea id="custom_fields[staff][13]" name="custom_fields[staff][13]" class="form-control"></textarea><span class="text-danger"></span></div></div><div class="col-md-12"><div class="form-group"><label for="custom_fields[staff][14]" class="control-label">Escolaridade</label><small class="req"> *</small><div class="checkbox"><label class="checkbox-inline"><input type="checkbox" id="custom_fields[staff][14]" name="custom_fields[staff][14][]" value="Ensino Fundamental Incompleto">Ensino Fundamental Incompleto</label><label class="checkbox-inline"><input type="checkbox" id="custom_fields[staff][14]" name="custom_fields[staff][14][]" value=" Ensino Fundamental Completo"> Ensino Fundamental Completo</label><label class="checkbox-inline"><input type="checkbox" id="custom_fields[staff][14]" name="custom_fields[staff][14][]" value=" Ensino Médio Incompleto"> Ensino Médio Incompleto</label><label class="checkbox-inline"><input type="checkbox" id="custom_fields[staff][14]" name="custom_fields[staff][14][]" value=" Ensino Médio Completo"> Ensino Médio Completo</label><label class="checkbox-inline"><input type="checkbox" id="custom_fields[staff][14]" name="custom_fields[staff][14][]" value=" Ensino Superior Incompleto"> Ensino Superior Incompleto</label><label class="checkbox-inline"><input type="checkbox" id="custom_fields[staff][14]" name="custom_fields[staff][14][]" value=" Ensino Superior Completo"> Ensino Superior Completo</label><span class="text-danger"></span></div></div></div>                                    </div>

                                        </div>
                                    </div>


                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Salvar</button>
                                </div>
                            </form>
                        <?php else:?>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Ações</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php



                                if(isset($curriculos) and !empty($curriculos)):?>
                                <?php



                                    foreach ($curriculos as $values){?>

                                    <tr>
                                        <th scope="row"><?php echo $values['nome']?></th>
                                        <td><?php echo $values['email']?></td>
                                        <td><?php echo $values['cpf']?></td>
                                        <td><a href="<?php echo base_url('admin/curriculos?ver='.$values['id'])?>" class="btn btn-primary btn-sm">Ver dados Completos</a></td>
                                    </tr>

                                <?php } endif;?>

                                </tbody>
                            </table>

                        <?php endif;?>

        </div>
        </div>
        </div>
        </div>

    </section>


</div>