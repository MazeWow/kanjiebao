<?php
include_once 'Mall_model.php';
class Mall_floor_model extends Mall_model {
	public function __construct(){
		parent::__construct();
	}
	/*
	 *@desc		获取 mall_floor detail
	 * */
	public function detail($floor_id){
		if($res = $this->ci_get(T_MALL_FLOOR,array('id'=>$floor_id))[0]){
		}
		return false;
	}
	
	/*
	 * @desc	处理返回的数据，重命名，或者解析 json 字符串
	 * */
	private function _mall_floor_handler($mall_floor_array){
		foreach ($mall_floor_array as &$mall_floor){
			$mall_floor['mall_floor_id'] = $mall_floor['id'];
			unset($mall_floor['id']);
			
			$mall_floor['mall_floor_name'] = $mall_floor['floor_name'];
			unset($mall_floor['floor_name']);
			
			$mall_floor['mall_floor_photo'] = json_decode($mall_floor['floor_photo']);
			unset($mall_floor['floor_photo']);
			
			$mall_floor = array_merge($mall_floor,$this->get_mall_where(array('id'=>$mall_floor['mall_id']))[0]);
		}
		return $mall_floor_array;
	}
	
	/*
	 *@desc		获取 商场楼层
	 * */
	public function get_mall_floor_where($where_map = array(),$select_map=array(),$limit_arr=array()){
		return $this->_mall_floor_handler($this->ci_get(T_MALL_FLOOR,$where_map,$select_map,$limit_arr));
	}
	
	
	
	
}


























