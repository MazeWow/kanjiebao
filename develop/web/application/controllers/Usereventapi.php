<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usereventapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $session_info = $_COOKIE['session'];
        //$page_now = $this->input->post('page_now');
        //$page_size = $this->input->post('page_size');
		$must = array('session'=>$session_info);
		$res = get_api_data('user/event_lists', $must);
		echo json_encode($res);
    }
}