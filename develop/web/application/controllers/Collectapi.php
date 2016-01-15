<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Collectapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $session_val = $_COOKIE['session'];
        $event_id = $this->input->post('event_id');
        $must = array('session'=>$session_val, 'event_id'=>$event_id);
		$res = get_api_data('user/like_event', $must);
		echo json_encode($res);
    }
}