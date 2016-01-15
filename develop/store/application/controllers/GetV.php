<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GetV extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
       $must = array('store_id'=>1);
		$res = get_api_data('store/add_verify_code',$must);op($res);
		echo json_encode($res);
    }
}