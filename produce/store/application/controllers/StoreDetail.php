<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StoreDetail extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
		 $store_session = $this->input->post('store_session');
		 
		  

       $must = array('store_session'=>$store_session);
		$res = get_api_data('store/storedetail',$must);
		echo json_encode($res);
    }
}