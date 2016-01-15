<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Changepassapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $session_val = $_COOKIE['session'];
        $new_pwd = $this->input->post('new_pwd');
        $new_pwd_re = $this->input->post('new_pwd_re');
        $must = array("session"=>$session_val, 'new_pwd'=>$new_pwd, "new_pwd_re"=>$new_pwd_re);
		$res = get_api_data('user/modify_pwd',$must);
		echo json_encode($res);
    }
}