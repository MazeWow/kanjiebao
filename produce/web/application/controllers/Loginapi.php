<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loginapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $phone = $this->input->post('phone');
        $pwd = $this->input->post('pwd');
		$must = array('phone'=>$phone, 'pwd'=>$pwd);
		$res = get_api_data('user/login', $must);
		if (0 == $res['err_num'])
		{
		    setcookie('session', $res['results']['session'], time()+86400);
		}
		echo json_encode($res);
    }
}