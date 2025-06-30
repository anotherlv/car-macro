<?php

class Upload extends CI_Controller{

    function __construct(){

        parent::__construct();
        $this->yield    = FALSE;
        $this->data["upload_path"]  = $this->config->item("upload_path");
    }

    // 이미지 업로드
    function imageUpload(){
        $img_name                   = "file-0";
        $today                      = date("Ymd");
        $img_path                   = '/upload/' . $today . '/';
        $config["upload_path"]      = $this->data['upload_path'] . $today . '/';
        $config["allowed_types"]    = 'gif|jpg|jpeg|png';
        $config["max_size"]         = '30720';
        $config["encrypt_name"]     = true;

        if(!is_dir($config["upload_path"])){
            mkdir($config["upload_path"] , 0777, true);
        }

        $this->load->library("upload", $config);
        $this->upload->initialize($config);

        $this->upload->do_upload($img_name);
        if( $this->upload->display_errors() != '' ){
            $result          = array("status" => "error" , "message" => $this->upload->display_errors());
        } else {
            $data 			 = $this->upload->data();
            $result 		 = array(
                "status"     => "success",
                "img_path"   => $img_path . $data["file_name"],
                "img_name"   => $data["orig_name"]
            );

        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}