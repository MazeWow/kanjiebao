<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ad extends JB_Controller {
	public function __construct(){
		parent::__construct();
	}
	/*
	 *	@desc	添加一个
	 * */
	public function mall_ad_add(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$ad_info = array(
					'ad_name'	=>	$name,
					'mall_id'	=>	$mall_id,
					'ad_photo'	=>	$photo[0],
					'ad_link'	=>	$ad_url
			);
			$this->Table_model->init(T_MALL_AD);
			$res = $this->Table_model->records_add($ad_info);
			$this->op($res);
		}while(0);
		$this->op();
	}
	/*
	 *@desc		获取品牌列表
	 *@param	mall_id		根据商场id 取广告
	 * */
	public function mall_ad_lists()
	{
		$must = array('mall_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		
		if(!isset($page_size)){
			$page_size = 20;
		}
		if(!isset($page_now)){
			$page_now = 1;
		}
		do{
			$limit_arr = array($page_size,$page_now);
			$where_map	= array();
			if($mall_id != 0){
				$where_map = array('mall_id'=>$mall_id);
			}
			$this->Table_model->init(T_MALL_AD);
			$res = $this->Table_model->records($where_map,array(),$limit_arr);
			if($res['err_num'] == 0){
				$res['results']['pager']=paging($res['results']['records_num'],$page_now,$page_size);
				unset($res['results']['records_num']);
				$this->op($res);
			}else{
				$this->st(0,'该商场下无广告',API_NORMAL_ERR);
			}
		}while(0);
		$this->op();
	}
	/*
	 *@desc		删除一个商场广告
	 * */
	public function mall_ad_del(){
		$must = array('mall_ad_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_delete(T_MALL_AD,array('id'=>$mall_ad_id));
			$this->st();
		}while(0);
		$this->op();
	}
	
	
	
	
}








