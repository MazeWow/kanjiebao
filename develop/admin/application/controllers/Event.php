<?php
class Event extends Ad_Controller {
	private $side_nav = array (); // 侧边栏选项
	public function __construct() {
		parent::__construct ();
		$this->init_side_nav ();
		$this->data ['sidenav'] = $this->side_nav;
	}
	// 初始化侧边栏
	public function init_side_nav() {
		$this->side_nav = array (
				'pannel' => array (
						'活动管理' 
				),
				'functions' => array (
						array (
								array (
										'url' => base_url ( 'Event/lists' ),
										'content' => "活动列表" 
								),
								array (
										'url' => base_url ( 'Event/add' ),
										'content' => "添加活动" 
								),
						) 
				) 
		);
	}
	/*
	 * @desc	
	 * */
	public function lists() {
		$this->_get_district ();
		$must = array (
				'expired' => true,
				'is_publised' => true,
// 				'is_del' => true,			将已经删除的隐藏掉
				'page_size' => 15,
				'page_now' => $this->get_data ['page_now'] 
		);
		
		//查询条件
		if(isset($this->get_data['store_id'])){
			$must['store_id'] = $this->get_data['store_id'];
			$must['page_size'] = 100;
		}
		if(isset($this->get_data['mall_id'])){
			$must['mall_floor_id'] = $this->get_data['mall_id'];
		}
		if(isset($this->get_data['brand_id'])){
			$must['brand_id'] = $this->get_data['brand_id'];
		}
		if(isset($this->get_data['district_id'])){
			$must['district_id'] = $this->get_data['district_id'];
		}
		if(isset($this->get_data['mall_floor_id'])){
			$must['mall_floor_id'] = $this->get_data['mall_floor_id'];
		}
		$res = get_api_data ( "event/lists", $must );
		if ($res ['err_num'] == 0) {
			$this->data ['records'] = $res ['results'] ['records'];
			$this->data ['pager'] = $res ['results'] ['pager'];
			$this->data ['url'] = 'event/lists';
		}
		$this->load->view ( 'event/event', $this->data );
	}
	/*
	 * @desc 添加活动页面
	 * @date
	 */
	public function add() {
		$this->_get_district ();
		$this->load->view ( 'event/event_add', $this->data );
	}
	
	/*
	 * ＠desc 编辑活动页面
	 * @date
	 */
	public function edit() {
		$this->_get_district ();
		$must = array('event_id'=>$this->get_data['event_id']);
		$res = get_api_data('event/detail',$must);
		$this->data['event'] = $res['results']; 
		$this->load->view ( 'event/event_edit', $this->data );
	}
	
	public function event_product_edit(){
		$product_id = $this->get_data['product_id'];
		$ret = get_api_data('product/detail',array('product_id'=>$product_id));
		$this->data['product'] = $ret['results'];
		$this->load->view ( 'event_box/event_product_edit', $this->data );
	}
	
	/*
	 * 测试页面
	 * */
	public function component_test() {
		$this->load->view('common/box_header');
		$this->load->view('common/district_mall_floor_store_select',$this->data);
		$this->load->view('common/box_footer');
	}
	
	/**
	 * ***私有函数，不是接口，对外不可访问*****
	 */
	/*
	 * @desc 得到商圈列表
	 */
	public function _get_district($city_id = 1) {
		$must = array (
				"city_id" => $city_id,
				'page_now' => 1 
		);
		$district_res = get_api_data ( 'district/lists', $must );
		if ($district_res ['err_num'] == 0) {
			$results = $district_res ['results'];
			$this->data ['district'] = $results ['records'];
		}
	}
	/*
	 * @desc 得到品牌列表
	 */
	public function _get_brand() {
		$must = array (
				'page_now' => 1 
		);
		$res = get_api_data ( 'brand/lists', $must );
		if ($res ['err_num'] == 0) {
			$results = $res ['results'];
			$this->data ['brand'] = $results ['records'];
			$this->data ['brand_pager'] = $results ['pager'];
		}
	}
}
/*end of file of Base.php*/


