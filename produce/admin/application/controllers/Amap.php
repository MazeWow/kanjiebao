<?php
class Amap extends Ad_Controller{
	private $side_nav = array(); //侧边栏选项
	public function __construct(){
		parent::__construct();
		$this->init_side_nav();
		$this->data['sidenav'] = $this->side_nav;
	}
	//初始化侧边栏
	public function init_side_nav(){
			$this->side_nav= array(
					'pannel'=>array('地图demo'),
					'functions'=>array(
							array(
									array('url'=>base_url('amap/index'),'content'=>'定位'),
							),
					)
			);
	}
/*		地图首页　　　　*/
	public function index(){
		$this->load->view('amap/index',$this->data);
	}
}
/*end of file of Base.php*/


