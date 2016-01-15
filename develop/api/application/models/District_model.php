<?php
require_once  'Base_model.php';
class District_model extends Base_model {
	public function __construct() {
		parent::__construct();
	}
	/*
	 * @desc	处理返回的数据，重命名，或者解析 json 字符串
	 * */
	public function _district_handler($district_array = array()){		
		foreach ($district_array as &$district){
			
			$district['district_name'] = $district['name'];
			unset($district['name']);
			
			$district['district_id'] = $district['id'];
			unset($district['id']);
			
			$district['district_photo'] = json_decode($district['photo']);
			unset($district['photo']);
			
		}
		return $district_array;
	}
	/*
	 * @desc	拿到所有的商圈
	 * */
	public function get_all_districts(){
		return $this->_district_handler($this->ci_get(T_DISTRICT));
	}
	/*
	 * @desc	拿到特定条件的商圈
	 * */
	public function get_district_where($where_map = array()){
		return $this->_district_handler($this->ci_get(T_DISTRICT,$where_map));
	}
	
	
	
}