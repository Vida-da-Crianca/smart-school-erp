<?php 


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