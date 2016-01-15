<?php
include_once 'Base_model.php';

class Brand_model extends Base_model {
	public function __construct() {
		parent::__construct();
	}
	/*
	 * @desc	返回所有的品牌
	 * */
	public function all_lists($limit_arr = array(),$order_map = array()){
		$return  = array();
		$return['records'] = $this->ci_get(T_BRAND,array(),array(),$limit_arr,$order_map);
		foreach ($return['records'] as &$v){
			$v['logo'] = json_decode($v['logo']);
			$v['style_id'] = json_decode($v['style_id']);
		}
		$sql = "select count(*) as records_num from ".T_BRAND;
		$return['records_num'] = $this->ci_query($sql)[0]['records_num'];
		$return['pager'] = paging($return['records_num'],$limit_arr[1],$limit_arr[0]);
		return $return;
	}
	
	/*
	 * @desc	返回所有的品牌
	 * */
	public function search_lists($search_key,$limit_arr = array(),$order_map = array()){
		/*
		 * return 格式
		 * array(
		 * 		'records_num' = >10,		//总记录数
		 * 		'records'=>array(),			//记录列表
		 * 		'pager'=>array(				//记录页码
		 * 		)
		 * );
		 * */
		$return  = array();
		$sql = "select * from ".T_BRAND." where name like '%$search_key%'";
		$return['records']  = $this->ci_query($sql);
		foreach ($return['records'] as &$v){
			$v['logo'] = json_decode($v['logo']);
			$v['style_id'] = json_decode($v['style_id']);
		}
		$sql = "select count(*) as records_num from ".T_BRAND." where name like '%$search_key%'";
		$return['records_num'] = $this->ci_query($sql)[0]['records_num'];
		$return['pager'] = paging($return['records_num'],$limit_arr[1],$limit_arr[0]);
	
		
		return $return;
	}
	
}









