<?php
class Ad_Controller extends CI_Controller{
	
	public $top_nav = array();	//顶部导航
	
	public $data;				//传给　view 的数据
	
	public $get_data;			//传过来的  $_GET 数据
	
	public $post_data;			//传过来的　$_POST 数据
	
	public function __construct(){
		parent::__construct();
		$this->init();
		$this->data['title'] = "街报web管理系统";//web页面默认名字
		$this->data['topnav'] = $this->top_nav;
		$this->get_data = $this->input->get();
		$this->post_data= $this->input->post();
	}
	public function init(){
		
	
		
		//$this->top_nav[]=array('url'=>base_url('event/index'),'content'=>"活动");
		//$this->top_nav[]=array('url'=>base_url('user/index'),'content'=>"用户");
		//$this->top_nav[]=array('url'=>base_url('system/index'),'content'=>"系统");
	}
}