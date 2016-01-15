<?php
include_once 'Base_model.php';
class User_model extends Base_model {
	public function __construct(){
		parent::__construct();
	}
	/*
	 * @desc	更新用户的一些信息
	 * */
	public function update($uid,$param_array){
		$res = $this->ci_update(T_USER, array('id'=>$uid),$param_array);
		return ($res)?TRUE:FALSE;
	}
	
	/*
	 *@desc		拿到用户的id
	 */
	public function get_uid($where_map){
		$res = $this->ci_get(T_USER,$where_map,array('id'));
		return ($res)?$res[0]['id']:false;
	}
	/*
	 * @desc	获取用户所有信息
	 * */
	public function info($uid,$select_map = array()){
		$res = $this->ci_get(T_USER,array('id'=>$uid),$select_map);
		return ($res)?$res[0]:false;
	}
	
	//用户收藏一个活动
	public function like_event($uid,$event_id){
		$param_array = array('uid'=>$uid,'eid'=>$event_id);
		$res = $this->ci_insert(T_USER_LIKE, $param_array);
		if($res != false){
			return return_format($res,"收藏一个活动成功");
		}
		else{
			return return_format(array(),"收藏一个活动失败!",API_DB_ERR);
		}
	}
	
	/*
	 * @desc	用户收藏活动列表
	 * */
	public function event_like_list($uid){
			//获取用户活动id 数组
			$a = $this->ci_get(T_USER_LIKE,array('uid'=>$uid),array('eid'));
			//如果获取成功
			if($a){
				$eid = array();//活动id数组
				foreach ($a as $value){
					$eid[] = $value['eid'];
				}
				$eid_str = join(",",$eid);
				$sql = "select store_id from ".T_EVENT." where id in (".$eid_str.")";
				$res = $this->ci_query($sql);
				if($res){
					$store = array();
					foreach ($res as $value){
						$store[] = $value['store_id'];
					}
					$store=array_unique($store); //去个重,多个活动可能属于同一家的
					$store_str = join(',',$store);
					//收藏的商场活动
					$mall_id = array();
					$sql = "select mall_floor_id from ".T_STORE." where mall_floor_id != 0 and id in (".$store_str.")";
					$mall_floor_id_res = $this->ci_query($sql);
					if($res){
						$mall_floor_id = array();
						foreach ($mall_floor_id_res as $value){
							$mall_floor_id[] = $value['mall_floor_id'];
						}
						$mall_floor_id = array_unique($mall_floor_id);
						$mall_floor_id_str= join(',',$mall_floor_id);
						$sql = "select mall_id from ".T_MALL_FLOOR." where id in (".$mall_floor_id_str.")";
						$mall_id_res = $this->ci_query($sql);
						if($mall_id_res){
							foreach ($mall_id_res as $value){
								$mall_id[] = $value['mall_id'];
							}
							$mall_id = array_unique($mall_id);
							$mall_id_str = join(',', $mall_id);
							$sql = "select district from ".T_MALL." where id in (".$mall_id_str.")";
							$district_res = $this->ci_query($sql);
						}
					}
					return array('mall_id'=>$mall_id,'eid'=>$eid);
					
					//@todo 收藏的商业街道活动,
					$street_id = array();
					$sql = "select street_id from ".T_STORE." where street_id != 0 and id in (".$store_str.")";
					$street_id_res = $this->ci_query($sql);
				}
			}
			return false;
	}
	/*
	 *@desc	  用户验证短信验证码
	 *@date
	 * */
	public function verify_check($phone){
		$sql = "select * from ".T_USRE_REGISTER_VERIFY." where phone = '".$phone."'";
		$res = $this->ci_query($sql);
		
		if($res){
			if(count($res)>10){
				return false;
			}
		}
		return true;
	}
	/*
	 *@desc		记录下获取了验证码的手机
	 *@date		Sun Sep 13 10:37:22 CST 2015
	 * */
	public function log_phone_verify($phone,$verify_code){
		$this->ci_insert(T_USRE_REGISTER_VERIFY, array('phone'=>$phone,'verify_code'=>$verify_code,'time'=>time()));
	}
	/*
	 *@desc	  判断手机是否已经注册了
	 *@return 注册了:true   没注册：false
	 * */
	public function is_phone_register($phone){
		$phone_res = $this->ci_get(T_USER,array('phone'=>$phone),array('id'));
		return ($phone_res)?TRUE:FALSE;
	}
	/*
	 *@desc	  判断验证码是否错误
	 *@return　正确：true    错误：false
	 * */
	public function is_verify_code($phone,$verify_code){
		$is_verify_code = $this->ci_get(T_USRE_REGISTER_VERIFY,array('phone'=>$phone,'verify_code'=>$verify_code),array('phone'));
		return ($is_verify_code)?TRUE:FALSE;
	}
	
	/*
	 *@desc		将某个手机的短信验证码删除
	 * */
	public function verify_code_del($phone){
		$sql = "delete from ".T_USRE_REGISTER_VERIFY." where phone = '".$phone."' ";
		$res = $this->ci_query($sql);
		return ($res)?TRUE:false;
	}
	
}






