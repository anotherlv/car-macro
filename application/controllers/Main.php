<?php

class Main extends CI_Controller{

    public function __construct(){
        parent::__construct();

        $this->common->checkLogin();
        $this->data["manager_idx"]      = $this->session->userdata("manager_idx");
        $this->data["manager_auth"]     = $this->session->userdata("manager_auth");
    }

    function index(){
        $this->load->view('index', $this->data);
    }
}