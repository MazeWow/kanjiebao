<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Malladlistapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $mall_id = $this->input->post('mall_id');
        $must = array('mall_id' => $mall_id);
		$res = get_api_data('ad/mall_ad_lists', $must);
		echo json_encode($res);
    }
}