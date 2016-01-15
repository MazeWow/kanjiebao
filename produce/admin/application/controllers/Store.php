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
					'pannel'=>array('商圈管理','商场管理','商场楼层管理','商业街管理','商铺管理'),
					'functions'=>array(
							array(
								array('url'=>base_url('Store/district'),'content'=>"商圈列表"),
								array('url'=>base_url('Store/district_add'),'content'=>"添加商圈"),
							),
							array(
									array('url'=>base_url('Store/mall'),'content'=>"商场"),
									array('url'=>base_url('Store/mall_add'),'content'=>"添加商场"),
							),
							array(
									array('url'=>base_url('Store/mall_floor'),'content'=>"商场楼层"),
									array('url'=>base_url('Store/mall_floor_add'),'content'=>"添加商场楼层"),
							),
							array(
									array('url'=>base_url('Store/street'),'content'=>"商业街"),
							),
							array(
								array('url'=>base_url('Store/store'),'content'=>"商铺"),
								array('url'=>base_url('Store/mall_store_add'),'content'=>"商场添加商铺"),
							),
			));
	}
	
	/*
	 * @desc	城市列表 ： 现已隐藏
	 * */
	public function city(){
		$must = array('province'=>'北京','page_now'=>1);
		$res = get_api_data('city/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('store/city',$this->data);
	}
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
	//添加商圈
	public function district_add(){
		$must = array("city_id"=>"1",'page_now'=>1);
		$res = get_api_data('district/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
		}
		$this->load->view('store/district_add',$this->data);
	}
	//编辑商圈
	public function district_edit(){
		if(!empty($this->get_data['district_id'])){
			$must = array('district_id' =>$this->get_data['district_id']);
		}
		$ret = get_api_data('district/detail',$must);
		$this->data['district'] = $ret['results'];
		$this->load->view("store/district_edit",$this->data);
	}
	
	//商场列表
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
		$this->load->view('store/mall',$this->data);
	}
	
	//编辑商场
	public function mall_edit(){
		
		$this->_get_district();
		
		$mall_id = $this->get_data['mall_id'];
		
		$ret = get_api_data('mall/detail',array('mall_id'=>$mall_id));
		
		$this->data['mall'] = $ret['results'];
		
		$this->load->view('store/mall_edit',$this->data);
	}
	
	/*
	 * @desc	添加商场
	 * */
	public function mall_add(){
		$this->_get_district();
		$this->load->view('store/mall_add',$this->data);
	}
	
	//商场楼层列表
	public function mall_floor(){
		$this->_get_district();
		//获取商场楼层
		$mall_id = (isset($this->get_data['mall_id']))?($this->get_data['mall_id']):(0);
		$must = array('mall_id'=>$mall_id,'page_now'=>$this->get_data['page_now'],'page_size'=>20);
		$res = get_api_data('mall_floor/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
			$this->data['url'] = 'store/mall_floor';		//分页页码使用的　url
		}
		$this->load->view('store/mall_floor',$this->data);
	}
	
	/*
	 * @desc	添加商场楼层
	 * */
	public function mall_floor_add(){
		$this->_get_district();
		$this->load->view('store/mall_floor_add',$this->data);
	}
	
	/*
	 * @desc	编辑商场楼层
	 * */
	public  function mall_floor_edit(){
		$floor_id = isset($this->get_data['floor_id'])?$this->get_data['floor_id']:false;
		if(!$floor_id){
			//show 404 
			
		}
		//get mall_floor detail
		$res = get_api_data('mall_floor/detail',array('floor_id'=>$floor_id));
		$this->data['mall_floor'] = $res['results'];
		$this->load->view('store/mall_floor_edit',$this->data);
	}


	//商业街列表
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
		$this->load->view('store/street',$this->data);
	}
	//添加商业街
	public function ajax_add_street(){
		$post = $this->input->post();
		$res = get_api_data('street/add',$post);
		echo json_encode($res);
	}
	
	//商铺列表
	public function store(){
		$must = array('page_now'=>$this->get_data['page_now']);
		if(isset($this->get_data['search_key'])&&(!empty($this->get_data['search_key']))){
			$must['search_key'] = $this->get_data['search_key']; 
		}
		$res = get_api_data('store/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
			$this->data['url'] = 'store/store';
		}
		$this->load->view('store/store',$this->data);
	}
	
	/**
	 * @desc  编辑商铺
	 */
	public function store_edit(){
		$store_id = $this->get_data['store_id'];
		$res = get_api_data('store/detail',array('store_id'=>$store_id));
		$this->data['store'] = $res['results'];
		$this->load->view('store/mall_store_edit',$this->data);
	}
	
	/*
	 * 
	 * */
	public function mall_store_add(){
		$this->load->view('store/mall_store_add',$this->data);
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


