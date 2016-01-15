<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Store extends JB_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'Store_model' );
		$this->Table_model->init ( T_STORE );
	}
	/*
	 *@desc		商铺列表
	 * */
	public function lists() {
		$must = array ();
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		$this->page_size = 50;
		$limit_arr = array (
				$this->page_size,
				$this->page_now
		);
		do {
			
			//如果是 根据关键字查询 商铺列表
			if(isset($search_key)&&(!empty($search_key))){
				$like_map = array('name'=>$search_key);
				$store_info = $this->Store_model->get_store_where([],[],[],[],$like_map);
				$pager = $this->Store_model->get_records_nums(T_STORE,[],$this->page_now,$this->page_size,$like_map);
				$this->st(array('records'=>$store_info,'pager'=>$pager));
				break;
			}
			
			//根据 where_map 查询商铺列表
			$where_map = array ();
			{
			if (isset ( $mall_floor_id )) 
				$where_map ['mall_floor_id'] = $mall_floor_id;//查楼层下面的
			if (isset ( $street_id ))
				$where_map ['street_id'] = $street_id;//查商业街道下面的
			}
			{
				$store_info = $this->Store_model->get_store_where($where_map,[],$limit_arr);
				$pager = $this->Store_model->get_records_nums(T_STORE,$where_map,$this->page_now,$this->page_size);
				$this->st(array('records'=>$store_info,'pager'=>$pager));
				break;
			}
		} while ( 0 );
		$this->op ();
	}
	
	
	/*
	 * @desc	store_edit 编辑商铺
	 * */
	public function edit(){
		$must = array (
				'store_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$store_info = array(
					'name'=>$store_name,
					'mall_floor_id'=>$mall_floor_id,
					'brand_id'=>$brand_id,
					'cate_id_str'=>json_encode($category),
					'store_photo'=>json_encode($store_photo),
					'store_addr'=>$store_addr,
					'store_phone'=>$store_phone,
					'store_opening_hours'=>$store_opening_hours
			);
			$this->st($store_info);
			$this->Base_model->ci_update(T_STORE,array('id'=>$store_id),$store_info);
		} while ( 0 );
		$this->op ();
	}
	
	/*
	 *@desc		商铺详情
	 * */
	public function detail(){
		$must = array (
				'store_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$where_map = array('id'=>$store_id);
			$store_info = $this->Store_model->get_store_where($where_map,[])[0];
			$this->st($store_info);
		} while ( 0 );
		$this->op ();
	}
	/*
	 * @desc 添加一个商铺
	 */
	public function add() {
		$must = array (
				'store_name',
				'brand_id',
				'category'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$store_info = array (
					'cate_id_str' => json_encode ( $category ),
					'name' => $store_name,
					'brand_id' => $brand_id,
					'store_addr'=>$store_addr,
					'store_phone'=>$store_phone,
					'store_opening_hours'=>$store_opening_hours,
					'store_photo'=>json_encode($store_photo),
			);
			if (isset ( $mall_floor_id )) {
				$store_info ['mall_floor_id'] = $mall_floor_id;
			} elseif (isset ( $street_id )) {
				$store_info ['street_id'] = $street_id;
			}
			$this->Table_model->init ( T_STORE );
			$res = $this->Table_model->records_add ( $store_info );
			$this->st ( $res, '添加商场成功！' );
		} while ( 0 );
		$this->op ();
	}
	
	/*
	 * @desc		更新一个商铺
	 * 
	 * */
	public  function update(){
		$must = array (
				'store_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			
			$store_update_info = array();
			
			if(isset($brand_id)){
				$store_update_info['brand_id'] = $brand_id;
			}
			
			if(isset($name)){
				$store_update_info['name'] = $name;
			}
			
			if(isset($cate_id_arr)){
				$store_update_info['cate_id_str'] = json_encode($cate_id_arr);
			}

			//改变商场下商铺
			if(isset($mall_floor_id)){
				$store_update_info['mall_floor_id'] = $mall_floor_id;
				
			}
			
			
			//改变商业街下的商铺
			if(isset($street_id)){
				
			}
			
			//如果不改变商铺的路径
					
			$this->Base_model->ci_update(T_STORE,array('id'=>$store_id),$store_update_info);
			$this->st(array(),'更新成功!');
			
		} while ( 0 );
		$this->op ();
	}
	/*删除商铺*/
	public function del() {
		$must = array (
				'store_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->Base_model->ci_delete(T_STORE,array('id'=>$store_id));
			$this->st();
		} while ( 0 );
		$this->op ();
	}
	public function store_in_mall() {
		extract ( $this->params );
		$this->load->model ( 'table_model' );
		$this->table_model->init ( T_STORE );
		$res = $this->table_model->records ( array (
				'mall' => $mall_id
		) );
		$this->op ( $res );
	}
	/*
	 * @desc 生成商铺注册码接口
	 */
	public function add_verify_code() {
		$must = array (
				'store_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			// 创建一个　16 位的随机验证码农字符串,并加密
			$verify_code = rand_str ( 16, "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" );
			$crypt3des = new Crypt3Des ();
			$verify_code_en = $crypt3des->encrypt ( $verify_code );
			// 将加密字符串存入数据库中
			$this->load->model ( "Store_model" );
			$res = $this->Store_model->update ( $store_id, array (
					'verify_code' => $verify_code_en
			) );
			if ($res) {
				$this->st ( array (
						'verify_code' => $verify_code
				), "生成验证码成功!" );
				break;
			}
			$this->st ( array (), "生成验证码农失败", API_NORMAL_ERR );
		} while ( 0 );
		$this->op ();
	}
	/*
	 * @desc 用户通过验证码注册的接口
	 */
	public function register() {
		$must = array (
				'verify_code',
				'account',
				'pwd',
				're_pwd'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			// 判断验证码是否正确
			$this->Table_model->init ( T_STORE );
			$crypt3des = new Crypt3Des ();
			$store_id = $this->Table_model->record_one ( array (
					'verify_code' => $crypt3des->encrypt ( $verify_code )
			), array (
					'id'
			) ) ['id'];
			if ($store_id) {
				$this->Table_model->init ( T_STORE_ACCOUNT );
				$account = array (
						'name' => $account,
						'pwd' => pass_encrypt ( $pwd ),
						'store_id' => $store_id
				);
				$res = $this->Table_model->records_add ( $account );
				if ($res ['err_num'] == 0) {
					unset ( $account ['pwd'] );
					$this->st ( $account, '该商铺添加账号成功' );
					break;
				}
			}
			$this->st ( array (), '该商铺添加账号失败', API_NORMAL_ERR );
		} while ( 0 );
		$this->op ();
	}
	/*
	 * @desc 商铺管理账号登录接口
	 * @date 2015年 09月 20日 星期日 12:02:17 CST
	 */
	public function login() {
		$must = array (
				'store_account',
				'pwd'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->Table_model->init ( T_STORE_ACCOUNT );
			$res = $this->Table_model->record_one ( array (
					'name' => $store_account
			) );
			if ($res) {
				if ($res ['pwd'] == pass_encrypt ( $pwd )) {
					$session = $this->_set_store_login_seesion ( $res ['id'] );
					$this->st ( array (
							'store_session' => $session
					), "登录成功!" );
					break;
				} else {
					$this->st ( array (), "登录失败,密码错误", API_PWD_ERR );
					break;
				}
			}
			$this->st ( array (), "登录失败,账号错误", API_NORMAL_ERR );
		} while ( 0 );
		$this->op ();
	}
	/*
	 *@desc		返回商铺经营品类列表
	 * */
	public function category_list(){
		global $CATEGORY;
		$this->st(array("store_category"=>$CATEGORY),"获取列表成功");
		$this->op();
	}
	/*
	 * @desc 设置store_login session 的内部函数
	 */
	public function _set_store_login_seesion($store_account_id) {
		session_regenerate_id (); // 重置　session 　字符
		$session_info = array (
				'store_account_id' => $store_account_id,
				'session' => session_encrypt ( session_id () )
		);
		$this->Table_model->init ( T_STORE_SESSION );
		// 删除以前 登录　session ,重新存储
		$this->Table_model->records_delete ( array (
				"store_account_id" => $store_account_id
		) );
		$res = $this->Table_model->records_add ( $session_info );
		if ($res) {
			return $session_info ['session'];
		}
	}

}










