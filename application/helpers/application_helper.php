<?php

use AG\DiscordMsg;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


if (!function_exists('search_key_in')) {


  function search_key_in($result, $key)
  {
    $value =  null;
    foreach ($result as $row) {

      if ($row->key == $key)
        $value = $row->value;
    }

    return $value;
  }
}



if (!function_exists('discord_log')) {

  function discord_log($message, $title = 'Logs')
  {
    $env =  sprintf('DISCORD_LOGS_%s', strtoupper(getenv('ENVIRONMENT')));
    if (!$env) return;
    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv($env),
      ''
    ))->send();
  }
}

if (!function_exists('discord_exception')) {

  function discord_exception($message, $title = 'Exception')
  {
    $env =  sprintf('DISCORD_EXCEPTIONS_%s', strtoupper(getenv('ENVIRONMENT')));
    if (!$env) return;
    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv($env),
      ''
    ))->send();
  }
}

if (!function_exists('discord_schedule_log')) {

  function discord_schedule_log($message, $title = 'Shedule Logs')
  {
    $env =  sprintf('DISCORD_EXCEPTIONS_%s', strtoupper(getenv('ENVIRONMENT')));
    if (!$env) return;

    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv($env),
      ''
    ))->send();
  }
}

if (!function_exists('discord_billet_old')) {

  function discord_billet_old($message, $title = 'Cobrança recorrente')
  {
    $env =  sprintf('DISCORD_BILLET_OLD_%s', strtoupper(getenv('ENVIRONMENT')));
    if (!$env) return;

    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv($env),
      ''
    ))->send();
  }
}



if (!function_exists('only_numeric')) {

  function only_numeric($str)
  {

    return preg_replace('#\D#', '', $str);
  }
}


function get_month(\DateTime $date)
{

  $options = [
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Marco',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'

  ];



  return $options[intval($date->format('m'))];
}


function getParseDocumentVariables(): Collection
{
  $CI = get_instance();
  $CI->load->model(['eloquent/Student_eloquent', 'eloquent/Fee_type_eloquent', 'Feesessiongroup_model']);

  $items =  collect([]);
  $types = $CI->Feesessiongroup_model->getFeesByGroup();
  foreach ($types as $row) {

    foreach ($row->feetypes as $item) {
      $items->push((object) ['id' => $item->feetype_id, 'type' => $item->type]);
    }
  }

  return $items->unique();
}
function getEditorVariables()
{

  // $CI = get_instance();
  // $CI->load->model(['eloquent/Student_eloquent', 'eloquent/Fee_type_eloquent', 'Feesessiongroup_model']);


  // // $options =  (new Student_eloquent)->getTableColumns();
  // $data = Fee_type_eloquent::all();

  // //  dump();

  // $options = [];
  // $items =  collect([]);
  // $types = $CI->Feesessiongroup_model->getFeesByGroup();
  // foreach ($types as $row) {

  //   foreach ($row->feetypes as $item) {
  //     $items->push((object) ['id' => $item->feetype_id, 'type' => $item->type]);
  //   }
  // }

  // $distincts = $items->unique();

  // foreach ($distincts as $row) {
  //   // $options[] = Str::slug($row->type, '_');
  //   // $options[] = sprintf('primeira_%s', Str::slug($row->type, '_'));
  //   // $options[] = sprintf('atual_%s', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_valor', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_quantidade', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_quantidade_extenso', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_valor_extenso', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_data', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_descricao', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_vencimento_dia', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_vencimento_mes', Str::slug($row->type, '_'));
  //   $options[] = sprintf('%s_@n_vencimento_ano', Str::slug($row->type, '_'));
  // }
  // $only = [
  //   'aluno_nome',
  //   'aluno_turma',
  //   'aluno_email',
  //   'guardiao_nome',
  //   'guardiao_email',
  //   'guardiao_logradouro',
  //   'guardiao_logradouro_numero',
  //   'guardiao_logradouro_cidade',
  //   'guardiao_logradouro_bairro',
  //   'guardiao_logradouro_estado',
  //   'guardiao_logradouro_cep',
  //   'guardiao_documento',
  //   'guardiao_ocupacao',
  //   'mes_atual_extenso',
  //   'mes_atual_numero',
  //   'dia_atual',
  //   'ano_atual'

  //   // 'email', 'guardian_name', 'state', 'city', 'firstname', 'lastname', 'guardian_occupation', "guardian_address",
  //   // "guardian_address_number",
  //   // "guardian_email",
  //   // "guardian_document",
  //   // "guardian_state",
  //   // "guardian_city",
  //   // "guardian_district",
  //   // "guardian_postal_code",
  //   // "guardian_postal_phone"

  // ];



  // $options = array_filter($options, function ($v) use ($only) {
  //   return in_array($v, $only);
  // });

  return  array_merge(get_student_var_document(), get_guardian_var_document() , get_finance_var_document() ); // implode(' | ',   array_map(function($str){  return sprintf('{%s}', $str);}, array_merge($only, $options)) );
}

function get_finance_var_document(): array
{
  
  $CI = get_instance();
  $CI->load->model(['eloquent/Student_eloquent', 'eloquent/Fee_type_eloquent', 'Feesessiongroup_model']);
  $options = [];
  $items =  collect([]);
  $types =  Fee_type_eloquent::orderBy('type','asc')->get(); //$CI->Feesessiongroup_model->getFeesByGroup();
  foreach ($types as $item) {

    // foreach ($row->feetypes as $item) {
      $items->push((object) ['id' => $item->id, 'type' => $item->type]);
    // }
  }

  $distincts = $items->unique();

  foreach ($distincts as $row) {
    // $options[] = Str::slug($row->type, '_');
    // $options[] = sprintf('primeira_%s', Str::slug($row->type, '_'));
    // $options[] = sprintf('atual_%s', Str::slug($row->type, '_'));
    
    $options[] = sprintf('%s_@n_valor', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_quantidade', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_quantidade_extenso', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_valor_extenso', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_data', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_descricao', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_vencimento_dia_extenso', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_vencimento_dia', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_vencimento_mes', Str::slug($row->type, '_'));
    $options[] = sprintf('%s_@n_vencimento_ano', Str::slug($row->type, '_'));
  }

  return $options;
}


function get_student_var_document(): array
{

  return [
    'aluno_nome',
    'aluno_turma',
    'aluno_email',
  ];
}


function double_to_base($val){
  // $str = preg_replace('#(R\$|\s)+#', '', $val);
  $v = (str_replace(',','.', str_replace(['.','R$'],['',''], $val)));
  return trim($v);  
}

function get_guardian_var_document(): array
{

  return [
    'guardiao_nome',
    'guardiao_email',
    'guardiao_logradouro',
    'guardiao_logradouro_numero',
    'guardiao_logradouro_cidade',
    'guardiao_logradouro_bairro',
    'guardiao_logradouro_estado',
    'guardiao_logradouro_cep',
    'guardiao_documento',
    'guardiao_ocupacao',
    'mes_atual_extenso',
    'mes_atual_numero',
    'dia_atual',
    'ano_atual'

    // 'email', 'guardian_name', 'state', 'city', 'firstname', 'lastname', 'guardian_occupation', "guardian_address",
    // "guardian_address_number",
    // "guardian_email",
    // "guardian_document",
    // "guardian_state",
    // "guardian_city",
    // "guardian_district",
    // "guardian_postal_code",
    // "guardian_postal_phone"

  ];
}


function getListaDiasFeriado($ano = null)
{

  if ($ano === null) {
    $ano = intval(date('Y'));
  }

  $pascoa = easter_date($ano); // retorna data da pascoa do ano especificado
  $diaPascoa = date('j', $pascoa);
  $mesPacoa = date('n', $pascoa);
  $anoPascoa = date('Y', $pascoa);

  $feriados = [
    // Feriados nacionais fixos
    mktime(0, 0, 0, 1, 1, $ano),   // Confraternização Universal
    mktime(0, 0, 0, 4, 21, $ano),  // Tiradentes
    mktime(0, 0, 0, 5, 1, $ano),   // Dia do Trabalhador
    mktime(0, 0, 0, 9, 7, $ano),   // Dia da Independência
    mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida
    mktime(0, 0, 0, 11, 2, $ano),  // Todos os santos
    mktime(0, 0, 0, 11, 15, $ano), // Proclamação da republica
    mktime(0, 0, 0, 12, 25, $ano), // Natal
    //
    // Feriados variaveis
    // mktime(0, 0, 0, $mesPacoa, $diaPascoa - 48, $anoPascoa), // 2º feria Carnaval
    // mktime(0, 0, 0, $mesPacoa, $diaPascoa - 47, $anoPascoa), // 3º feria Carnaval 
    mktime(0, 0, 0, $mesPacoa, $diaPascoa - 2, $anoPascoa),  // 6º feira Santa  
    mktime(0, 0, 0, $mesPacoa, $diaPascoa, $anoPascoa),      // Pascoa
    mktime(0, 0, 0, $mesPacoa, $diaPascoa + 60, $anoPascoa), // Corpus Christ
  ];

  sort($feriados);

  $listaDiasFeriado = [];
  foreach ($feriados as $feriado) {
    $data = date('Y-m-d', $feriado);
    $listaDiasFeriado[] = $data;
  }

  return $listaDiasFeriado;
}

function isFeriado($data)
{
  $listaFeriado = getListaDiasFeriado(date('Y', strtotime($data)));
  if (isset($listaFeriado[$data])) {
    return true;
  }

  return false;
}

function getUtilDay($aPartirDe, $quantidadeDeDias = 30)
{

  $listaDiasUteis = [];
  $contador = 0;
  // dump($quantidadeDeDias );
  while ($contador < $quantidadeDeDias) {
    $dateTime = new \DateTime($aPartirDe);
    $dateTime->modify('+' . $contador . ' day'); // adiciona um dia pulando finais de semana
    $data = $dateTime->format('Y-m-d');
    if (!in_array($data, getListaDiasFeriado())) {
      $listaDiasUteis[] = $data;
    }
    $contador++;
  }
  //  dump($listaDiasUteis);
  return $listaDiasUteis;
}

function isValidDay()
{
  $date = Carbon::now()->format('Y-m-d');
  $dateW = Carbon::now()->endOfMonth();
  // dump($date);
  return in_array($date, getUtilDay($date, Carbon::now()->diffInDays($dateW)));
}


if (!function_exists('extractArgument')) {

  function extractArgument($key, &$data)
  {
    $value = $data[$key] ?? $data[$key];

    unset($data[$key]);

    return $value;
  }
}


function mask($val, $mask)
{
  $maskared = '';
  $k = 0;
  for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
    if ($mask[$i] == '#') {
      if (isset($val[$k])) {
        $maskared .= $val[$k++];
      }
    } else {
      if (isset($mask[$i])) {
        $maskared .= $mask[$i];
      }
    }
  }

  return $maskared;
}
