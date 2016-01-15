<?php
class Event extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('活动管理'),
					'functions'=>array(
							array(
								array('url'=>base_url('Event/lists'),'content'=>"活动列表"),
								array('url'=>base_url('Event/event_add'),'content'=>"添加活动"),
							)
			));
	}
/************活动模块*************/
	public function lists($page = 1){
		$this->_get_district();
		$get = $this->input->get();
		$this->data['query_str'] = isset($_SERVER['REDIRECT_QUERY_STRING'])?$_SERVER['REDIRECT_QUERY_STRING']:'';
		$must = array("page_now"=>$page);
		$must = array_merge($must,$get);
		$res = get_api_data("event/lists",$must);
// 		debug($res,'res');
		if ($res['err_num'] == 0){
			$this->data['records'] = $res['results']['records'];
		}
		$this->load->view('base/event',$this->data);
	}
	//添加活动页面
	public function event_add(){
		$this->_get_district();
		$this->load->view('base/event_add',$this->data);
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


