<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
		 $store_account = $this->input->post('store_account');
		  $pwd = $this->input->post('pwd');
		  

       $must = array('store_account'=>$store_account, 'pwd'=>$pwd);
		$res = get_api_data('store/login',$must);
		echo json_encode($res);
    }
}