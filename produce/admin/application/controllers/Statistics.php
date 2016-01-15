<?php
class Statistics extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('商铺统计'),
					'functions'=>array(
							array(
								array('url'=>base_url('statistics/store'),'content'=>"商铺统计"),
								array('url'=>base_url('statistics/user'),'content'=>"用户统计"),
							),
			));
	}
	/*
	 * @desc	商铺统计列表
	 * */
	public function store(){
		$must = array();
		$res = get_api_data('Statistics/all_district',$must)['results'];
		$res = array_merge($res,get_api_data('Statistics/all_mall',$must)['results']);
		$res = array_merge($res,get_api_data('Statistics/all_store',$must)['results']);
		$this->data['statistics_data'] = array_merge($res,get_api_data('Statistics/all_event',$must)['results']);
		$this->load->view('statistics/lists',$this->data);
	}
	
	/*
	 * @desc	用户统计列表
	 * */
	public function user(){
		$must = array();
		$this->data['user_num'] = get_api_data('user/users_num',$must)['results']['users_num'];
		$this->load->view('statistics/user',$this->data);
	}
}
/*end of file of Base.php*/








