<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller
{

    private $resp_status = false;
    private $resp_msg = '';


    public function teste(){


        $this->db->from('permission_category');

        $get = $this->db->get();


        $count = $get->num_rows();


        if($count > 0):


            $result = $get->result_array();


        echo '<pre>';
        var_dump($result);

         //   echo 'Teste ok';


        else:

            echo 'teste erro';

        endif;



    }



}