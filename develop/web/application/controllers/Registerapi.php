<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registerapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $phone = $this->input->post('phone');
        $pwd = $this->input->post('pwd');
        $re_pwd = $this->input->post('re_pwd');
        $verify_code = $this->input->post('verify_code');
		$must = array("phone"=>$phone, "pwd"=>$pwd, "re_pwd"=>$re_pwd, 'verify_code'=>$verify_code);
		$res = get_api_data('user/register', $must);
		if (0 == $res['err_num'])
		{
		    setcookie('session', $res['results']['session'], time()+86400);
		}
		echo json_encode($res);
    }
}