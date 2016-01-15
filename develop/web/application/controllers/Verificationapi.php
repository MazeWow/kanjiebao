<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Verificationapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $phone = $this->input->post('phone');
		$must = array('phone' => $phone);
		$res = get_api_data('user/msg_verify', $must);
		echo json_encode($res);
    }
}