<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends JB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
	}
	/*
	 *@desc		用户注册接口
	 * */
	public function register()
	{
		$must = array("phone","pwd","re_pwd",'verify_code');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			//手机是否已经注册 ?
			$is_register = $this->User_model->is_phone_register($phone);
			if($is_register){
				$this->st(array('phone'=>$phone),"该手机号已经注册",API_PHONE_REGISTERED);
				break;
			}
			//验证码是否错误 ?
			$is_verify_code = $this->User_model->is_verify_code($phone,$verify_code);
			if($is_verify_code == FALSE){
				$this->st(array('verify'=>$verify_code),"用户注册验证码错误",API_REGISTER_VERIFY_CODE_ERR);
				break;
			}
			//密码格式是否错误 ?
// 			if( !preg_match('/^[a-zA-Z0-9_]{6,20}$/',$pwd) ){
// 				$this->st(array(),'密码格式错误(请输入6到20位字母数字组合)',API_PWD_FORMAT_ERR);
// 				break;
// 			}
			//密码是否输入错误 ?
			if($pwd != $re_pwd){
				$this->st(array('pwd'=>$pwd,'re_pwd'=>$re_pwd),"两次输入的密码不一致！",API_PWD_ERR);
				break;
			}
			//插入用户表
			$this->Table_model->init(T_USER);
			$user_info = array('phone'=>$phone,'pwd'=>pass_encrypt($pwd),'register_time'=>time());
			$res = $this->Table_model->records_add($user_info);
			//设置用户登录　session 等
			if($res['err_num'] == 0){
				//@todo 将用于验证用户注册时产生的短信验证码删掉,这个函数报错了，有时间再搞搞
				//$this->User_model->verify_code_del($phone);
				
				//注册成功，添加　user_session
				$uid = $this->Table_model->records(array('phone'=>$phone));
				$uid = $uid['results']['records'][0]['id'];
				
				session_regenerate_id();					//重置　session 　字符
				$session_info = array('uid'=>$uid,'session'=>session_encrypt(session_id()));
				$this->Table_model->init(T_USER_SESSION);
				
				//删除以前 登录　session ,重新存储
				$this->Table_model->records_delete(array("uid"=>$uid));
				$this->Table_model->records_add($session_info);
				unset($session_info['uid']);
				$this->st($session_info,"注册成功！");
				break;
			}
			else{
				$this->op($res);
			}
		}while(0);
		$this->op();
	}
	
	/*
	 *@desc		用户登录接口
	 *
	 * */
	public function login()
	{
		$must = array('phone','pwd');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_USER);
			$res = $this->Table_model->records(array("phone"=>$phone));
			if($res['err_num'] == 0){
				$user = $res['results']['records'][0];
				$pass_db = $user['pwd'];
				$uid = $user['id'];
				if(pass_encrypt($pwd) == $pass_db){
					$res = $this->_set_user_session($uid);
					$user_session = $res['results']['records'][0];
					$this->st(array('session'=>$user_session['session']),"用户登录成功！");
					break;
				}else{
					$this->st(array(),"对不起,密码错误！",API_PWD_ERR);
					break;
				}
			}else{
				$this->st(array(),"该手机号尚未注册!",API_USER_ERR);
				break;
			}
		}while(0);
		$this->op();
	}
	/*
	 *@desc		设置用户　session 接口
	 *
	 */
	public function _set_user_session($uid){
		$this->Table_model->init(T_USER_SESSION);
		session_regenerate_id();					//重置　session 　字符
		$session_info = array('uid'=>$uid,'session'=>session_encrypt(session_id()));
		$this->Table_model->init(T_USER_SESSION);
			
		//删除以前 登录　session ,重新存储
		$this->Table_model->records_delete(array("uid"=>$uid));
		$this->Table_model->records_add($session_info);
		return $this->Table_model->records(array("uid"=>$uid));
	}
	
	/*
	 *@desc		用户注销接口
	 * */
	public function logout(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_USER_SESSION);
			$this->Table_model->records_delete(array('session'=>$session));
			$res = $this->Table_model->records(array('uid'=>$this->user['uid'],'session'=>$session));
			if($res['err_num'] != 0){
				$this->st(array(),"用户退出成功!");
			}
		}while(0);
		$this->op();
	}
	/*
	 *@desc		用户详情接口
	 *
	 * */
	public function detail(){
		$must = array('session');
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		do{
			$res = $this->User_model->info($this->user['id']);
			if($res){
				unset($res['pwd']);
				$this->st($res,"获取用户详情成功!");
			}
			$this->st(array(),"获取用户详情失败",API_USER_ERR);
		}while(0);
		$this->op();
	}
	
	/*
	 *@desc		已经登录用户修改密码
	 *
	 * */
	public function modify_pwd(){
		$must = array('session','new_pwd','new_pwd_re');
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		do{
			//确认密码输入无误
			if($new_pwd != $new_pwd_re){
				$this->st(array(),"两次输入密码不一致",API_PWD_SAME_ERR);
			}
// 			if( !preg_match('/^[a-za-z0-9_]{6,20}$/',$new_pwd) ){
// 				$this->st(array(),'密码格式错误(请输入6到20位字母数字组合)',API_UNKNOW_ERR);
// 				break;
// 			}
			if($this->user['pwd'] == pass_encrypt($new_pwd)){
				$this->st(array(),"新密码不能和旧密码相同",API_PWD_DIFF_ERR);
				break;
			}
			$is_update = $this->User_model->update($this->user['id'],array('pwd'=>pass_encrypt($new_pwd)));
			if($is_update){
				$this->st(array('new_pwd'=>$new_pwd),"修改用户密码成功");
				break;
			}else{
				$this->st(array(),"修改用户密码失败",API_PWD_MODIFY_ERR);
				break;
			}
		}while(0);
		$this->op();
	}
	/*
	 * @desc	用户收藏活动列表
	 * */
	public function event_lists(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		if(!isset($page_now)){
			$page_now = 1;
		}
		if(!isset($page_size)){
			$page_size = 10;
		}
		do{
			
			$this->load->model("User_model");
			$res = $this->User_model->event_like_list($this->user['id']);
			if($res){
				//拿到所有的活动列表
				$this->load->model("Event_model");
				$this->load->model("Store_model");
				$event_info = array();
				foreach ($res['eid'] as $value){
					$event = $this->Event_model->info($value);
					$store = $this->Store_model->info($event['store_id']);
					unset($event['store_id']);
					$event_info[] = array_merge($event,array('store_info'=>$store));
				}
				//给活动列表按商场分下类
				$mall = array();
				foreach ($res['mall_id'] as $mall_id){
					foreach ($event_info as $value){
						if(!empty($value['store_info']['mall_id'])){
							if($mall_id == $value['store_info']['mall_id']){
								$mall[$mall_id][] = $value;
							}
						}
					}
				}
				
				$district_id = array();
				foreach ($event_info as $value){
					$district_id[] = $value['store_info']['district_id'];
				}
				$district_id = array_unique($district_id);
				$district_sort = array();
				foreach ($district_id as $value ){
					foreach ($event_info as $event){
						if($value == $event['store_info']['district_id']){
							$district_sort[$value][] = $event;
						}
					}
				}
				$this->st($district_sort,"获取用户收藏列表成功!");
			}
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	用户最佳逛街时间接口
	 * */
	public function user_street_time(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		do{
			$uid = $this->user['id'];
			$sql = "select E.id ,E.etime from ".T_USER_LIKE." as U inner join ".T_EVENT." as E where U.eid = E.id and E.etime > '".time()."' and U.uid = ".$uid;
			$sql .= " order by E.etime limit 1";
			$res = $this->Base_model->ci_query($sql);
			if($res){
				$street_time = $res[0]['etime'];
				$event_id   = $res[0]['id'];
				$this->st(array('street_time_str'=>date("m月d日",$street_time),'street_time'=>$street_time,
						'event_id'=>$event_id						
				),"最佳逛街时间");
			}else{
				$this->st(array(),"未收藏活动，或者没有最佳逛街时间",API_NORMAL_ERR);
			}
		}while(0);
		$this->op();
	}
	
	
	
	
	
	
	
	
	/*
	 * @desc	查看一个活动是否被用户收藏
	 * */
	public function check_like(){
		$must = array('event_id');
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		do{
			$this->Table_model->init(T_USER_LIKE);
			$res = $this->Table_model->records(array("uid"=>$this->user['id'],"eid"=>$event_id));
			if($res['err_num']==0){
				$this->st(array('event_id'=>$event_id),"用户已经收藏该活动！");
				break;
			}else{
				$this->st(array(),"用户未收藏该活动！",API_NORMAL_ERR);
				break;
			}
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	用户收藏活动
	 * */
	public function like_event(){
		$must = array('event_id');
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		do{
			$this->Table_model->init(T_USER_LIKE);
			$res = $this->Table_model->records(array("uid"=>$this->user['id'],"eid"=>$event_id));
			if($res['err_num']==0){
				$this->st(array('event_id'=>$event_id),"该活动已经被收藏",API_NORMAL_ERR);
				break;
			}else{
				$this->User_model->like_event($this->user['id'],$event_id);
				$this->st(array('event_id'=>$event_id),"活动收藏成功");
			}
		}while(0);
		$this->op();
	}
	/*
	 *@desc	 用户取消一个收藏活动接口
	 *@date  Thu Sep 10 14:56:15 CST 2015
	 * */
	public function cancel_event(){
		$must = array('event_id');
		$this->check_param($must);
		$this->check_sign();
		$this->check_session();
		extract($this->params);
		do{
			$this->Table_model->init(T_USER_LIKE);
			$this->Table_model->records_delete(array('uid'=>$this->user['id'],'eid'=>$event_id));
			$res = $this->Table_model->records(array('uid'=>$this->user['id'],'eid'=>$event_id));
			if($res['err_num'] != 0){
				$this->st(array(),"取消活动收藏成功！");
				break;
			}
		}while(0);
		$this->op();
	}
	
	//添加用户评论接口
	public function comment_add(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$name = (isset($user_name))?($user_name):(' ');
			$comment = (isset($comment))?($comment):(' ');
			$user_info = (isset($user_info))?($user_info):(' ');
			$comment_info = array(
					'user_name'	=>$name,
					'comment'	=>$comment,
					'user_info' =>$user_info
			);
			$this->Table_model->init(T_USER_COMMENT);
			$res = $this->Table_model->records_add($comment_info);
			$this->op($res);
		}while(0);
		$this->op();
	}
	
	/*
	 *@desc  短信验证码接口
	 *@date  Sun Sep 13 11:32:36 CST 2015
	 * */
	public function msg_verify(){
		$must = array('phone');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			//每个手机号,10分钟内,只能发送 10 条短信
			$is_check = $this->User_model->verify_check($phone);
			if($is_check == false){
				$this->st(array(),'发送给您的验证码已经超过10条,该手机号已经被绑定,请联系街报科技客服!',API_NORMAL_ERR);
				break;
			}
			$verify_code = rand_str(6,'0123456789');	//注册验证码
			$is_success = SMS_send($phone,"您的验证码是:".$verify_code.",如果不是您本人操作，请忽略此短信");
			if($is_success === '0'){
 				$this->User_model->log_phone_verify($phone,$verify_code);   //将 手机-验证码 记录下
				$this->st(array(),"短信已经发送,请您耐心等待(街巷科技)");
			}else{
				$this->st(array(),"短信发送失败,请重试!(多次失败,请联系街巷科技:116209742@qq.com)",API_NORMAL_ERR);
			}
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	找回密码
	 * */
	public function find_pwd(){
		$must = array("phone",'new_pwd','re_new_pwd','verify_code');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			//手机是否已经注册 ?
			$is_register = $this->User_model->is_phone_register($phone);
			if($is_register == false){
				$this->st(array('phone'=>$phone),"未注册的手机号，无法找回密码!",API_PHONE_REGISTERED);
				break;
			}
			//验证码是否错误 ?
			$is_verify_code = $this->User_model->is_verify_code($phone,$verify_code);
			if($is_verify_code == FALSE){
				$this->st(array('verify'=>$verify_code),"用户注册验证码错误",API_REGISTER_VERIFY_CODE_ERR);
				break;
			}
			//密码格式是否错误 ?
// 			if( !preg_match('/^[a-zA-Z0-9_]{6,20}$/',$new_pwd) ){
// 				$this->st(array(),'密码格式错误(请输入6到20位字母数字组合)',API_PWD_FORMAT_ERR);
// 				break;
// 			}
			//密码是否输入错误 ?
			if($new_pwd != $re_new_pwd){
				$this->st(array('pwd'=>$new_pwd,'re_new_pwd'=>$re_new_pwd),"两次输入的密码不一致！",API_PWD_ERR);
				break;
			}
			
			$uid = $this->User_model->get_uid(array('phone'=>$phone));
			
			//如果新密码与旧的密码相同
			$pwd = $this->User_model->info($uid)['pwd'];
			if($pwd == pass_encrypt($new_pwd)){
				$this->st(array('new_pwd'=>$new_pwd),"找回密码成功！请谨慎保管!");
				break;
			}
			//更新为新密码
			if($uid){
				$is_update = $this->User_model->update($uid,array('pwd'=>pass_encrypt($new_pwd)));
				if($is_update){
					$this->st(array('new_pwd'=>$new_pwd),"找回密码成功！请谨慎保管!");
					break;
				}
			}
			
			$this->st(array(),"找回密码失败!请重试!",API_PWD_MODIFY_ERR);
			
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	用户吐槽接口
	 * */
	public function tucao(){
		$must = array('user_tucao');
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			if(!isset($user_name)){
				$user_name = "unknow_user";
			}
			$tucao = array('user_name'=>$user_name,'user_tucao'=>$user_tucao,'time'=>time());
			$this->Table_model->init(T_USER_TUCAO);
			$res = $this->Table_model->records_add($tucao);
			$this->op($res);
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	用户列表
	 * */
	public function lists(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			debug($this->params,'this->params');
			$this->Table_model->init(T_USER);
			$where_map = array();
			if(isset($this->params ['stime'])){
				$stime = intval ( strtotime ( $this->params ['stime'] ) );
				$etime = intval ( strtotime ( $this->params ['etime'] ) );
				$where_map = "register_time < $etime and register_time > $stime";
			}
			debug($where_map);
			$ret = $this->Table_model->records($where_map);
			if(!$ret){
				$this->st(array(),"无用户",API_NORMAL_ERR);
				break;
			}
			$results = $ret['results'];
			$results['pager'] = paging($results['records_num'],$this->page_now,$this->page_size);
			debug($results,'resutls');
			$this->st($results,"获取用户列表成功");
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	用户想去哪儿列表
	 * */
	public function want_go_list(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			
			$this->Table_model->init(T_USER_COMMENT);
			$limit_arr = array($this->page_size,$this->page_now);
			$ret = $this->Table_model->records(array(),array(),$limit_arr);
			$results = $ret['results'];
			$results['pager'] = paging($results['records_num'],$this->page_now,$this->page_size);
			$this->st($results);
		}while(0);
		$this->op();
	}
	
	
	/*
	 * @desc	用户吐槽列表
	 * */
	public function tocao_list(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
				
			$this->Table_model->init(T_USER_TUCAO);
			$limit_arr = array($this->page_size,$this->page_now);
			$ret = $this->Table_model->records(array(),array(),$limit_arr);
			$results = $ret['results'];
			$results['pager'] = paging($results['records_num'],$this->page_now,$this->page_size);
			$this->st($results);
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	用户吐槽列表
	 * */
	public function login_list(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$this->Table_model->init(T_USER_SESSION);
			$limit_arr = array($this->page_size,$this->page_now);
			$ret = $this->Table_model->records(array(),array(),$limit_arr);
			$results = $ret['results'];
			$results['pager'] = paging($results['records_num'],$this->page_now,$this->page_size);
			$this->st($results);
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	所有的用户数
	 * */
	
	public function users_num(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select count(id) as users_num from ".T_USER;
			$res = $this->Base_model->ci_query($sql)[0]; 
			$this->st($res);
		}while(0);
		$this->op();
	}
	
	
	
}

















