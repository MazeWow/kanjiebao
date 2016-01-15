<?php
class Base_box extends Ad_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function add_store_from_mall(){
		$this->_get_district();
		$this->_get_brand();
		$this->load->view("base_box/add_store_from_mall",$this->data);
	}
	public function add_store_from_street(){
		$this->_get_district();
		$this->_get_brand();
		$this->load->view("base_box/add_store_from_street",$this->data);
	}
	/*
	 *@desc		给特定活动添加商品
	 * */
	public function event_product_add(){
		$must = array('event_id'=>$this->get_data['event_id']);
		$res = get_api_data('event/detail',$must);
		$this->data['event'] = $res['results'];
		$this->load->view('base_box/event_product_add',$this->data);
	}
	/*
	 *@desc  活动详情页面
	 * */
	public function event_detail(){
		$must = array('event_id'=>$this->get_data['event_id']);
		$res = get_api_data('event/detail',$must);
		$this->data['event'] = $res['results'];
		$this->load->view('base_box/event_detail',$this->data);
	}
	
/*****私有函数，不是接口，对外不可访问******/
	/*
	 *@desc		得到商圈列表
	 * */
	public function _get_district(){
		$must = array("city_id"=>"1",'page_now'=>1);
		$district_res = get_api_data('district/lists',$must);
		if($district_res['err_num']==0){
			$results = $district_res['results'];
			$this->data['district'] = $results['records'];
		}
	}
	/*
	 *@desc		得到品牌列表
	 * */
	public function _get_brand(){
		$must = array('page_now'=>1);
		$res = get_api_data('brand/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['brand'] = $results['records'];
			$this->data['brand_pager'] = $results['pager'];
		}
	}
}









