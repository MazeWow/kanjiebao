<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends JB_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->Table_model->init(T_BRAND);
	
	}
	/*
	 *	@desc	添加一个品牌
	 * */
	public function add(){
		$must = array('brand_name','brand_style','brand_photo');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_BRAND);
			$brand_info = array(
					'logo'		=>	json_encode($brand_photo),
					'name'		=>	$brand_name,
					'style_id'	=>	json_encode($brand_style),
			);
			$res = $this->Table_model->records_add($brand_info);
			$this->op($res);
		}while(0);
		$this->op();
	}
	/*
	 *@desc		获取品牌列表
	 * */
	public function lists()
	{
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$limit_arr = array($this->page_size,$this->page_now);
			$order_map = array('id'=>'desc');
			$this->load->model("Brand_model");
			
			//查询品牌列表
			if(isset($search_key)){
				$limit_arr = array(100,1);
				$ret = $this->Brand_model->search_lists($search_key,$limit_arr,$order_map);
				$this->st($ret,'查询品牌成功!');
				break;
			}
			
			//全部品牌列表
			$ret = $this->Brand_model->all_lists($limit_arr,$order_map);
			$this->st($ret,'查询品牌成功!');
			
			
		}while(0);
		$this->op();
	}
	
	/*
	 *@desc		brand_style_list 商品风格列表
	 * */
	public function style_list(){
		global $STYLE;
		$this->st(array("brand_style"=>$STYLE),"获取商品风格列表成功");
		$this->op();
	}
	
	/*
	 * @desc	品牌详情接口
	 * */
	public function detail(){
		$must = array('brand_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_BRAND);
			$res = $this->Table_model->record_one(array('id'=>$brand_id));
			if($res){
				$res['logo'] = json_decode($res['logo']);
				$res['style_id'] = json_decode($res['style_id']);
				$this->st($res);
				break;
			}
			$this->st(array(),"失败",API_NORMAL_ERR);break;
		}while(0);
		$this->op();
	}
	
	
	/*
	 * @desc	修改品牌接口
	 * */
	public function update(){
		$must = array('brand_id','brand_name','brand_style','brand_photo');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$brand_info = array(
					'name'=>$brand_name,
					"logo"=>json_encode($brand_photo),
					"style_id"=>json_encode($brand_style),
			);
			$res = $this->Base_model->ci_update(T_BRAND,array('id'=>$brand_id),$brand_info);
			if($res){
				$this->st(array(),"成功!");break;
			}
			$this->st(array(),"失败",API_NORMAL_ERR);
			break;
		}while(0);
		$this->op();
	}
	
	
	/*
	 * @desc	查询
	 * */
	public function search(){
		$must = array('brand_name');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select id from ".T_BRAND." where name = '".$brand_name."'";
			$res = $this->Base_model->ci_query($sql);
			if($res){
				$this->st(array(),"品牌成功!");
				break;
			}
			$this->st(array(),"失败",API_NORMAL_ERR);
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	删除一个品牌
	 * */
	public function del(){
		$must = array('brand_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_delete(T_BRAND,array('id'=>$brand_id));
			$this->st();
		}while(0);
		$this->op();
	}
	
	
	
}













