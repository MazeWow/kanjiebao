<?php
include_once 'Base_model.php';
/*
 * @desc			这是表的抽象模型，操作颗粒为 一条记录
 * */
class Table_model extends Base_model {
	
	protected $table;
	
	public function __construct(){
		parent::__construct();
	}
	
	public function init($table){
		$this->table = $table;
	}
	/*
	 * @desc		表里面符合条件的记录数
	 * */
	public function records_num($wheremap = array()){
		$this->db->select('count(id) as total_rows');
		if($wheremap != array()){
			$this->db->where($wheremap);
		}
		$res = $this->db->get($this->table);
		//返回查询到的数据
		$result = array();
		if ($res->num_rows() > 0){
			foreach ($res->result_array() as $row)
			{
				$result[] = $row;
			}
			$res->free_result();
			return $result[0]['total_rows'];
		}
		return false;
	}
	/*
	 * @desc		表里面符合条件的从 $start 到 $end 条记录
	 * @param	$select_map   		要查询的字段数组  eg: array('id','username');
	 * @param   $where_map		 	要查询的条件数组  eg: 参考 CI $this->db->where();
	 * @param   $limit_arr			返回列表条件数组  eg: array(10,20);
	 * @param	$order_map			排序数组		  eg: array('title'=>'ASC','name' => 'DESC');
	 * */
	public function records($where_map=array(),$select_map = array(),$limit_arr = array(),$order_map=array()){
		$res = $this->ci_get($this->table,$where_map,$select_map,$limit_arr,$order_map);
		$records_num = $this->records_num($where_map);
		if($res == FALSE){
			return return_format(array(),"获取记录错误",API_UNKNOW_ERR);
		}
		return return_format(array('records'=>$res,'records_num'=>$records_num),"获取记录成功");
	}
	/*
	 * @desc		表里面符合条件的从 $start 到 $end 条记录
	 * @param	$select_map   		要查询的字段数组  eg: array('id','username');
	 * @param   $where_map		 	要查询的条件数组  eg: 参考 CI $this->db->where();
	 * @param   $limit_arr			返回列表条件数组  eg: array(10,20);
	 * @param	$order_map			排序数组		  eg: array('title'=>'ASC','name' => 'DESC');
	 * */
	public function record_one($where_map=array(),$select_map = array(),$limit_arr = array(),$order_map=array()){
		$res = $this->ci_get($this->table,$where_map,$select_map,$limit_arr,$order_map);
		if($res == FALSE){
			return false;
		}
		return $res[0];
	}
	/*
	 * @desc		删掉表里面符合条件的记录
	 * */
	public function records_delete($where_map){
		$res = $this->ci_delete($this->table, $where_map);
		if ($res == false){
			return return_format(array(),"删除记录错误",API_DB_ERR);
		}
		return return_format($res,"删除记录成功");
	}
	/*
	 * @desc		往表里面添加记录
	 * @desc		$records_info		键值对数组  	array('字段'=>'值');
	 * */
	public function records_add($records_info){
		$res = $this->ci_insert($this->table,$records_info);
		if($res){
			return return_format(array('affect_row'=>$res),"添加记录成功！");
		}
		return return_format(array(),"添加记录失败！",API_UNKNOW_ERR);
	}
}






