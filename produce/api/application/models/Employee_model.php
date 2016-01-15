<?php
require_once  'Base_model.php';
class Employee_model extends Base_model {
	public function __construct() {
		parent::__construct();
	}
	/*
	 * @desc	登录列表
	 *
	 * */
	public function login_list($limit_arr = array()){
		return $this->login_list_handler($this->ci_get(T_EMPLOYEE_SESSION,array(),array(),$limit_arr,array('login_time'=>'desc')));
	}
	
	public function login_list_handler($res){
		foreach ($res as &$login){
			$login['admin_account'] = 'root';
			$admin = $this->ci_get(T_EMPLOYEE,array('id'=>$login['employee_id']))[0];
			if($admin){
				$login['admin_account'] = $admin['account'];
			}
			$login['login_time'] = date("Y-m-d h:i:s",$login['login_time']);
		}
		return $res;
	}
	
}