<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mall extends JB_Controller {
	/*
	 *@desc 商场列表接口
	 *@param	page_now		必填参数
	 *@param	district_id 	可选参数   查询某商圈下商场,不填默认查询全部商场
	 *@param	page_size       可选参数   每页大小,默认 10
	 *@date		15-09-03
	 * */
	public function lists()
	{
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		//district_id 	可选参数
		$where_map = array();
		if(isset($district_id)&&($district_id != 0)){
			$where_map = array('district'=>$district_id);
		}
		do{
			$this->Table_model->init(T_MALL);
			$limit_arr = array($this->page_size,$this->page_now);
			$res = $this->Table_model->records($where_map,array(),$limit_arr);
			if($res['err_num'] == 0){
				$results = &$res['results'];
				$results['pager']=paging($results['records_num'],$this->page_now,$this->page_size);
				$this->load->model('Mall_model');
				foreach ($results['records'] as &$value){
					$value = array_merge($this->Mall_model->info($value['id']),$value);
					if($value['mall_photo']){
						$value['mall_photo'] = json_decode($value['mall_photo']);
					}
					
				}
// 				unset($results['records_num']);
				$this->op($res);
			}else{
				$this->st(array(),"获取商场列表失败！",API_UNKNOW_ERR);
			}
		}while(0);
		$this->op();
	}
	/*
	 *@desc	添加商场
	 *@param	'district_id'	商圈id
	 *@param	'mall_name'		商场名字
	 *@
	 * */
	public function add()
	{
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$mall_info = array();
			if(isset($name)){
				$mall_info['name'] = $name;
			}
			if($district_id){
				$mall_info['district'] = $district_id;
			}
			if($photo){
				$mall_info['mall_photo'] = json_encode($photo);
			}
			$this->Table_model->init(T_MALL);
			$res = $this->Table_model->records_add($mall_info);
			$this->op($res);
		}while(0);
		$this->op();
	}
	
	/*
	 *@desc		商圈详情
	 *@param	mall_id
	 * */
	public function detail()
	{
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		$this->load->model('Mall_model');
		do{
			$res = $this->Mall_model->info($mall_id);
			if($res){
				$this->st($res,"获取商品详情成功");
			}else{
				$this->st(array(),"获取商品详情失败",API_NORMAL_ERR);
			}
		}while(0);
		$this->op();
	}
	
	//
	public function del()
	{
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_delete(T_MALL,array('id'=>$mall_id));
			$this->st();
		}while(0);
		$this->op();
	}
	
	
	public function edit(){
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$mall_info = array();
			if(isset($name)){
				$mall_info['name'] = $name;
			}
			if(isset($district_id)){
				$mall_info['district'] = $district_id;
			}
			if(isset($photo)){
				$mall_info['mall_photo'] = json_encode($photo);
			}
			
			
			$ret = $this->Base_model->ci_update(T_MALL,array('id'=>$mall_id),$mall_info);
			
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
