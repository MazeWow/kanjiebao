<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Event extends JB_Controller {
	public function __construct() {
		parent::__construct ();
		$this->Table_model->init ( T_EVENT );
	}
	/*
	 * @desc 活动列表接口，重要，而且是最复杂的一个接口
	 * @params page_size 分页大小
	 * @params page_now 当前页
	 * @params cate_id_str 查询某个品类的活动
	 * @params style_id_str 查询活动的风格条件
	 * @params expired 连过期的一起获取　　取值　true
	 * @params is_publised 是否获取没发布的活动　取值 true
	 * @params is_del 是否获取已经删除的活动　取值　true
	 * @params store_id 商铺id ，用于查询某一商铺下的活动
	 * @params mall_floor_id 商场楼层id ,用于查询某一商场楼层下的所有活动
	 * @params mall_id 商场id ,用于查询某一商场下的所有活动
	 * @params district_id 商圈id ,用于查询某一商圈下所有活动
	 * @params longitude 　　　经度，latitude 维度，用于查询该位置附近的商圈的所有活动
	 */
	public function lists() {
		$must = array ();
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			// 设置分页
			if (isset ( $page_now )) {
				$this->page_now = $page_now;
			}
			if (isset ( $page_size )) {
				$this->page_size = $page_size;
			}
			// 根据不同的条件查询商铺的　id 了
			$store_id_str = '';
// 			$store_id = array();
			do {
				$this->load->model ( "Store_model" );
				
				//按品牌查询
				if(isset($brand_id)&&(!empty($brand_id))){
					$res  = $this->Base_model->ci_get(T_STORE,array('brand_id'=>$brand_id),array('id'));
					if($res == false){
						$this->op(return_format(array(),"该品牌下没数据",API_NORMAL_ERR));
					}
					$store_id = array();
					foreach ($res as $value){
						$store_id[] = $value['id'];
					}
					break;
					
				}
				
				// 只查询某个商铺下面的商铺
				if (isset ( $store_id )&&(!empty($store_id))) {
					$store_id = array (
							$store_id
					);
					break;
				}
	
				// 查询某个商场楼层下面的商铺
				if (isset ( $mall_floor_id ) && (!empty($mall_floor_id))) {
					$store_id = $this->Store_model->store_in_mall_floor ( $mall_floor_id );
					if ($store_id == false) {
						$this->st( array (), "该商场楼层下并没有活动！", API_NORMAL_ERR );
						$this->op();
					}
					$store_id = array_unique ( $store_id );
					break;
				}
	
				// 某个商场下面的商铺
				if (isset ( $mall_id )&& (!empty($mall_id))) {
					$store_id = $this->Store_model->store_in_mall ( $mall_id );
					if ($store_id == false) {
						$this->st ( array (), "该商场下并没有活动", API_NORMAL_ERR );
						$this->op();
						break;
					}
					$store_id = array_unique ( $store_id );
					break;
				}
	
				// 某个商圈下面的商铺
				if (isset ( $district_id )&& (!empty($district_id))) {
					$store_id = $this->Store_model->store_in_district ( $district_id );
					if ($store_id == false) {
						$this->st ( array (), "该商圈下没有活动", API_NORMAL_ERR );
						$this->op();
						break;
					}
					$store_id = array_unique ( $store_id );
					break;
				}
	
				// 地理位置附近的商圈的下的商铺
				if (isset ( $longitude ) && isset ( $latitude )) {
					$left_longitude = $longitude - 0.1;
					$right_longitude = $longitude + 0.1;
					$top_latitude = $latitude + 0.05;
					$bottom_latitude = $latitude - 0.05;
					$sql = "select id from " . T_DISTRICT . " where longitude between $left_longitude and $right_longitude and latitude between $bottom_latitude and $top_latitude";
						
					$res = $this->Base_model->ci_query ( $sql );
						
					if (! $res) {
						$this->st ( array (), '该地理位置附近没有活动', API_NORMAL_ERR );
						$this->op();
						break;
					}
						
					$store_id = array ();
					foreach ( $res as $value ) {
						$temp = $this->Store_model->store_in_district ( $value ['id'] );
						if ($temp) {
							$store_id = array_merge ( $store_id, $temp );
							break;
						}
					}
					break;
				}
	
				//获取全部商铺
				$sql = "select id from ".T_STORE;
				$res = $this->Base_model->ci_query($sql);
				foreach ($res as $value){
					$store_id[] = $value['id'];
				}
				//获取全部商铺
	
			} while ( 0 );
	
			$store_id = array_unique ( $store_id );
			$store_id_str = join ( ',', $store_id );
			
			
			// 如果有商铺，查出该商铺下面的所有活动id
			$sql = "select id from " . T_EVENT . " where store_id in(" . $store_id_str . ") ";
				
			// 查询某个品类的
			if (isset ( $cate_id_str )) {
				$sql .= "and cate_id_str like '%" . $cate_id_str . "%'";
			}
				
			// 活动的风格条件
			if (isset ( $style_id_str )) {
				$sql .= "and style_id_str like '%" . $style_id_str . "%'";
			}
				
			// 是否获取已经过期的活动
			if (! isset ( $expired )) {
				$time = time ();
				$sql .= " and etime + 86400 > $time ";
			}
				
			// 是否获取没发布的活动
			if (! isset ( $is_publised )){
				$sql .= " and is_publish = 1";
			}
				
			// 是否获取已经删除的活动
			if (! isset ( $is_del )) {
				$sql .= " and is_del = 0";
			}
				
			// 顺序: 按结束时间升序排列，也就说结束
			$sql .= " order by etime desc";
				
			// 分页
			$page_offset = $this->page_size * ($this->page_now - 1);
			$total_records = $this->Base_model->ci_query ( $sql );
			if (! $total_records) {
				$this->st ( array (), "没有符合条件的活动!", API_NORMAL_ERR );
				break;
			}
			$sql .= " limit $page_offset,$this->page_size";
			$res = $this->Base_model->ci_query ( $sql );
			$ids = array ();
			if ($res) {
				foreach ( $res as $value ) {
					$ids [] = $value ['id'];
				}
				$events_info = $this->_events_info ( $ids );
				$this->st ( array (
						'pager' => paging ( count ( $total_records ), $this->page_now, $this->page_size ),
						'records' => $events_info
				), "获取活动列表成功" );
			}
		} while ( 0 );
		$this->op ();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	 * @desc 添加活动接口
	 *
	 */
	public function add() {
		$must = array ();
		$this->check_param ( $must );
		if (is_array ( $this->params ['photo'] )) {
			$this->params ['photo'] = json_encode ( $this->params ['photo'] );
		}
		$this->params ['stime'] = intval ( strtotime ( $this->params ['stime'] ) );
		$this->params ['etime'] = intval ( strtotime ( $this->params ['etime'] ) );
		

		extract ( $this->params );
		do {
			//活动品类属性列表
			$category = json_encode ( $brand_style );
			
			//活动的风格属性 ：继承自品牌
			
			$this->load->model("Store_model");
			$store_info = $this->Store_model->info($store_id);
			$brand_style = $store_info["brand_style_arr"];
			
			$brand_style = json_encode($brand_style);
			
			$event_info = array (
					'name' => $name,
					'desc_cribe' => $desc_cribe,
					'stime' => $stime,
					'etime' => $etime,
					'photo' => $photo,
					'store_id' => $store_id,
					'cate_id_str'=>$category,
					'style_id_str' =>$brand_style
			);
			$res = $this->Table_model->records_add ( $event_info );
			if (0 == $res ['err_num']) {
				$this->op ( $res );
			}
			$this->st ( array (), "添加活动失败！", API_UNKNOW_ERR );
		} while ( 0 );
		$this->op ();
	}
	/*
	 * @desc 商品的详情
	 */
	public function detail() {
		$must = array (
				'event_id' 
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->load->model ( 'Event_model' );
			$this->load->model ( 'Store_model' );
			$event_info = $this->Event_model->info ( $event_id );
			$store_info = $this->Store_model->info ( $event_info ['store_id'] );
			unset ( $event_info ['store_id'] );
			$event_info = array_merge ( $event_info, array (
					'store_info' => $store_info 
			) );
			$this->st ( $event_info, "获取活动详情成功" );
		} while ( 0 );
		$this->op ();
	}
	/*
	 * @desc 添加活动商品
	 */
	public function product_add() {
		$must = array (
				'event_id' 
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$event_product = array (
					'name' => $product_name,
					'event_id' => $event_id,
					'cate_id_str' => $product_cate,
					'photo' => $photo [0],
					'product_photos' => json_encode ( $product_photos ),
					'product_desc' => $product_desc,
					'price' => $price,
					'promote_price' => $promote_price 
			);
			$this->Table_model->init ( T_PRODUCT );
			$res = $this->Table_model->records_add ( $event_product );
			$this->op ( $res );
		} while ( 0 );
		$this->op ();
	}
	
	/*
	 * @desc 发布一个活动接口
	 * @desc Sat Sep 19 14:08:59 CST 2015
	 */
	public function publish() {
		$must = array (
				'event_id' 
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->load->model ( 'Event_model' );
			$this->Event_model->init ( $event_id );
			$this->Event_model->update ( $event_id, array (
					"is_publish" => 1 
			) );
			$is_publish = $this->Event_model->get ( array (
					'is_publish' 
			) ) [0] ['is_publish'];
			if ($is_publish) {
				$this->st ( array (), "发布成功" );
				break;
			}
			$this->st ( array (), "发布失败", API_NORMAL_ERR );
		} while ( 0 );
		$this->op ();
	}
	/*
	 * @desc 取消发布一个活动的接口
	 * @desc Sat Sep 19 14:08:59 CST 2015
	 */
	public function cancel_publish() {
		$must = array (
				'event_id' 
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->load->model ( 'Event_model' );
			$this->Event_model->init ( $event_id );
			$this->Event_model->update ( $event_id, array (
					"is_publish" => 0 
			) );
			$is_publish = $this->Event_model->get ( array (
					'is_publish' 
			) ) [0] ['is_publish'];
			if ($is_publish == 0) {
				$this->st ( array (), "取消发布成功" );
				break;
			}
			$this->st ( array (), "取消发布失败", API_NORMAL_ERR );
		} while ( 0 );
		$this->op ();
	}
	
	/*
	 * @desc 删除一个活动接口
	 * @desc Sat Sep 19 14:08:59 CST 2015
	 */
	public function del() {
		$must = array (
				'event_id' 
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->load->model ( 'Event_model' );
			$this->Event_model->init ( $event_id );
			$this->Event_model->update ( $event_id, array (
					"is_del" => 1 
			) );
			$is_del = $this->Event_model->get ( array (
					'is_del' 
			) ) [0] ['is_del'];
			if ($is_del) {
				$this->st ( array (), "删除活动成功" );
				break;
			}
			$this->st ( array (), "删除活动失败", API_NORMAL_ERR );
		} while ( 0 );
		$this->op ();
	}
	
	//删除一个活动商品的接口
	public function delete_product(){
		$must = array (
				'product_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do{
			$sql = "delete from ".T_PRODUCT." where id = ".$product_id;
			$res = $this->Base_model->ci_query($sql);
			$this->st(array(),"成功!");
		}while(0);
		$this->op();
	}
	
	//修改活动信息的接口
	public function edit(){
		$must = array ('event_id');
		$this->check_param ( $must );
		$this->check_sign ();
		$this->params ['stime'] = intval ( strtotime ( $this->params ['stime'] ) );
		$this->params ['etime'] = intval ( strtotime ( $this->params ['etime'] ) );
		$this->params ["brand_style"] = json_encode($this->params["brand_style"]);
		extract ( $this->params );
		do{
			$event_info = array(
					"name"=>$name,
					"etime"=>$etime,
					"stime"=>$stime,
					"cate_id_str"=>$brand_style,
			);
			
			if(isset($store_id)){
				$event_info['store_id'] = $store_id;
			}
			if(isset($photo)){
				$event_info['photo'] = json_encode($photo);
			}
			if(isset($desc_cribe)){
				$event_info['desc_cribe'] = $desc_cribe;
			}
			$res = $this->Base_model->ci_update(T_EVENT,array('id'=>$event_id),$event_info);
			$this->st(array(),"更新成功!");
		}while(0);
		$this->op();
	}
	
	
	// 内部函数
	/*
	 * @desc 查询某些活动详细信息
	 * @param $ids　　活动id 的数组　eg : sarray('14','15');
	 */
	private function _events_info($ids) {
		$this->load->model ( 'Store_model' );
		$this->load->model ( 'Event_model' );
		$events_info = array ();
		foreach ( $ids as $value ) {
			$event_info = $this->Event_model->info ( $value );
			$store_info = $this->Store_model->info ( $event_info ['store_id'] );
			unset ( $event_info ['store_id'] );
			$events_info [] = array_merge ( $event_info, array (
					'store_info' => $store_info 
			) );
		}
		return $events_info;
	}
}
















