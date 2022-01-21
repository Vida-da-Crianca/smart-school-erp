<style type="text/css">
    body {
	font: 14px "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
	color: #3b3b3b;
}

h1,h2 {
	font-family: Georgia;
}

h1 {
	border-bottom: 3px solid #aaa;
	background-color: #3b3b3b;
	color: #ddd;
	padding: 5px;	
}

h2 {
	border-top: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	background-color: #DDD;
	padding-left: 5px;
	margin: 0 0 0 -15px;
	font-weight: normal;
}

.secao {
	background-color: #eee;

	padding-left: 15px;
	
	border: #ccc 1px dotted;
	
	margin-top: 1em;
}

a {
	text-decoration:none;
	color: #f33;
}

a:visited {
	text-decoration:none;
	color: #700;
}

a:hover {
	text-decoration:none;
	color: #fa0;
}

#menu {
	margin: 0;
}

#menu ul, #menu li {
	display: inline;
	list-style-type: none;
	margin: 0;
	padding: 0;
}

#menu .ativo {
	background-color: #ddd;
}

.vcard {
	padding: 5px;
}

.url, .email {
	display: block;
}

.email:after {
	content: url('img/mail.png');
	margin-left:0.3em;
}

.url:after {
	content: url('img/url.png');
	margin-left:0.3em;
}

td {width: 20em;}

tr.par {
	background-color: #ddd;
}

tr.impar {
	background-color: #eee;
}

td.ruim {color: #a99;}
td.regular {color: #a77;}
td.bom {color: #a55;}
td.otimo {color: #a33;}

.photo {
	float: right;
	margin-right: 5em;
	border: #fff 1em solid;
	
	-webkit-box-shadow: 0px 0px 5px 5px #191b30;
	-moz-box-shadow: 0px 0px 5px 5px #191b30;
	box-shadow: 0px 0px 5px 5px #191b30;
}

#footnote {
	border-top: 1px dashed #aaa;
	padding: 5px;
	font: 75% "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
	
}

#footnote li {
	list-style-type: none;
	margin-top: 3px;
}

fieldset {
	border: #ccc 1px dotted;
	margin-top: 1em;
}

label {
	font-weight: bold;
	margin-right: 10px;
	width: 15em;
}

label:after {
	content: ":";
}

form label {
	display: block;
}

input, textarea {
	border: #669 2px solid;
	display: block;
	width: 30em;
}

input[type=submit] {
	border: #bbb 1px solid;
	margin-top: 0.5em;
}
</style>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
			"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Curriculo Vitae</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	</head>
	
	<body>
		<h1>Currículo Vitae</h1>
		
		<div class="secao">
			<h2>Dados Pessoais</h2>			
				<div id="hcard-Ademir-Mazer-Jr" class="vcard">
				<span class="given-name">Nome: <?=$curriculo->nome?></span>
					<br />
				<span class="given-name">Data de Nascimento: <?=date('d/m/Y', strtotime($curriculo->data_nascimento))?> | <?=$this->curriculo_model->calcularIdade($curriculo->data_nascimento)?> anos</span>

				<?php if(isset($curriculo->email) && !empty($curriculo->email)){ ?>
				<a class="email" href="mailto:<?=$curriculo->email?>">E-mail: <?=$curriculo->email?></a>
				<?php } ?>
				
				<div class="adr">
				  <span class="locality">Endereço: <?=$curriculo->endereco?></span>
				,
				  <span class="region">CEP: <?=$curriculo->cep?></span>
				,
				  <span class="region">Nº: <?=$curriculo->numero?></span>
				 </div>

                    <div><?php echo $this->lang->line('gender');?> : <?php echo $curriculo->sexo; ?></div>
					<div><?php echo $this->lang->line('marital_status'); ?> : <?php echo $curriculo->estado_civil;?></div>
				</div>
		</div>
		
		<div class="secao">
			<h2>Mídias Sociais</h2>
			
			<?php if(isset($curriculo->facebook) && !empty($curriculo->facebook)){ ?>
				<a href="<?=$curriculo->facebook?>">
                    Facebook: <?=$curriculo->facebook?>
				</a>
			<?php } ?>
            <?php if(isset($curriculo->instagram) && !empty($curriculo->instagram)){ ?>
            <a href="<?=$curriculo->instagram?>">
                Instagram: <?=$curriculo->instagram?>
            </a>
            <?php } ?>
            <?php if(isset($curriculo->twitter) && !empty($curriculo->twitter)){ ?>
            <a href="<?=$curriculo->twitter?>">
                Twitter: <?=$curriculo->twitter?>
            </a>
            <?php } ?>
            <?php if(isset($curriculo->linkedin) && !empty($curriculo->linkedin)){ ?>
            <a href="<?=$curriculo->linkedin?>">
                Linkedin: <?=$curriculo->linkedin?>
            </a>
            <?php } ?>
		</div>

		<div class="secao">
			<h2>Dados Profissionais</h2>
			
			<p><?=$curriculo->work_exp?></p>
		</div>

		<div class="secao">
			<h2>Formação Acadêmica</h2>
			
			<p><?=$curriculo->cursos?></p>
		</div>

		<div class="secao">
			<h2>Formação Complementar / Outros</h2>
			<p><?=$curriculo->outros?></p>		
		</div>

		<div class="secao">
			<h2>Campos Adicionais</h2>
            <table>
                <?php
                $custom_fields_data = get_custom_table_values($curriculo->id, 'staff');
                if(!empty($custom_fields_data)){
                    foreach($custom_fields_data as $field_key => $field_value){
                ?>
                <tr>
                    <td><?=$field_value->name?></td>
                    <td class="bom">
                        <?php
                        if (is_string($field_value->field_value) && is_array(json_decode($field_value->field_value, true)) && (json_last_error() == JSON_ERROR_NONE)) {
                            $field_array = json_decode($field_value->field_value);
                            echo "<ul class='student_custom_field'>";
                            foreach ($field_array as $each_key => $each_value) {
                                echo "<li>" . $each_value . "</li>";
                            }
                            echo "</ul>";
                        } else {

                            $display_field = $field_value->field_value;
                            if ($field_value->type == "link") {
                                $display_field = "<a href=" . $field_value->field_value . " target='_blank'>" . $field_value->field_value . "</a>";
                            }
                            echo $display_field;
                        }
                        ?>
					</td>
                </tr>
                <?php
                    }
                }
                
                ?>
            </table>
		</div>	
	</body>
</html>