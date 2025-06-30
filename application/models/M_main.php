<?php
/**
 * Created by PhpStorm.
 * User: hoshy1207
 * Date: 2019-08-16
 * Time: 오후 1:04
 */

class M_main extends CI_Model{

    public function __construct(){

        parent::__construct();
    }

    // 사전예약 테이블
    function selectTotalEventCount(){
        return $this->db->get("RESERVE")->num_rows();
    }

    function selectEventCount(){
        if( $this->data['search_phone'] != "" ){
            $this->db->where('phone', $this->data['search_phone']);
        }
        if( $this->data['part'] != "all" ){
            $this->db->where('part', $this->data['part']);
        }
        if( $this->data['start_date'] != "" ){
            $this->db->where("reg_date >= '". $this->data['start_date'] . " 00:00:00'");
        }
        if( $this->data['end_date'] != "" ){
            $this->db->where("reg_date <= '". $this->data['end_date'] . " 23:59:59'");
        }
        $this->db->order_by("idx", "desc");
        return $this->db->get("RESERVE")->num_rows();
    }

    function selectEventList(){
        if ($this->data['page'] == 1 || $this->data['page'] < 0) {
            $this->offset = 0;
        } else {
            $this->offset = $this->data['size'] * ($this->data['page'] - 1);
        }

        $this->limit  = $this->data['size'];

        if( $this->data['search_phone'] != "" ){
            $this->db->where('phone', $this->data['search_phone']);
        }
        if( $this->data['part'] != "all" ){
            $this->db->where('part', $this->data['part']);
        }
        if( $this->data['start_date'] != "" ){
            $this->db->where("reg_date >= '". $this->data['start_date'] . " 00:00:00'");
        }
        if( $this->data['end_date'] != "" ){
            $this->db->where("reg_date <= '". $this->data['end_date'] . " 23:59:59'");
        }
        $this->db->order_by("idx", "desc");
        return $this->db->get("RESERVE", $this->limit , $this->offset)->result_array();
    }

    function selectEvent(){
        if( $this->data['search_phone'] != "" ){
            $this->db->where('phone', $this->data['search_phone']);
        }
        if( $this->data['part'] != "all" ){
            $this->db->where('part', $this->data['part']);
        }
        if( $this->data['start_date'] != "" ){
            $this->db->where("reg_date >= '". $this->data['start_date'] . " 00:00:00'");
        }
        if( $this->data['end_date'] != "" ){
            $this->db->where("reg_date <= '". $this->data['end_date'] . " 23:59:59'");
        }
        $this->db->order_by("idx", "desc");
        return $this->db->get("RESERVE")->result_array();
    }
}