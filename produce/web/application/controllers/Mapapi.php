<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mapapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $floor_id = $this->input->post('floor_id');
		$must = array('floor_id'=>$floor_id);
		$res = get_api_data('mall_floor/detail', $must);
		echo json_encode($res);
    }
}