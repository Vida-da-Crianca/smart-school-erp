<?php

use AG\DiscordMsg;

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
