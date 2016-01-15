<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Street extends JB_Controller {
	
	/*
	 *@desc		商业街道列表
	 *@param	'district_id'选传参数	查询某一个商圈下的商业街
	 * */
	public function lists()
	{
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		if(!isset($page_now)){
			$page_now = 1;
		}
		$where_map = array();
		if(isset($district_id)&&($district_id!=0)){
			$where_map = array('district_id'=>$district_id);
		}
		do{
			$this->Table_model->init(T_STREET);
			$limit_arr = array($page_size,$page_now);
			$res = $this->Table_model->records($where_map,array(),$limit_arr);
			if($res['err_num'] == 0){
				$this->load->model('Street_model');
				foreach ($res['results']['records'] as &$value){
					$street_info[]= $this->Street_model->info($value['id']);
				}
				$res['results']['records'] = $street_info;
				$res['results']['pager']=paging($res['results']['records_num'],$page_now,$this->page_size);
				unset($res['results']['records_num']);
				$this->op($res);
			}else{
				$this->st(array(),"获取商场列表失败！",API_UNKNOW_ERR);
			}
		}while(0);
		$this->op();
	}
	public function add()
	{
		$must = array('street_name','district_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_STREET);
			$brand_info = array(
					'name'		=>	$street_name,
					'district_id'	=>	$district_id,
			);
			$res = $this->Table_model->records_add($brand_info);
			$this->op($res);
		}while(0);
		$this->op();
	}
	
	public function detail()
	{
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_MALL);
			$res = $this->Table_model->records(array('id'=>$mall_id));
			if ($res['err_num'] == 0){
				$this->st($res['results']['records'][0],"城市详情！");
				break;
			}
		}while(0);
		$this->op();
	}
	
	//删除街道
	public function del()
	{
		$must = array('street_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_delete(T_STREET,array('id'=>$street_id));
			$this->st();
		}while(0);
		$this->op();
	}
	
	
	/*
	 * @desc		公开接口
	 * @desc		查询一个商圈下有哪些商场
	 * @params		district_id
	 * */
	public function mall_in_district(){
		extract($this->params);
		$this->load->model('table_model');
		$this->table_model->init(T_MALL);
		$res = $this->table_model->records(array('district'=>$district_id));
		$this->op($res);
	}
	
	
}
