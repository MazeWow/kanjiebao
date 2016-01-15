<?php
class JB_Controller extends CI_Controller{
	
	//api 最终要输出的数据
	public $data = array();
	
	//传过来的所有 post 参数
	public $params = array();
	
	//mem 实例
	public $mem;
	
	//用户信息，登录后才有值
	public $user;
	
	//商户信息
	public $store_info;
	
	//管理员信息
	public $admin_info;
	
	//返回记录的分页默认值
	protected $page_size = 20;
	
	protected $page_now = 1;
		
	// 街报网安全控制：必传参数验证　＋　参数对称加密验证　＋　api 白名单
	public function __construct(){
		parent::__construct();
		$this->mem = Mem::get_mem_ins();
		$this->mem->addserver('127.0.0.1',11211);
		$this->params = $this->input->post(NULL, TRUE);
		
		//分页设置
		if(isset($this->params['page_now'])){
			$this->page_now = $this->params['page_now'];
		}
		
		if(isset($this->params['page_size'])){
			$this->page_size = $this->params['page_size'];
		}
		
		//加载全局模块
		$this->load->model('Base_model');
		$this->load->model('Table_model');
		
		$this->st(array(),'系统未知错误!!!',API_UNKNOW_ERR);
		$this->check_api_map();
	}
	
	//检查 api 是否可以访问，是否在白名单内
	public function check_api_map(){
		global  $api_map;
		if(!in_array($_SERVER['REQUEST_URI'],$api_map)){
			$this->st(array(),"该 api 没有访问的权限！",API_MAP_ERR);
			$this->op();
		}
	}
	
	//验证下是否有必须传的参数没传
	public function check_param($must){
		foreach ($must as $v) {
			if(!array_key_exists($v,$this->params)){
				$this->st(array(),'you lack a param :'.$v,API_PARAM_ERR);
				$this->op();
			}
		}
	}
	
	//签名校验
	public function check_sign(){
		if(isset($this->params['sign'])){
			$sign = $this->params['sign'];
			unset($this->params['sign']);
		}
		$sign2 = encrypt($this->params);
		if (!$sign == $sign2){
			$this->st(array(),'your sign is wrong',API_SIGN_ERR);
			$this->op();
		}
	}
	
	//用户校验
	public function check_session(){
		if(!empty($this->params['session'])){
			$this->Table_model->init(T_USER_SESSION);
			$res = $this->Table_model->records(array('session'=>$this->params['session']));
			if($res['err_num'] == 0){
				$uid = $res['results']['records'][0]['uid'];
				$this->Table_model->init(T_USER);
				$res = $this->Table_model->records(array('id'=>$uid));
				if($res['err_num'] == 0){
					$user = $res['results']['records'][0];
					$this->user = $user;
				}
				else{
					$this->st($res,"未登录用户，数据库错误",API_DB_ERR);
					$this->op();
				}
			}
			else{
				$this->st(array(),"未登录用户！",API_SESSION_ERR);
				$this->op();
			}
		}else{
			$this->st(array(),"未登录用户！",API_SESSION_ERR);
			$this->op();
		}
	}
	
	/*
	 *@desc		商户端登录校验
	 *@date
	 * */
	public function check_store_session(){
		do{
			if(!empty($this->params['store_session'])){
				$this->Table_model->init(T_STORE_SESSION);
				$res = $this->Table_model->record_one(array('session'=>$this->params['store_session']));
				$this->store_info = $res;
				$this->Table_model->init(T_STORE_ACCOUNT);
				$res2 = $this->Table_model->record_one(array('id'=>$this->store_info['store_account_id']));
				$this->store_info = array_merge($this->store_info,$res2);
				break;
			}
			$this->op(return_format(array(),"未登录商户",API_NORMAL_ERR));
		}while(0);
	}
	
	/*
	 *@desc		管理员校验
	 *@date
	 * */
	public function check_employee_session(){
		do{
			if(!empty($this->params['store_session'])){
				$this->Table_model->init(T_STORE_SESSION);
				$res = $this->Table_model->record_one(array('session'=>$this->params['store_session']));
				$this->store_info = $res;
				$this->Table_model->init(T_STORE_ACCOUNT);
				$res2 = $this->Table_model->record_one(array('id'=>$this->store_info['store_account_id']));
				$this->store_info = array_merge($this->store_info,$res2);
				break;
			}
			$this->op(return_format(array(),"未登录商户",API_NORMAL_ERR));
		}while(0);
	}

	//设置返回的结果，错误编码，错误信息
	public function st($res = array(),$err_msg = '获取数据成功!',$err_num = 0){
		$this->data = return_format($res,$err_msg,$err_num);
	}
	
	//输出　api 返回的数据
	public function op($return_data = array()){
// 		header(API_ACCESS_CONTROL);
		header('content-type:application/json;charset=utf8');
		if($return_data != array()){
			echo json_encode($return_data);exit();
		}
		echo json_encode($this->data);exit();
	}
}
/* End of file JB_Controller.php */
/* Location: ./api/application/core/JB_Controller */