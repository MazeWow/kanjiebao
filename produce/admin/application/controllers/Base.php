<?php
class Base extends Ad_Controller{
	private $side_nav = array();
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	/*
	 *@desc		初始化侧边栏
	 * */
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('系统概况','品牌管理',/*"商品管理"*/),
					'functions'=>array(
							array(
								array('url'=>base_url('base/index'),'content'=>"系统负载")
							),
							array(
								array('url'=>base_url('base/brand'),'content'=>'品牌列表'),
								array('url'=>base_url('base/brand_add'),'content'=>'添加品牌'),
// 								array('url'=>base_url('base/brand_edit'),'content'=>"编辑品牌"),
							),
// 							array(
// 								array('url'=>base_url('base/brand_product'),'content'=>"品牌商品库"),
// 							),
			));
	}
	
	/*
	 * @desc	首页，暂时是探针页面
	 * */
	public function index(){
		$this->load->view('base/index',$this->data);
	}
	/*
	 *@desc     品牌列表页面
	 *@desc		功能： 按关键字查询，编辑，删除
	 * */
	public function brand(){
		$must = array('page_now'=>$this->get_data['page_now']);
		if(isset($this->get_data['search_key'])){
			$must['search_key'] = $this->get_data['search_key'];
		}
		$res = get_api_data('brand/lists',$must);
		if($res['err_num']==0){
			$results = $res['results'];
			$this->data['records'] = $results['records'];
			$this->data['pager'] = $results['pager'];
			$this->data['url'] = 'base/brand';
		}
		$this->load->view('base/brand',$this->data);
	}
	/*
	 *@desc		添加一个品牌页面
	 * */
	public function brand_add(){
		$this->load->view('base/brand_add',$this->data);
	}
	/*
	 *@desc		添加一个品牌页面(处理　ajax 提交表单)
	 * */
	public function ajax_add_brand(){
		$post = $this->input->post();
		$res = get_api_data('brand/add',$post);
		echo json_encode($res);
	}
	/*
	 *@desc		编辑品牌
	 * */
	public function brand_edit(){
		$res = get_api_data('brand/detail',array('brand_id'=>$this->get_data['brand_id']));
		if($res['err_num'] == 0){
			$this->data['brand'] = $res['results'];
		}
		$this->load->view("base/brand_edit",$this->data);
	}
	/*
	 *@desc		添加一个商铺
	 *@todo     后期要移除，现在有些功能还是　ajax 调用此函数的
	 * */
	function ajax_add_mall(){
		$res = get_api_data('mall/add',$this->post_data);
		echo json_encode($res);
	}
	/*
	 *@desc		添加一个商场楼层
	 *@todo     后期要移除，现在有些功能还是　ajax 调用此函数的
	 * */
	public function ajax_add_mall_floor(){
		$res = get_api_data('mall_floor/add',$this->post_data);
		echo json_encode($res);
	}
	/*
	 *@desc		添加商业街
	 *@todo     后期要移除，现在有些功能还是　ajax 调用此函数的
	 * */
	public function ajax_add_street(){
		$post = $this->input->post();
		$res = get_api_data('street/add',$post);
		echo json_encode($res);
	}
	//私有函数，不是接口，对外不可访问
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


