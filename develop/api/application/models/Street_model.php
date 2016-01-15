<?php
include_once 'Base_model.php';
class Street_model extends Base_model {
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 *@desc		获取商业街详情
	 *@param	商业街道id
	 * */
	public function info($stree_id){
		$street_info = array();
		$street_info['street_id'] = $stree_id;
		$street = $this->ci_get(T_STREET,array('id'=>$stree_id))[0];
		if($street == false){
			return false;
		}
		$street_info['street_name'] = $street['name'];
		$district = $this->ci_get(T_DISTRICT,array('id'=>$street['district_id']),array('name'))[0];
		if($district == false){
			return false;
		}
		$street_info['district_name'] = $district['name'];
		return $street_info;
	}
}






