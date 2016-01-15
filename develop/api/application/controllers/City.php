<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends JB_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 *@desc		城市列表
	 * */
	public function lists()
	{
		$must = array('province','page_now');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			if(!isset($page_size)){
				$page_size = 10;
			}
			$this->Table_model->init(T_CITY);
			$where_map = array('province'=>$province);
			$limit_arr = array($page_size,$page_now);
			$res = $this->Table_model->records($where_map,array(),$limit_arr);
			if($res['err_num'] == 0){
				$res['results']['pager']=paging($res['results']['records_num'],$page_now,$page_size);
				unset($res['results']['records_num']);
				$this->op($res);
			}else{
				$this->st(array(),"获取城市列表失败！",API_UNKNOW_ERR);
			}
		}while(0);
		$this->op();
	}
}
