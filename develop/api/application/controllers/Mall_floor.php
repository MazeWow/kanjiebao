<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mall_floor extends JB_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Mall_floor_model');
	}
	
	public function lists()
	{
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		//可选参数　mall_id
		$where_map = array();
		if(isset($mall_id)&&($mall_id != 0)){
			$where_map = array('mall_id'=>$mall_id);
		}
		do{
			$records = $this->Mall_floor_model->get_mall_floor_where($where_map,array(),array($this->page_size,$this->page_now));
			$pages = $this->Mall_floor_model->get_records_nums(T_MALL_FLOOR,$where_map,$this->page_now,$this->page_size);
			$this->st(array('records'=>$records,'pager'=>$pages),'success');
			break;
		}while(0);
		$this->op();
	}
	
	public function add()
	{
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_MALL_FLOOR);
			$brand_info = array(
					'floor_name'		=>	$name,
					'mall_id'	=>	$mall_id,
					'floor_photo'=>json_encode($photo)
			);
			$res = $this->Table_model->records_add($brand_info);
			$this->op($res);
				
		}while(0);
		
		//输出成功接口数据
		$this->op();
	}
	
	public function detail()
	{
		$must = array('floor_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$where_map = array('id'=>$floor_id);
			$res = $this->Mall_floor_model->get_mall_floor_where($where_map,array(),array($this->page_size,$this->page_now))[0];
			$this->st($res,'success');
		}while(0);
		$this->op();
	}
	
	public function del()
	{
		$must = array('mall_floor_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_delete(T_MALL_FLOOR,array('id'=>$mall_floor_id));
			$this->st();
		}while(0);
		$this->op();
	}
	
	
	public function edit(){
		$must = array('mall_floor_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$mall_floor_data = array(
					'floor_photo'=>json_encode($photo),
					'mall_id'=>$mall_id,
					'floor_name'=>$name
			);
			$this->Base_model->ci_update(T_MALL_FLOOR,array('id'=>$mall_floor_id),$mall_floor_data);
			$this->st();
		}while(0);
		$this->op();
	}
	
	
}







