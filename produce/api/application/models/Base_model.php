<?php
class Base_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	/*
	 * @desc 	新增 sql 		查询函数
	 * @param 	$sql  sql 		语句
	 * @param 	[$params] 		如果要使用第二个参数的话，请参照 CI 文档: $this->db-query();
	 * @return  查询成功 			返回列表
	 * 			查询失败 			返回false
	 * */
	public function ci_query($sql,$params = array()){
		$query = $this->db->query($sql,$params);
		if(empty($query->result_array())){
			return false;
		}
		return $query->result_array();
	}
	/*
	 * @desc 	插入函数
	 * @param  	$table_name     		eg: 'user'
	 * @param  	$param_array	   		eg: array('id'=>1111,'username'=>'caokaiyan');
	 * @return  插入成功  影响记录条数
	 * 			插入失败  false
	 * */
	public function ci_insert($table,$param_array){
		$this->db->insert($table, $param_array);
		if($row = $this->db->affected_rows()){
			return $row;
		}
		return false;
	}
	/*
	 * @desc 	查询函数
	 * @param   $table_name 	 	表名
	 * @param	$select_map   		要查询的字段数组  eg: array('id','username');
	 * @param   $where_map		 	要查询的条件数组  eg: 参考 CI $this->db->where();
	 * @param   $limit_arr			返回列表条件数组  eg: array(10,20);第20页，10条记录
	 * @param	$order_map			排序数组		    eg: array('title'=>'ASC','name' => 'DESC');
	 * */
	public function ci_get($table_name,$where_map=array(),$select_map = array(),$limit_arr = array(),$order_map=array(),$like_map=array()){
		//select_map
		if(!empty($select_map)){
			$str = implode(',', $select_map);
			$this->db->select($str);
		}
		//where_map
		if(!empty($where_map)){
			$this->db->where($where_map);
		}
		
		//limit_arr
		if(!empty($limit_arr)){
			$this->db->limit($limit_arr[0],($limit_arr[1]-1)*$limit_arr[0]);
		}
		
		//order_map
		if(!empty($order_map)){
			foreach ($order_map as $key =>$value){
				$this->db->order_by($key,$value);
			}
		}
		
		//like 查询 
		if(!empty($like_map)){
			foreach ($like_map as $key =>$value){
				$this->db->like($key,$value);
			}
		}
		
		$res = $this->db->get($table_name);
		//返回查询到的数据
		$result = array();
		if ($res->num_rows() > 0){
			return $res->result_array();
		}
		return false;
	}
	/*
	 * @desc		更新数据
	 * @param		$table_name  	eg:'user'
	 * @param		$param_array	eg:array('username'=>'caokaiyan','title'=>'coding monkey')
	 * @param		$where_map		eg:参考 CI $this->db->where();
	 * @return  	更新成功  		影响记录条数
	 * 				更新失败  		false
	 * */
	public function ci_update($table,$where_map,$param_array){
		$this->db->where($where_map);
		$this->db->update($table, $param_array);
		if($row = $this->db->affected_rows()){
			return $row;
		}
		return false;
	}
	/*
	 * @desc		删除多个表的数据
	 * @param		$table_arr		eg: array('user','product')
	 * @param		$where_map		eg:	参考 CI $this->db->where();
	 * @return		删除成功  		影响记录条数
	 * 				删除失败  		false
	 * */
	public function ci_delete($table_arr,$where_map){
		$this->db->where($where_map);
		$this->db->delete($table_arr);
		if($row = $this->db->affected_rows()){
			return $row;
		}
		return false;
	}
	
	/*
	 * @dese	获取某个条件的分页
	 * */
	public function get_records_nums($table,$where_map = array(),$page_now = 1,$page_size = 1,$like_map=array()){
		$this->db->select('count(id) as total_rows');
		
		//like 查询
		if(!empty($like_map)){
			foreach ($like_map as $key =>$value){
				$this->db->like($key,$value);
			}
		}
		
		// where 条件
		if(!empty($where_map)){
			$this->db->where($where_map);
		}
		$res = $this->db->get($table);
		if($res->result_array()){
			$nums = $res->result_array()[0]['total_rows'];
			return paging($nums,$page_now,$page_size);
		}
		return paging(0,$page_now,$page_size);
	}
	
	
}