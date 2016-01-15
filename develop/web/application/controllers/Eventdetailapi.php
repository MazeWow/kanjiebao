<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Eventdetailapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $event_id = $this->input->post('event_id');
        $must = array('event_id'=>$event_id);
		$res = get_api_data('event/detail', $must);		
		echo json_encode($res);
    }
}