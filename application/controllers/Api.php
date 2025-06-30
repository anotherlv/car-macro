<?php

class Api extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->yield        = FALSE;
        $this->load->model("m_api");
    }

    function getData(){
        $user_idx           = $this->input->post("user_idx", true) ?? "";
        $data               = [];
        if( !empty($user_idx) && is_numeric($user_idx) ){
            $result         = $this->m_api->selectUser($user_idx);
            if( !empty($result) ){
                $data["status"]             = "success";
                $data["data"]               = $result;
                error_log("api 요청 = 성공");
            }else{
                $data["status"] = "error";
                error_log("api 요청 = 실패");
            }
        }else{
            $data["status"] = "empty";
            error_log("api 요청 = 빈 값");
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}