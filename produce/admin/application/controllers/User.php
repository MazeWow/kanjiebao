<?php
class User extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('用户详情'),
					'functions'=>array(
							array(
									array('url'=>base_url('user/lists'),'content'=>'用户列表'),
									array('url'=>base_url('user/login_list'),'content'=>'登录列表'),
									array('url'=>base_url('user/want_go_list'),"content"=>"用户想去哪儿"),
									array('url'=>base_url('user/tocao_list'),"content"=>"用户吐槽"),
							),
					)
			);
	}
	public function index(){
		$this->load->view('amap/index',$this->data);
	}
	/*用户列表*/
	public function lists(){
		$must  = array('page_now'=>$this->get_data['page_now']);
		if(isset($this->get_data['stime'])){
			$must['stime'] = $this->get_data['stime'];
			$must['etime'] = $this->get_data['etime'];
			$this->data['stime'] = $this->get_data['stime'];
			$this->data['etime'] = $this->get_data['etime'];
		}
		$ret = get_api_data('user/lists',$must);
		if(!$ret['err_num']){
			$this->data ['records_num'] = $ret ['results'] ['records_num'];
			$this->data['users'] = $ret['results']['records'];
			$this->data ['pager'] = $ret ['results'] ['pager'];
			$this->data ['url'] = 'user/lists';
		}
		debug($ret,'ret');
		$this->load->view('user/lists',$this->data);
	}
	
	/*
	 * @desc	want_go_list
	 * */
	public function want_go_list(){
		$must  = array('page_now'=>$this->get_data['page_now'],'page_size'=>10);
		$ret = get_api_data('user/want_go_list',$must);
		$this->data['users'] = $ret['results']['records'];
		$this->data ['pager'] = $ret ['results'] ['pager'];
		$this->data ['url'] = 'user/want_go_list';
		$this->load->view('user/want_go_list',$this->data);
	}
	
	/*
	 * @desc	tocao_list
	 * */
	public function tocao_list(){
		$must  = array('page_now'=>$this->get_data['page_now'],'page_size'=>10);
		$ret = get_api_data('user/tocao_list',$must);
		$this->data['users'] = $ret['results']['records'];
		$this->data ['pager'] = $ret ['results'] ['pager'];
		$this->data ['url'] = 'user/tocao_list';
		$this->load->view('user/tocao_list',$this->data);
	}
	
	/*
	 * @desc	用户登录列表
	 * */
	public function login_list(){
		$must  = array('page_now'=>$this->get_data['page_now'],'page_size'=>10);
		$ret = get_api_data('user/login_list',$must);
		$this->data['users'] = $ret['results']['records'];
		$this->data ['pager'] = $ret ['results'] ['pager'];
		$this->data ['url'] = 'user/login_list';
		$this->load->view('user/login_list',$this->data);
	}
	
}
/*end of file of Base.php*/


