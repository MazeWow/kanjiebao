<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Productapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $product_id = $this->input->post('product_id');
        $must = array('product_id' => $product_id);
		$res = get_api_data('product/detail', $must);
		echo json_encode($res);
    }
}