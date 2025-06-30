<?php

class Users extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model("m_users");
        $this->common->checkLogin();

        $this->data["idx"]              = $this->input->get_post("idx") ?? "";
        $this->data["size"]             = $this->input->get_post("size") ?? 20;
        $this->data["page"]             = $this->input->get_post("page") ?? 1;
        $this->data["search_field"]     = $this->input->get_post("search_field") ?? "";
        $this->data["search_string"]    = $this->input->get_post("search_string") ? str_replace("'", "", str_replace('"', '', $this->input->get_post("search_string"))) : "";
        $this->data["cur_page"]         = $this->data["page"];
        $this->data["base_url"]         = current_url() . "?search_field=" . $this->data["search_field"] . "&search_string=" . $this->data["search_string"];
    }

    function index(){
        $this->data["member_type"]          = 1;
        $this->data["tot_row"]              = $this->m_users->selectUsersCount();
        $this->data["tot_page"] 	        = ceil($this->data["tot_row"]  /  $this->data["size"] );
        $this->data["cur_num"]              = $this->data["tot_row"] - $this->data["size"] * ($this->data['cur_page'] - 1);
        $this->data["result"]               = $this->m_users->selectUsersList();
        $this->paging->init($this->data);
        $this->data["paging"]               = $this->paging->createPaging();


        $this->load->view("/users/index", $this->data);
    }

    function detail(){
        $this->data["result"]               = $this->m_users->selectUsers();
        $this->load->view("/users/detail", $this->data);
    }

    function updateProcess(){
        $this->yield                = false;
        $result                     = "fail";
        if( !empty($this->data["idx"]) && is_numeric($this->data["idx"]) ){
            $auth_number            = $this->input->post("auth_number") ?? "";
            $car_img_1_path         = $this->input->post("car_img_1_path") ?? "";
            $car_img_1_name         = $this->input->post("car_img_1_name") ?? "";
            $car_img_2_path         = $this->input->post("car_img_2_path") ?? "";
            $car_img_2_name         = $this->input->post("car_img_2_name") ?? "";
            $car_img_3_path         = $this->input->post("car_img_3_path") ?? "";
            $car_img_3_name         = $this->input->post("car_img_3_name") ?? "";
            $car_img_4_path         = $this->input->post("car_img_4_path") ?? "";
            $car_img_4_name         = $this->input->post("car_img_4_name") ?? "";
            $car_img_5_path         = $this->input->post("car_img_5_path") ?? "";
            $car_img_5_name         = $this->input->post("car_img_5_name") ?? "";

            $data                   = [
                "user_idx"          => $this->data["idx"],
                "auth_number"       => $auth_number,
                "car_img_1_path"    => $car_img_1_path,
                "car_img_1_name"    => $car_img_1_name,
                "car_img_2_path"    => $car_img_2_path,
                "car_img_2_name"    => $car_img_2_name,
                "car_img_3_path"    => $car_img_3_path,
                "car_img_3_name"    => $car_img_3_name,
                "car_img_4_path"    => $car_img_4_path,
                "car_img_4_name"    => $car_img_4_name,
                "car_img_5_path"    => $car_img_5_path,
                "car_img_5_name"    => $car_img_5_name,
            ];

            $check_data             = $this->m_users->selectUsersAttachment();

            if( !empty($check_data) ){
                $update_result      = $this->m_users->updateUsers($data);
                if( $update_result ){
                    $result         = "success";
                }else{
                    $result         = "error";
                }
            }else{
                $insert_result      = $this->m_users->insertUsers($data);
                if( $insert_result ){
                    $result         = "success";
                }else{
                    $result         = "error";
                }
            }
        }

        echo json_encode($result);

    }

    function updateInsurance(){
        $this->yield                = false;
        $result                     = "fail";
        $response_data                       = $this->input->post("response_data", true) ?? [];
        if( !empty($response_data) ){
            $user_idx               = $response_data["user_idx"];
            $data                   = [
                $response_data["type"] . "_personal_one_price"  => !empty($response_data["personal_one_price"]) ? str_replace("," , "", $response_data["personal_one_price"]) : 0,
                $response_data["type"] . "_personal_two_price"  => !empty($response_data["personal_two_price"]) ? str_replace("," , "", $response_data["personal_two_price"]) : 0,
                $response_data["type"] . "_property_price"      => !empty($response_data["property_price"]) ? str_replace("," , "", $response_data["property_price"]) : 0,
                $response_data["type"] . "_physical_car_price"  => !empty($response_data["physical_car_price"]) ? str_replace("," , "", $response_data["physical_car_price"]) : 0,
                $response_data["type"] . "_uninsured_price"     => !empty($response_data["uninsured_price"]) ? str_replace("," , "", $response_data["uninsured_price"]) : 0,
                $response_data["type"] . "_collision_price"     => !empty($response_data["collision_price"]) ? str_replace("," , "", $response_data["collision_price"]) : 0,
                $response_data["type"] . "_emergency_price"     => !empty($response_data["emergency_price"]) ? str_replace("," , "", $response_data["emergency_price"]) : 0,
                $response_data["type"] . "_total_price"         => !empty($response_data["total_price"]) ? str_replace("," , "", $response_data["total_price"]) : 0,
            ];

            $check_data             = $this->m_users->selectUsersInsurance($user_idx);
            if( !empty($check_data) ){
                $update_result      = $this->m_users->updateUsersInsurance($user_idx, $data);
                if( $update_result ){
                    $result         = "success";
                }else{
                    $result         = "error";
                }
            }else{
                $data["user_idx"]   = $user_idx;
                $insert_result      = $this->m_users->insertUsersInsurance($data);
                if( $insert_result ){
                    $result         = "success";
                }else{
                    $result         = "error";
                }
            }
        }

        echo json_encode($result);
    }
}