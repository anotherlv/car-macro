<?php

class M_api extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function selectUser($user_idx){
        $this->db->where("idx", $user_idx);
        return $this->db->get("users")->row_array();
    }
}