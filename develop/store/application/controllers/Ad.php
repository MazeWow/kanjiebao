<?php
class Ad extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('商场广告'),
					'functions'=>array(
							array(
								array('url'=>base_url('ad/mall_ad_list'),'content'=>"广告列表"),
								array('url'=>base_url('ad/mall_ad_add'),'content'=>"添加广告"),
							),
			));
	}
	/*********广告模块*********/
	public function mall_ad_list(){
		$must = array('mall_id'=>0);
		$res = get_api_data('ad/mall_ad_lists',$must);
		$this->data['ad'] = $res['results']['records'];
		$this->load->view('base/mall_ad_list',$this->data);
	}
	public function mall_ad_add(){
		$this->_get_district();
		$this->load->view('base/mall_ad_add',$this->data);
	}
/*****私有函数，不是接口，对外不可访问******/
/*
 *@desc		得到商圈列表
 * */
public function _get_district($city_id = 1){
	$must = array("city_id"=>$city_id,'page_now'=>1);
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
/*end of file of Base.php*/


