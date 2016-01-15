<?php
class Auth extends Ad_Controller{
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
					'pannel'=>array('系统概况',),
					'functions'=>array(
							array(
								array('url'=>base_url('base/index'),'content'=>"系统负载")
							),
			));
	}

	public function login() {
		$data = array();
		$data['backurl'] = $this->input->get('backurl');
		$this->load->view('auth/login', $data);
	}
	
	public function do_login(){
		
		
		// root 是超级管理员，写死在程序里面的
// 		if($this->post_data['account'] == 'root'){
// 			if($this->post_data['pwd']  == 'jiebao2015'){
				
// 			}
			
// 		}
		
		
		$res = get_api_data('employee/login',$this->post_data);
		
		
		if($res['err_num'] == 0){
			$this->load->library('session');
			$newdata = array(
					'admin_session'  => $res['results']['session'],
			);
			$this->session->set_userdata($newdata);
			echo json_encode(return_format(array(),"登录成功",0));
		}
	}
	
	public function logout(){
		$this->load->library('session');/*加载 session 类*/
		$a = $this->session->sess_destroy(); // 清除session
		//@todo 删除数据库里面的 session
		//@todo 暂时只用了个 root 账户，是写死在程序里面的所以没必要删除数据库
		redirect(base_url());
	}
	
	
	
}
/*end of file of Base.php*/












