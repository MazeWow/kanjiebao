<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
		$page_now = $this->input->get('page_now');
        $page_size = $this->input->get('page_size');
		$must = array('page_now'=>$page_now, 'page_size'=>$page_size);
		$res = get_api_data('event/lists',$must);
		print_r($res);
		echo '<br/>';
		$must['city_id'] = 1;
		$res = get_api_data('district/lists',$must);
		print_r($res);
		echo '<br/>';
		$must = array();
		$must['id'] = 1;
		$res = get_api_data('district/detail', $must);
		print_r($res);
		echo '<br/>';
		$res = get_api_data('mall/detail', $must);
		print_r($res);
		echo '<br/>';
		$must['id'] = 2;
		$res = get_api_data('store/detail', $must);
		print_r($res);
    }
}