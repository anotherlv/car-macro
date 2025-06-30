<?php

class Login extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->yield        = FALSE;
    }

    function index(){
        $this->load->view("login");
    }

    function loginProcess(){
        $id                     = $this->input->post("id") ? $this->input->post("id") : "";
        $password               = $this->input->post("password") ? $this->input->post("password") : "";
        $result_data            = array();
        if( $id == "admin" && $password == "1234" ){
            $this->session->set_userdata("is_login", true);
            $result_data["status"]  = "success";
        }else {
            $result_data["status"] = "fail";
        }

        echo json_encode($result_data);
    }

    function logout(){
        $this->session->sess_destroy();
        redirect("/login");
    }
}