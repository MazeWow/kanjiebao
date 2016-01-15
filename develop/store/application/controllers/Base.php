<?php
class Base extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('活动管理',"商品管理","数据统计","商铺设置"),
					'functions'=>array(
								
							array(
								array('url'=>base_url('base/activity'),'content'=>'编辑、发布活动'),
								array('url'=>base_url('base/published'),'content'=>'已发布活动'),
							),
							array(
								array('url'=>base_url('base/goods'),'content'=>"商品库"),
								array('url'=>base_url('base/add_goods'),'content'=>"添加商品"),
							),
								array(
								array('url'=>base_url('base/statistics'),'content'=>"活动数据"),
							),
								array(
								array('url'=>base_url('base/storeDetail'),'content'=>"商铺基本信息"),
							),
			));
	}
	//首页，暂时是探针页面
	public function index(){
		$this->load->view('base/activity',$this->data);
	}
	public function activity()
	{
			$this->load->view('base/activity',$this->data);
	}
	public function  published()

	{
			$this->load->view('base/published',$this->data);
	}
	public function statistics()
	{
		$this->load->view('base/statistics',$this->data);

	}
	public function shop_info()
	{
		$this->load->view('base/shop_info',$this->data);

	}
	public function goods()
	{
		$this->load->view('base/goods',$this->data);

	}
	public function add_goods()
	{
		$this->load->view('base/add_goods',$this->data);

	}
	public function login()
	{
		$this->load->view('base/login',$this->data);

	}
	public function regist()
	{
		$this->load->view('base/regist',$this->data);

	}
	public function storeDetail()
	{
		$this->load->view('base/storeDetail',$this->data);

	}
/******************品牌模块**********/
	public function brand(){
		$must = (isset($this->get_data['page_now']))?(array('page_now'=>$this->get_data['page_now'])):(array('page_now'=>1));;
		$res = get_api_data('brand/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('base/brand',$this->data);
	}
	
	public function brand_add(){
		$this->load->view('base/brand_add',$this->data);
	}

	public function ajax_add_brand(){
		$post = $this->input->post();
		$res = get_api_data('brand/add',$post);
		echo json_encode($res);
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
		$this->load->view('base/city',$this->data);
	}
	//删除城市
	public function city_delete(){
		extract($this->input->post());
		$must = array('city_id'=>$city_id);
		$res = get_api_data("city/del", $must);
		echo json_encode($res);
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
		$this->load->view('base/district',$this->data);
	}
	
	public function district_del(){
		extract($this->input->post());
		$must = array('id'=>$id);
		$res = get_api_data("district/del", $must);
		echo json_encode($res);
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
/************活动模块*************/
	public function event($page = 1){
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

