<?php

class M_ai extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function insertData($data){
        return $this->db->insert("ai", $data);
    }

    function selectAiCount(){
        $this->db->select("idx");
        return $this->db->count_all_results("ai");
    }

    function selectAiList(){
        if ($this->data["page"] == 1 || $this->data["page"] < 0) {
            $this->offset   = 0;
        } else {
            $this->offset   = $this->data["size"] * ($this->data["page"] - 1);
        }
        $this->limit        = $this->data["size"];
        return $this->db->get("ai", $this->limit , $this->offset)->result_array();
    }

    function selectAi($G, $J){
        $this->db->select("BQ as A, BA as B, AK as C, AC as D, AS as E, BI as F, CG as G");
        $this->db->where("G <= ", $G);
        $this->db->where("J", $J);
        return $this->db->get("ai")->result_array();
    }
}