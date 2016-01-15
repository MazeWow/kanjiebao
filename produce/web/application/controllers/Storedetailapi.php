<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Storedetailapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $store_id = $this->input->post('store_id');
        $lng = $this->input->post('lng');
        $lat = $this->input->post('lat');
		$must = array('store_id'=>$store_id, 'Longitude'=>$lng, 'Latitude'=>$lat);
		$res = get_api_data('store/detail', $must);
		echo json_encode($res);
    }
}