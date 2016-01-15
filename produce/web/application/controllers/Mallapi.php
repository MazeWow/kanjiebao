<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mallapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $page_now = $this->input->post('page_now');
        $page_size = $this->input->post('page_size');
        $district = $this->input->post('district');
        $mall = $this->input->post('mall');
        $store = $this->input->post('store');
		$must = array('page_now'=>$page_now, 'page_size'=>$page_size);
		if($district)
		{
		    $must['district'] = $district;
		}
		if($mall)
		{
		    $must['mall'] = $mall;
		}
		if($store)
		{
		    $must['store'] = $store;
		}
		$res = get_api_data('event/lists',$must);
		echo json_encode($res);
    }
}