<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Resetpassapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $phone = $this->input->post('phone');
        $new_pwd = $this->input->post('new_pwd');
        $re_new_pwd = $this->input->post('re_new_pwd');
        $verify_code = $this->input->post('verify_code');
		$must = array('phone'=>$phone, 'new_pwd'=>$new_pwd, 're_new_pwd'=>$re_new_pwd, 'verify_code'=>$verify_code);
		$res = get_api_data('user/find_pwd', $must);
		echo json_encode($res);
    }
}