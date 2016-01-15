<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Storelistapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $mall_floor_id = $this->input->post('mall_floor_id');
        //$street_id = $this->input->post('street_id');
        //$page_now = $this->input->post('page_now');
        //$page_size = $this->input->post('page_size');
		//$must = array('mall_floor_id'=>$mall_floor_id, 'page_now'=>$page_now, 'page_size'=>$page_size);
		$must = array('mall_floor_id'=>$mall_floor_id);
		$res = get_api_data('store/lists', $must);
		echo json_encode($res);
    }
}