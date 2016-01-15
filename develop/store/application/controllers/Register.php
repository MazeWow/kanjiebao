<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
		 $verify_code = $this->input->post('verify_code');
		  $account = $this->input->post('account');
		   $pwd = $this->input->post('pwd');
		    $re_pwd = $this->input->post('re_pwd');

       $must = array('verify_code'=>$verify_code,
				'account'=>$account,
				'pwd'=>$pwd,
				're_pwd'=>$re_pwd);
		$res = get_api_data('store/register',$must);
		echo json_encode($res);
    }
}