<?php

class Ai extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("m_ai");
        $this->common->checkLogin();

        $this->data["idx"]              = $this->input->get_post("idx") ?? "";
        $this->data["size"]             = $this->input->get_post("size") ?? 20;
        $this->data["page"]             = $this->input->get_post("page") ?? 1;
        $this->data["search_field"]     = $this->input->get_post("search_field") ?? "";
        $this->data["search_string"]    = $this->input->get_post("search_string") ? str_replace("'", "", str_replace('"', '', $this->input->get_post("search_string"))) : "";
        $this->data["cur_page"]         = $this->data["page"];
    }

    function index(){
        $this->data["tot_row"]          = $this->m_ai->selectAiCount();
        $this->data["tot_page"] 	    = ceil($this->data["tot_row"]  /  $this->data["size"] );
        $this->data["cur_num"]          = $this->data["tot_row"] - $this->data["size"] * ($this->data['cur_page'] - 1);
        $this->data["result"]           = $this->m_ai->selectAiList();
        $this->paging->init($this->data);
        $this->data["paging"]           = $this->paging->createPaging();
        $this->load->view("/ai/index", $this->data);
    }

    function resultProcess(){
        $this->yield    = false;
        $G              = $this->input->post("G", true) ?? "";
        $J              = $this->input->post("J", true) ?? "";

        $result         = $this->m_ai->selectAi($G, $J);
        $A_result       = 0;
        $B_result       = 0;
        $C_result       = 0;
        $D_result       = 0;
        $E_result       = 0;
        $F_result       = 0;
        $G_result       = 0;
        $result_cnt     = count($result);
        foreach( $result as $rows ){
            $A_result   += $rows["A"];
            $B_result   += $rows["B"];
            $C_result   += $rows["C"];
            $D_result   += $rows["D"];
            $E_result   += $rows["E"];
            $F_result   += $rows["F"];
            $G_result   += $rows["G"];
        }
        $A_result       = $A_result > 0 ? $A_result + mt_rand(300000, 500000) : 0;
        $B_result       = $B_result > 0 ? $B_result + mt_rand(300000, 500000) : 0;
        $C_result       = $C_result > 0 ? $C_result + mt_rand(300000, 500000) : 0;
        $D_result       = $D_result > 0 ? $D_result + mt_rand(300000, 500000) : 0;
        $E_result       = $E_result > 0 ? $E_result + mt_rand(300000, 500000) : 0;
        $F_result       = $F_result > 0 ? $F_result + mt_rand(300000, 500000) : 0;
        $G_result       = $G_result > 0 ? $G_result + mt_rand(300000, 500000) : 0;

        $A_result       = number_format($A_result / $result_cnt);
        $B_result       = number_format($B_result / $result_cnt);
        $C_result       = number_format($C_result / $result_cnt);
        $D_result       = number_format($D_result / $result_cnt);
        $E_result       = number_format($E_result / $result_cnt);
        $F_result       = number_format($F_result / $result_cnt);
        $G_result       = number_format($G_result / $result_cnt);

        $data           = [
            "A_result"  => $A_result,
            "B_result"  => $B_result,
            "C_result"  => $C_result,
            "D_result"  => $D_result,
            "E_result"  => $E_result,
            "F_result"  => $F_result,
            "G_result"  => $G_result,
        ];

        echo json_encode($data);
    }
}