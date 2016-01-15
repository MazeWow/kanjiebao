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
							),
					)
			);
	}
	public function index(){
		$this->load->view('amap/index',$this->data);
	}
	/*用户列表*/
	public function lists(){
		
		$this->load->view('user/lists',$this->data);
	}
}
/*end of file of Base.php*/


