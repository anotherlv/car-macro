<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common {
    function __construct() {
        $this->CI =& get_instance();
    }

    function checkLogin(){
        if( $this->CI->session->userdata("is_login") == "" ){
            redirect("/login");
        }
    }

    function adminMenuOpen($class){
        $result     = "";
        $segment    = $this->CI->router->fetch_class();
        if( $class == $segment ){
            $result = "menu-is-opening menu-open";
        }
        return $result;
    }

    function adminMenuActive($class){
        $result     = "";
        $segment    = $this->CI->router->fetch_class();
        if( $class == $segment ){
            $result = "active";
        }
        return $result;
    }

    function adminSubMenuActive($class, $method_arr){
        $result     = "";
        $c_segment  = $this->CI->router->fetch_class();
        $m_segment  = $this->CI->router->fetch_method();
        if( $class == $c_segment && in_array($m_segment, $method_arr) ){
            $result = "active";
        }
        return $result;
    }
}