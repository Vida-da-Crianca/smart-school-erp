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