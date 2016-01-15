<?php
class Ad_Controller extends CI_Controller{
	
	public $top_nav = array();	//顶部导航
	
	public $data;				//传给　view 的数据
	
	public $get_data;			//传过来的  $_GET 数据
	
	public $post_data;			//传过来的　$_POST 数据
	
	public $employee_info;		//管理员工的信息
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');/*加载 session 类*/
		
		
		$this->get_data = $this->input->get();
		$this->post_data= $this->input->post();
		
		$admin_session = $this->session->userdata('admin_session');
		
		//管理员登录后才可以访问
		$login_url = uri_string();
		if($login_url != 'auth/login'&& $login_url != 'auth/do_login'){
			$res = get_api_data('employee/is_login',array('session'=>$admin_session));
			if($res['err_num'] == 0){
				$this->employee_info['employee'] = $res['results']['employee'];
			}else{
				redirect(base_url('auth/login'));
			}
		}
		
		$this->init();
		$this->data['topnav'] = $this->top_nav;
		$this->data['title'] = "街报web管理系统";//web页面默认名字
		//设置分页默认值 page_now
		if(!isset($this->get_data['page_now'])){
			$this->get_data['page_now'] = 1;
		}
		
	}
	public function init(){
		$this->top_nav[]=array('url'=>base_url('base/index'),'content'=>"基础管理");
		$this->top_nav[]=array('url'=>base_url('store/store'),'content'=>"商户管理");
		$this->top_nav[]=array('url'=>base_url('Event/lists'),'content'=>"活动管理");
		$this->top_nav[]=array('url'=>base_url('ad/mall_ad_list'),'content'=>"广告管理");
		$this->top_nav[]=array('url'=>base_url('Statistics/store'),'content'=>"数据统计");
		
		//只有 Root 管理员才有 企业管理的权限
		if($this->employee_info['employee'] == 'root'){
			$this->top_nav[]=array('url'=>base_url('user/lists'),'content'=>"用户管理");
			$this->top_nav[]=array('url'=>base_url('Company/employee_list'),'content'=>"企业管理");
		}
		
	}
}




