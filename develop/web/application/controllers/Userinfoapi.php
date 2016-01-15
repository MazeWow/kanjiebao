<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Userinfoapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
		$must = array("session" => $_COOKIE['session']);
		$res = get_api_data('user/detail', $must);
		echo json_encode($res);
    }
}