<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Districtdetailapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $district_id = $this->input->post('district_id');
		$must = array('district_id'=>$district_id,);
		$res = get_api_data('district/detail', $must);
		echo json_encode($res);
    }
}