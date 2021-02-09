<?php

use AG\DiscordMsg;
use Carbon\Carbon;

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
    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv('DISCORD_HOOK'),
      ''
    ))->send();
  }
}

if (!function_exists('discord_exception')) {

  function discord_exception($message, $title = 'Exception')
  {
    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv('DISCORD_EXCEPTIONS'),
      ''
    ))->send();
  }
}

if (!function_exists('discord_schedule_log')) {

  function discord_schedule_log($message, $title = 'Shedule Logs')
  {
    if (!getenv('DISCORD_SCHEDULE_HOOK')) return;
    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv('DISCORD_SCHEDULE_HOOK'),
      ''
    ))->send();
  }
}

if (!function_exists('discord_billet_old')) {

  function discord_billet_old($message, $title = 'Cobrança recorrente')
  {
    if (!getenv('DISCORD_BILLET_OLD_HOOK')) return;
    (new DiscordMsg(
      sprintf('**%s** %s``` %s ```', $title, PHP_EOL, $message), // message
      getenv('DISCORD_BILLET_OLD_HOOK'),
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


function getEditorVariables()
{

  $CI = get_instance();
  $CI->load->model('eloquent/Student_eloquent');


  $options =  (new Student_eloquent)->getTableColumns();
  $only = [
    'email', 'guardian_name', 'state', 'city', 'firstname', 'lastname', 'guardian_occupation', "guardian_address",
    "guardian_address_number",
    "guardian_email",
    "guardian_document",
    "guardian_state",
    "guardian_city",
    "guardian_district",
    "guardian_postal_code",
    "guardian_postal_phone"

  ];

  $options = array_filter($options, function ($v) use ($only) {
    return in_array($v, $only);
  });

  return implode(' | ', array_map(function ($v) {
    return sprintf('{%s}', $v);
  }, $options));
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
    $dateTime->modify('+'.$contador.' day'); // adiciona um dia pulando finais de semana
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
