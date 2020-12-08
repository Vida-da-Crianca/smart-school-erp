<?php

use AG\DiscordMsg;

if( !function_exists('search_key_in')) {


    function search_key_in($result, $key)
    {
          $value =  null;
          foreach($result as $row){
                  
            if( $row->key == $key)
                 $value = $row->value;
          }

          return $value;
    }
} 



if(! function_exists('discord_log')) {

  function discord_log($message, $title = 'Logs')
  {
          (new DiscordMsg(
            sprintf('**%s** %s``` %s ```', $title, PHP_EOL,$message), // message
            getenv('DISCORD_HOOK'),
            ''
        ))->send();
  }

}

if(! function_exists('discord_exception')) {

  function discord_exception($message, $title = 'Exception')
  {
          (new DiscordMsg(
            sprintf('**%s** %s``` %s ```', $title, PHP_EOL,$message), // message
            getenv('DISCORD_EXCEPTIONS'),
            ''
        ))->send();
  }
  
}


if( !function_exists('only_numeric')) {

  function only_numeric($str){

    return preg_replace('#\D#','', $str);
  }
}


function get_month(\DateTime $date){

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