<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee extends JB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Employee_model');
	}
	/*
	 *@desc		员工登录
	 * */
	public function login(){
		$must = array('account','pwd');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			//处理超级用户的登录
			if($account == 'root'){
				if($pwd == "jiebao2015"){
					//登录成功, root 用户默认 id 为 0
					$session = $this->_set_employee_login_seesion(0);
					$this->st(array('session'=>$session),'登录成功');
					break;
				}else{
					$this->st(array(),'root用户登录失败：密码错误!');
					break;
				}
			}else{
				$res = $this->Base_model->ci_get(T_EMPLOYEE,array('account'=>$account));
				if($res){
					$db_pwd = $res[0]['pwd'];
					$admin_id = $res[0]['id'];
					if(pass_encrypt($pwd) == $db_pwd){
						$session = $this->_set_employee_login_seesion($admin_id);
						$this->st(array('session'=>$session),'登录成功');
						break;
					}
					$this->st(array(),"管理员密码错误!",API_NORMAL_ERR);
					break;
				}
				$this->st(array(),"管理员账号错误!",API_NORMAL_ERR);
			}
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	判断管理员是否登录的的接口
	 * */
	public function is_login(){
		$must = array('session');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$res = $this->Base_model->ci_get(T_EMPLOYEE_SESSION,array('session'=>$session));
			if($res){
				$employ_id = $res[0]['employee_id'];
				// root 用户返回
				if($employ_id === '0'){
					$this->st(array('employee'=>'root'),"root 登录成功!");
					break;
				}
				//普通用户返回
				$this->st(array('employee'=>'admin'),"管理员登录成功！");
				break;
			}
			$this->st(array(),"管理员未登录",API_NORMAL_ERR);
			
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	list
	 * */
	public function lists(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select * from ".T_EMPLOYEE;
			$res = $this->Base_model->ci_query($sql);
			$this->st($res);
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	 添加一个管理员
	 * */
	public function add(){
		$must = array('admin_name','admin_pwd');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$res = $this->Base_model->ci_insert(T_EMPLOYEE,array('account'=>$admin_name,'pwd'=>pass_encrypt($admin_pwd)));
			$this->st($res);
		}while(0);
		$this->op();
	}

	/*
	 * @desc 设置store_login session 的内部函数
	 */
	public function _set_employee_login_seesion($employee_id) {
		session_regenerate_id (); // 重置　session 　字符
		$session_info = array (
				'employee_id' => $employee_id,
				'session' => session_encrypt ( session_id () ),
				'login_time'=>time()
		);
		$this->Table_model->init ( T_EMPLOYEE_SESSION );
		// 删除以前 登录　session ,重新存储
// 		$this->Table_model->records_delete ( array (
// 				"employee_id" => $employee_id
// 		) );
		$res = $this->Table_model->records_add ( $session_info );
		if ($res) {
			return $session_info ['session'];
		}
		return false;
	}
	
	
	/*
	 * @desc	管理员登录记录列表
	 * */
	public function employee_login_list(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$records = $this->Employee_model->login_list(array($this->page_size,$this->page_now));
			$pager   = $this->Employee_model->get_records_nums(T_EMPLOYEE_SESSION,array(),$this->page_now,$this->page_size);
			$this->st(array('records'=>$records,'pager'=>$pager));
		}while(0);
		$this->op();
	}
	/*
	 * @desc	删除员工
	 * */
	public function del(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$res = $this->Base_model->ci_delete(T_EMPLOYEE,array('id'=>$this->params['employee_id']));
			$this->st($res,'删除员工');
		}while(0);
		$this->op();
	}
	/*
	 * 员工详情
	 * */
	public function detail(){
		$must = array('employee_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$res = $this->Base_model->ci_get(T_EMPLOYEE,array('id'=>$employee_id))[0];
			$this->st($res);
		}while(0);
		$this->op();
	}
	/*
	 * 员工详情
	 * */
	public function edit(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$res = $this->Base_model->ci_update(T_EMPLOYEE,array('id'=>$id),array('account'=>$employee_name,'pwd'=>pass_encrypt($employee_pwd)));
			$this->st($res);
		}while(0);
		$this->op();
	}
	
}


























