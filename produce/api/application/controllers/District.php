<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District extends JB_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 *@desc	商圈列表	根据城市返回 商圈列表
	 *@param Longitude	经度
	 *@param Latitude	维度    (经纬度一般是用户传过来，用于计算他到商圈的距离)
	 * */
	public function lists()
	{
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			if(!isset($page_size)){
				$page_size = 10;
			}
			
			//设置默认的 city_id 为 1
			if(!isset($city_id)){
				$city_id = 1;
			}
			
			$this->Table_model->init(T_DISTRICT);
			
			$where_map = array('city'=>$city_id);
			
			//是否只返回已经开发的商圈
			if(isset($is_developed)) {
				$where_map['is_developed'] = $is_developed;
			}
			$limit_arr = array($page_size,$this->page_now);
			$order_map = array('is_developed'=>'desc');
			$res = $this->Table_model->records($where_map,array(),$limit_arr,$order_map);
			if($res['err_num'] == 0){
				$results = &$res['results'];
				$results['pager']=paging($results['records_num'],$this->page_now,$page_size);
				
				foreach ($results['records'] as &$value){
					$value['photo'] = json_decode($value['photo']);
					//@todo 因为城市暂时只有一个北京,先临时处理下
					$value['city_name'] = "北京";
					
					
					//如果传参数 longtitude , 和 latitude ,则多返回一个 用户距 商圈距离字段
					if(isset($Latitude)&&isset($Longitude)){
						if(!$Latitude){
							$value['distance'] = "无法获取您的位置信息";
						}
						if(!$Longitude){
							$value['distance'] = "无法获取您的位置信息";
						}else{
							$value['distance'] = getDistance($value['Latitude'],$value['Longitude'],$Latitude,$Longitude);
						}
					}else{
						$value['distance'] = "无法获取您的位置信息";
					}
					
				}
				unset($results['records_num']);
				$this->op($res);
			}else{
				$this->st(array(),"获取商圈列表失败！",API_UNKNOW_ERR);
			}
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	商圈详情列表
	 * */
	public function detail(){
		$must = array('district_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select * from ".T_DISTRICT." where id = ".$district_id;
			$res = $this->Base_model->ci_query($sql)[0];
			$res['photo'] = json_decode($res['photo']);
			$this->st($res,'获取商圈详情成功');
		}while (0);
		$this->op();
	}
	
	

	
	//操作：讲商圈设置为 未开发
	public function un_develop(){
		$must = array('district_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_update(T_DISTRICT,array('id'=>$district_id),array('is_developed'=>0));
			$this->st();
		}while(0);
		$this->op();
	}
	
	//操作：讲商圈设置未已经开发
	public function develop(){
		$must = array('district_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_update(T_DISTRICT,array('id'=>$district_id),array('is_developed'=>1));
			$this->st();
		}while(0);
		$this->op();
	}
	
	/*
	 *@desc		添加一个商圈
	 * */
	public function add(){
		$must = array('district_name','Longitude','Latitude','district_photo');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$district_info = array(
					'name'=>$district_name,
					'Longitude'=>$Longitude,
					'Latitude'=>$Latitude,
					'photo'=>json_encode($district_photo),
					'city'=>1, //暂时定为北京就好
			);
			$this->Table_model->init(T_DISTRICT);
			$res = $this->Table_model->records_add($district_info);
			$this->op($res);
		}while(0);
		$this->op();
	}
	/*
	 *@desc		删除一个商圈
	 * */
	public function del(){
		$must = array('district_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Base_model->ci_delete(T_DISTRICT,array('id'=>$district_id));
			$this->st();
		}while(0);
		$this->op();
	}

	public function edit(){
		$must = array('district_id');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$district_info = array(
					'Longitude'=>$Longitude,
					'Latitude'=>$Latitude,
					'name'=>$district_name,
			);
			if(isset($district_photo)){
				$district_info['photo'] = json_encode($district_photo);
			}
			$this->Base_model->ci_update(T_DISTRICT,array('id'=>$district_id),$district_info);
			$this->st();
		}while(0);
		$this->op();
	}
	
	
	
}









