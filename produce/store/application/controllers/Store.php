<?php
class Store extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('商铺层级','商铺管理'),
					'functions'=>array(
							array(
								array('url'=>base_url('Store/city'),'content'=>"城市"),
								array('url'=>base_url('Store/district'),'content'=>"商圈"),
								array('url'=>base_url('Store/mall'),'content'=>"商场"),
								array('url'=>base_url('Store/mall_floor'),'content'=>"商场楼层"),
								array('url'=>base_url('Store/street'),'content'=>"商业街"),
							),
							array(
								array('url'=>base_url('Store/store'),'content'=>"商铺"),
							),
			));
	}
/**************城市模块*************/
	//城市列表
	public function city($page = 1){
		$must = array('province'=>'北京','page_now'=>1);
		$res = get_api_data('city/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('store/city',$this->data);
	}
/****************商圈模块***************/
	//商圈列表
	public function district(){
		$must = array("city_id"=>"1",'page_now'=>1);
		$res = get_api_data('district/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('store/district',$this->data);
	}
/**************商场模块***************/
	public function mall(){
		$this->_get_district();
		if(isset($this->get_data['district_id'])&&(!empty($this->get_data['district_id']))){
			$district_id = $this->get_data['district_id'];
		}else{
			$district_id = '0';
		}
		//取到商场
		$must = array('district_id'=>$district_id,'page_now'=>1);
		$res = get_api_data('mall/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('base/mall',$this->data);
	}
	/*
	 *@desc		添加一个商铺
	 * */
	function ajax_add_mall(){
		$res = get_api_data('mall/add',$this->post_data);
		echo json_encode($res);
	}
/**************商场楼层模块****************/
	public function mall_floor(){
		$this->_get_district();
		//获取商场楼层
		$mall_id = (isset($this->get_data['mall_id']))?($this->get_data['mall_id']):(0);
		$must = array('mall_id'=>$mall_id,'page_now'=>1);
		$res = get_api_data('mall_floor/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('base/mall_floor',$this->data);
	}
	public function ajax_add_mall_floor(){
		$res = get_api_data('mall_floor/add',$this->post_data);
		echo json_encode($res);
	}
/***********商业街模块******************/
	public function street(){
		//取到商圈
		$must = array("city_id"=>"1",'page_now'=>1);
		$district_res = get_api_data('district/lists',$must);
		if($district_res['err_num']==0){
			$results = $district_res['results'];
			$this->data['district'] = $results['records'];
		}
		//取到商业街
		$district_id = (isset($this->get_data['district_id']))?($this->get_data['district_id']):'0';
		$must = array('district_id'=>$district_id,'page_now'=>1);
		$res = get_api_data('street/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('base/street',$this->data);
	}
	//添加商业街
	public function ajax_add_street(){
		$post = $this->input->post();
		$res = get_api_data('street/add',$post);
		echo json_encode($res);
	}
/*************商铺模块****************/
	public function store($page = 1){
		$must = array('mall_id'=>'2','page_now'=>1);//可选参数　: 'page_size'=>1000
		$res = get_api_data('store/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('base/store',$this->data);
	}
	public function store_del(){
		extract($this->input->post());
		$must = array('store_id'=>$id);
		$res = get_api_data("store/del", $must);
		echo json_encode($res);
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


