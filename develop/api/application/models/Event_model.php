<?php
include_once 'Base_model.php';
/*
 * @desc  这是 活动 的抽象模型，操作粒度是活动的具体字段，不限于 event 表
 * */
class Event_model extends Base_model {
	
	//活动id
	private $event_id;
	
	public function __construct() {
		parent::__construct();
	}
	/*
	 * @desc		初始化活动
	 * */
	public function init($event_id){
		$this->event_id = $event_id;
	}
	
	/*
	 *@desc		改变某个活动的具体信息
	 * */
	public function update($event_id,$param_arr=array()){
		return $this->ci_update(T_EVENT,array('id'=>$event_id), $param_arr);
	}
	
	
	
	/*
	 * @desc	    拿到活动的一些信息
	 * @param		字段名数组			array('字段名'，'字段名'...);
	 * */
	public function get($field_arr = array()){
		return $this->ci_get(T_EVENT,array('id' =>$this->event_id),$field_arr);
	}
	
	/*
	 * @desc		拿到活动的 详情
	 * @desc		详情包括: 活动名字，活动商铺，活动时间，活动商品
	 * */
	public function info($event_id){
		$event_info = array();
		
		//活动一般信息
		$event = $this->ci_get(T_EVENT,array('id'=>$event_id))[0];
		$event_info['event_id']		=	$event_id;
		$event_info['event_name'] = $event['name'];
		$event_info['event_describe']	= $event['desc_cribe'];
		$event_info['event_photo']	=	json_decode($event['photo']);
		$event_info['event_stime']	=	date('Y年m月d日',$event['stime']);
		$event_info['event_etime']	=	date('Y年m月d日',$event['etime']);
		$event_info['event_left_day'] = ceil(($event['etime'] - time())/86400)+1;
		$event_info['store_id']		=	$event['store_id'];
		$event_info['is_publish']		=	$event['is_publish'];
		$event_info['is_del']			=	$event['is_del'];
		$event_info['stime']			=	$event['stime'];
		$event_info['etime']			=	$event['etime'];
		
		//活动包含品类
		$event_info['event_cate']			=	json_decode($event['cate_id_str']);
		
		//活动所属风格
		$event_info['event_style']			=	json_decode($event['style_id_str']);
		
		//活动商品
		$product = $this->ci_get(T_PRODUCT,array('event_id'=>$event_id));
		if($product){
			foreach ($product as &$value){
				unset($value['cate_id_str']);
				unset($value['event_id']);
				$event_info['product'][] = $value;
			}
		}
		
		//@todo 活动分享数
		$event_info['event_shall_num']	=	10;
		
		// 活动收藏数
		$sql = "select count(id) as event_like_num from ".T_USER_LIKE." where eid = $event_id";
		$res = $this->ci_query($sql);
		if($res){
			$event_info['event_like_num']	=	$res[0]['event_like_num'];
		}else{
			$event_info['event_like_num'] = 0;
		}
		
		
		return $event_info;
	}
	
	
	
	
	
}









