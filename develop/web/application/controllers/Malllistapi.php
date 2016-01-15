<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Malllistapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        //$page_now = $this->input->post('page_now');
        //$page_size = $this->input->post('page_size');
        $district_id = $this->input->post('district_id');
        //$must = array('page_now'=>$page_now, 'page_size'=>$page_size, 'district_id'=>$district_id);
        $must = array('district_id'=>$district_id);
		$res = get_api_data('mall/lists', $must);
		echo json_encode($res);
    }
}