<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tucaoapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $user_tucao = $this->input->post('user_tucao');
		$must = array('user_tucao' => $user_tucao);
		$res = get_api_data('user/tucao', $must);
		echo json_encode($res);
    }
}