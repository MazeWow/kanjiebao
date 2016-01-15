<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_demo extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	//也可以直接使用 
	public function index(){
		$must = array('province'=>'北京','page_now'=>1);//可选参数　: 'page_size'=>1000
		$res = get_api_data('city/lists',$must);
		$data['city_results'] = $res['results'];
		$this->load->view("index_demo",$data);
	}
	
	// 作为　ajax 异步使用接口
	public function ajax_city(){
		$must = array('province'=>'北京','page_now'=>1);//可选参数　: 'page_size'=>1000
		$res = get_api_data('city/lists',$must);
		echo json_encode($res);
	}
	
	
}