<?php
class Company extends Ad_Controller{
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
					'pannel'=>array('系统管理员'),
					'functions'=>array(
							array(
								array('url'=>base_url('company/employee_list'),'content'=>"管理员列表"),
								array('url'=>base_url('company/employee_add'),'content'=>"添加管理员"),
								array('url'=>base_url('company/employee_login_list'),'content'=>"管理员登录记录"),
							),
			));
	}
	
	/*
	 * 管理员列表
	 * 
	 * */
	public function employee_list(){
		$this->data['admin'] = get_api_data('employee/lists',array())['results'];
		$this->load->view('company/employee_list',$this->data);
	}
	
	/*
	 * 添加管理员
	 * 
	 * */
	public function employee_add(){
		$this->load->view('company/employee_add',$this->data);
	}
	
	/*
	 * 添加管理员
	 *
	 * */
	public function employee_edit(){
		
		$employee_id = $this->get_data['employee_id'];
		$res = get_api_data('employee/detail',array('employee_id'=>$employee_id));
		$this->data['employee'] = $res['results'];
		$this->load->view('company/employee_edit',$this->data);
	}
	
	/*
	 * 管理员登录记录列表
	 *
	 * */
	public function employee_login_list(){
		$must = array();
		if($this->get_data['page_now']) $must['page_now'] = $this->get_data['page_now'];
		$res = get_api_data('employee/employee_login_list',$must);
		$this->data['login_list']=$res['results']['records'];
		$this->data['pager']=$res['results']['pager'];
		$this->data['url'] = 'company/employee_login_list';
		$this->load->view('company/employee_login_list',$this->data);
	}
	
	
	
	
	
	
		
}
/*end of file of Base.php*/


