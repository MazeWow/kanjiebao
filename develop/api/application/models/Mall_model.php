<?php
include_once 'District_model.php';
class Mall_model extends District_model {
	
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 * @desc	处理返回的数据，重命名，或者解析 json 字符串
	 * */
	private function _mall_handler($mall_array = array()){
		if(count($mall_array)>0){
			foreach ($mall_array as &$mall){
				$mall['mall_id'] = $mall['id'];
				unset($mall['id']);
				
				$mall['mall_name'] = $mall['name'];
				unset($mall['name']);
				
				$mall['mall_photo'] = json_decode($mall['mall_photo']);
				
				$mall = array_merge($mall,$this->get_district_where(array('id'=>$mall['district']))[0]);
				unset($mall['district']);
			}
			return $mall_array;
		}
		return false;
	}
	
	public function get_mall_where($where_map = array()){
		return $this->_mall_handler($this->ci_get(T_MALL,$where_map));
	}
	
	/*
	 *@desc	获取商场的详情
	 *@param	mall_id		商场id
	 * */
	public function info($mall_id){
		$mall_info = array();
		$mall_info['mall_id'] = $mall_id;
		$mall = $this->ci_get(T_MALL,array('id'=>$mall_id))[0];
		if($mall == false){
			return false;
		}
		$mall_info['mall_name'] = $mall['name'];
		$district = $this->ci_get(T_DISTRICT,array('id'=>$mall['district']),array('name'))[0];
		if($district == false){
			return false;
		}
		$mall_info['district_name'] = $district['name'];
		$mall_info['mall_photo']  = array();
		if($mall['mall_photo']){
			$mall_info['mall_photo'] = json_decode($mall['mall_photo']);
		}
		return $mall_info;
	}
	
	/*
	 *@desc	获取商场楼层的的详情
	 *@param	mall_floor_id		商场id
	 * */
	public function floor_info($floor_id){
		$floor_info = array();
		$floor_info['mall_floor_id'] = $floor_id;
		$floor = $this->ci_get(T_MALL_FLOOR,array('id'=>$floor_id))[0];
		if($floor == false){
			return false;
		}
		$floor_info['mall_floor_name'] = $floor['floor_name'];
		$mall = $this->info($floor['mall_id']);
		$floor_info = array_merge($mall,$floor_info);
		return $floor_info;
	}
	
	
	
}






