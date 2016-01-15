<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Districtlistapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $city_id = $this->input->post('city_id');
        $page_now = $this->input->post('page_now');
        $page_size = $this->input->post('page_size');
        $lng = $this->input->post('lng');
        $lat = $this->input->post('lat');
		$must = array('city_id'=>$city_id, 'page_now'=>$page_now, 'page_size'=>$page_size, 'Longitude'=>$lng, 'Latitude'=>$lat);
		$res = get_api_data('district/lists', $must);
		echo json_encode($res);
    }
}