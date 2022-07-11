<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uploader extends CI_Controller {

    private $resp_status = false;
    private $resp_msg = '';


    public function __construct() {
        parent::__construct();

         //$this->checkAuth();

    }

    public function uploadArquivo(){
         if($this->checkAjaxSubmit())
        {
            try
            {

                error_reporting(E_ALL);
		ini_set('display_errors', 1);
                //$this->modelTransStart();
                $tipo = (int) $this->_post('tipo'); //0: Nenhum 1: Apostilas 2: Resumos 3: Video  4: Curiosidades 5: Materiais Complementares

                switch ($tipo){
                    case 1:
                        $folder = 'apostilas';
                        break;
                    case 2:
                        $folder = 'resumos';
                        break;
                    case 3:
                        $folder = 'videos';
                        break;
                    case 4:
                        $folder = 'curiosidades';
                        break;
                    case 5:
                        $folder = 'materiais_complementares';
                        break;
                    case 55:
                        $folder = 'instrucoes';
                        break;
                    case 66:
                        $folder = 'cronograma';
                        break;
                }

               // $folder = trim($this->_post('folder'));
                //$slug = $this->tools->decode($this->session->slug);

                $dir = FOLDER_FILES.$folder.'/';
                //throw new Exception($this->session->slug);
                if(!is_dir($dir)){
                    mkdir($dir);
                }

                $img = isset($_FILES['fileupload']) ? $_FILES['fileupload'] : null;

                if($img && !empty($img['name'])){

                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $imagemNome = str_replace(['.',' ','+'],['_','',''],$img['name']).uniqid();
                    $config = array(
                        'upload_path'   => $dir,
                        'allowed_types' => 'pdf|PDF',
                        'max_size'      => 100048,//2MB
                        //'min_width'     => 100,
                       // 'min_height'    => 100,
                       // 'max_width'     => 2000,
                       // 'max_height'    => 2000,
                        'overwrite'     => true,
                        'encrypt_name'  => false,
                        'file_name'     => $imagemNome . '.' . $ext
                    );

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('fileupload')){
                        throw new Exception('Erro ao Enviar Arquivo: '.  $this->upload->display_errors('',''));
                    }

                    $dadosUpload = $this->upload->data();

                }else{
                    throw new Exception('Defina o Arquivo a Ser Enviado');
                }

                // Converter para webp
                $webp = webpImagem($dadosUpload['full_path'], 70, true);

                $this->resp_status = true;
                $this->resp_msg = array('name'=>$imagemNome . '.webp','base64'=> base64_encode(file_get_contents($webp)));

            } catch (Exception $ex) {
                $this->resp_status = false;
                $this->resp_msg = $ex->getMessage();
            }

            $this->showJSONResp();
        }
    }


    public function preUpload() {


        //if($this->checkAjaxSubmit())
        //{
            try
            {
                $dir = FCPATH.'uploads/pre_upload/';
                $campo = trim($this->input->post('campo'));
                $img = isset($_FILES[$campo]) ? $_FILES[$campo] : null;



                if($img && !empty($img['name'])){
                    $info = pathinfo($img['name']);
                    $nome_img = md5(uniqid() . time() . $img['name']);
                    $extension = '.' . $info['extension'];

                    move_uploaded_file($img["tmp_name"], $dir . $nome_img . $extension);
                    $webp = webpImagem($dir . $nome_img . $extension, 70, true);
                    $this->resp_status = true;
                    $this->resp_msg = array('name'=> basename($webp),'base64'=> base64_encode(file_get_contents($webp)));
                }
                else{
                    throw new Exception('Defina a Imagem');
                }

                //$this->modelTransStart();

                /*$folder = trim($this->input->post('folder'));
                //$slug = $this->tools->decode($this->session->slug);

                $dir = FCPATH.'pre_upload/';
                //throw new Exception($dir);
                if(!is_dir($dir)){
                    mkdir($dir);
                }

                $img = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : null;

                if($img && !empty($img['name'])){

                    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $imagemNome = uniqid().uniqid().uniqid().uniqid().'.'.$ext;

                    $config = array(
                        'upload_path'   => $dir,
                        'allowed_types' => 'png|jpg|jpeg',
                        'max_size'      => 6048,//2MB
                        //'min_width'     => 100,
                       // 'min_height'    => 100,
                       // 'max_width'     => 2000,
                       // 'max_height'    => 2000,
                        'overwrite'     => true,
                        'encrypt_name'  => false,
                        'file_name'     => $imagemNome
                    );

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('arquivo')){
                        throw new Exception('Erro ao Enviar Imagem: '.  $this->upload->display_errors('',''));
                    }

                    $dadosUpload = $this->upload->data();

                    $fixRatioW = $this->input->post('fixRatioW');

                    if($fixRatioW == 'S'){//largura deve ser maior que altura
                        if((int) $dadosUpload['image_width'] <= (int) $dadosUpload['image_height']){
                            throw new Exception('A Largura da Imagem Deve Ser Maior que a Altura!');
                        }
                    }

                    if((int) $this->input->post('min_w') > 0){
                        if((int) $dadosUpload['image_width'] < (int) $this->input->post('min_w')){
                            throw new Exception('A Imagem Deve Ter No Mínimo: '.(int) $this->input->post('min_w').'px');
                        }
                    }

                    $file_ext = trim($this->input->post('file_ext'));
                    if(!empty($file_ext) && $dadosUpload['image_type'] != trim($this->input->post('file_ext'))){
                        throw new Exception('Formato da Imagem Não Permitido!');
                    }


                }else{
                    throw new Exception('Defina a Imagem');
                }


               // $this->modelTransEnd();*/

            } catch (Exception $ex) {
                $this->resp_status = false;
                $this->resp_msg = $ex->getMessage();
            }

            $this->showJSONResp();
        //}
    }

   protected function showJSONResp()
    {
        echo json_encode(array('status' => $this->resp_status, 'msg' => $this->resp_msg));
        exit;
    }
}
