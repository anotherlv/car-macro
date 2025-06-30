<?php

class M_users extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function selectUsersCount(){
        $this->db->select("idx");
        return $this->db->count_all_results("users");
    }

    function selectUsersList(){
        if ($this->data["page"] == 1 || $this->data["page"] < 0) {
            $this->offset   = 0;
        } else {
            $this->offset   = $this->data["size"] * ($this->data["page"] - 1);
        }
        $this->limit        = $this->data["size"];
        $this->db->select("u.idx, u.name, i.directdb_total_price, i.kb_total_price, i.samsung_total_price, i.hyundai_total_price, i.meritz_total_price");
        $this->db->join("users_insurance i", "u.idx = i.user_idx", "left");
        $this->db->order_by("u.idx", "desc");
        return $this->db->get("users u", $this->limit , $this->offset)->result_array();
    }

    function selectUsers(){
        $this->db->join("users_insurance i", "u.idx = i.user_idx", "left");
        $this->db->where("u.idx", $this->data["idx"]);
        return $this->db->get("users u")->row_array();
    }

    function insertUsers($data){
        return $this->db->insert("users_insurance", $data);
    }

    function updateUsers($user_idx, $data){
        $this->db->where("user_idx", $user_idx);
        return $this->db->update("users_insurance", $data);
    }

    function selectUsersInsurance($user_idx){
        $this->db->where("user_idx", $user_idx);
        return $this->db->get("users_insurance")->row_array();
    }

    function insertUsersInsurance($data){
        return $this->db->insert("users_insurance", $data);
    }

    function updateUsersInsurance($user_idx, $data){
        $this->db->where("user_idx", $user_idx);
        return $this->db->update("users_insurance", $data);
    }

}