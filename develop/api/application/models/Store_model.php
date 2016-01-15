<?php
include_once 'Mall_floor_model.php';
class Store_model extends Mall_floor_model {
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 * @desc	获取商场列表
	 * @date   2015-10-16 14:30:53
	 * */
	public function get_store_where($where_map = array(),
			$select_map=array(),$limit_arr=array(),$order_map=array(),$like_map=array()){
		return $this->_store_handler($this->ci_get(T_STORE,$where_map,$select_map,$limit_arr,$order_map,$like_map));
	}
	/*
	 * @desc	处理 store 信息
	 * */
	public function _store_handler($res){
		foreach ($res as &$store){
			$crypt3des = new Crypt3Des();
			$store['verify_code'] = $crypt3des->decrypt($store['verify_code']);
			
			$store['store_id'] = $store['id']; 
			unset($store['id']);
			
			$store['store_name'] = $store['name'];
			unset($store['name']);
			
			$store['store_photo'] = json_decode($store['store_photo']);
			
			$store = array_merge($store,$this->get_mall_floor_where(array('id'=>$store['mall_floor_id']))[0]);

			//商铺经营的品类
			global $CATEGORY;
			$category_id = json_decode($store['cate_id_str']);
			unset($store['cate_id_str']);
			foreach ($category_id as $value){
				$store['store_category'][$value] = $CATEGORY[$value];
			}
			
			//商铺所属的品牌
			$brand_id = $store['brand_id'];
			$brand = $this->ci_get(T_BRAND,array('id'=>$brand_id))[0];
			
			//商铺的品牌名字
			$store['brand_name']	=	$brand['name'];
			$store['brand_logo']	=	json_decode($brand['logo'])[0];
			$brand_style_id	=   json_decode($brand['style_id']);	
			
			//商铺的品牌的 风格
			$brand_style = [];
			global $STYLE;
			if($brand_style_id){
				foreach ($brand_style_id as $value){
					$brand_style[$value] = $STYLE[$value];
				}
			}
			$store['brand_style'] = $brand_style; 
			ksort($store);
			}
			return $res;
	}
	
	/*
	 *@desc		改变某个商铺的具体信息
	 * */
	public function update($store_id,$param_arr=array()){
		return $this->ci_update(T_STORE,array('id'=>$store_id), $param_arr);
	}
	/*
	 * @desc	获取商铺的一些详情
	 * */
	public function info($store_id){
		$store_info = array();
		$a = $this->ci_get(T_STORE,array('id'=>$store_id));
		//商品id
		$store_info['store_id']	=	$store_id;
		//商铺名称
		$store_info['store_name'] = $a[0]['name'];
		
		//如果是商场里面的商铺,往上搜索 它的层级
		if($a[0]['mall_floor_id'] != 0){
			$b = $this->ci_get(T_MALL_FLOOR,array('id'=>$a[0]['mall_floor_id']));
			$store_info['floor_name'] = $b[0]['floor_name'];
			$mall_id = $b[0]['mall_id'];
			$store_info['mall_id'] = $b[0]['mall_id'];
			$mall = $this->ci_get(T_MALL,array('id'=>$mall_id));
			$store_info['mall_name'] = $mall[0]['name'];
			$district_id = $mall[0]['district'];
			$store_info['district_id'] = $mall[0]['district'];
			$district = $this->ci_get(T_DISTRICT,array('id'=>$district_id));
			$store_info['district_name'] = $district[0]['name'];
		}
		
		//如果是商业街里面的商铺,往上搜查它的层级
		if($a[0]['street_id'] != 0){
			$street = $this->ci_get(T_STREET,array('id'=>$a[0]['street_id']));
			$store_info['street_name'] = $street[0]['name'];
			$district_id = $street[0]['district_id'];
			$store_info['district_id'] = $district_id;
			$district = $this->ci_get(T_DISTRICT,array('id'=>$district_id));
			$store_info['district_name'] = $district[0]['name'];
		}
		
		//商铺所属的品牌
		$brand_id = $a[0]['brand_id'];
		$brand = $this->ci_get(T_BRAND,array('id'=>$brand_id))[0];
		
		$brand_name = $brand['name'];
		
		$brand_logo = json_decode($brand['logo'])[0];
		$brand_style = json_decode($brand['style_id']);
		$store_info["brand_style_arr"] =  $brand_style;
		
		
		global $STYLE;
		if($brand_style){
			foreach ($brand_style as $value){
				$store_info['brand_style'][] = $STYLE[$value];
			}
			
		}
		
		$store_info['brand_name']	=	$brand_name;
		$store_info['brand_logo']	=	$brand_logo;
		
		//商铺经营的品类
		global $CATEGORY;
		$category_id = json_decode($a[0]['cate_id_str']);
		$store_info["category_id_arr"] =  $category_id;
		foreach ($category_id as $value){
			$store_info['category'][] = $CATEGORY[$value];
		}
		return $store_info;
	}
	
	
	/*
	 *@desc  查询商场楼层下的商铺
	 *@@return  商铺id 数组 ：array (0 => '1',1 => '2',)
	 * */
	public function store_in_mall_floor($mall_floor_id){
		$a = $this->ci_get(T_STORE,array('mall_floor_id'=>$mall_floor_id),array('id'));
		if($a == false){return $a;}
		else{
			$store_id =array();
			foreach ($a as $value){
				$store_id[]=$value['id'];
			}
			return $store_id;
		}
	}
	/*
	 *@desc  查询商场下的商铺
	 *@return  商铺id 数组 ：array (0 => '1',1 => '2',)
	 * */
	public function store_in_mall($mall_id){
		$a = $this->ci_get(T_MALL_FLOOR,array("mall_id"=>$mall_id),array('id'));
		if($a == false){return false;}
		$mall_floor_id = array();
		foreach ($a as $value){
			$mall_floor_id[] = $value['id'];
		}
		$mall_floor_id_str = join(',', $mall_floor_id);
		$sql = "select id from ".T_STORE." where mall_floor_id in (".$mall_floor_id_str.")";
		$a = $this->ci_query($sql);
		if($a == false){return false;}
		$store_id = array();
		foreach ($a as $value){
			$store_id[] = $value['id'];
		}
		return $store_id;
	}
	/*
	 *@desc  查询商圈下的商铺
	 *@return  商铺id 数组 ：array (0 => '1',1 => '2',)
	 * */
	public function store_in_district($district_id){
		$store_in_mall = array();
		$store_in_street = array();
		//拿到商圈下商场的id
		$a = $this->ci_get(T_MALL,array("district"=>$district_id),array('id'));
		
		//如果商圈下有商场
		if($a){
			//拿到商场下的楼层
			$mall_id = array();
			foreach ($a as $value){
				$mall_id[] = $value['id'];
			}
			$mall_id_str = join(',', $mall_id);
			$sql = "select id from ".T_MALL_FLOOR." where mall_id in (".$mall_id_str.")";
			$a = $this->ci_query($sql);
			//如果商场下有楼层
			if($a){
				//拿到楼层下商铺
				$mall_floor_id = array();
				foreach ($a as $value){
					$mall_floor_id[] = $value['id'];
				}
				$mall_floor_id_str = join(',', $mall_floor_id);
				$sql = "select id from ".T_STORE." where mall_floor_id in (".$mall_floor_id_str.")";
				$a = $this->ci_query($sql);
				//如果楼层下有商铺
				if($a){
					foreach ($a as $value){
						$store_in_mall[] = $value['id'];
					}
				}
			}
		}
		
		//拿到商圈下的街道
		$a = $this->ci_get(T_STREET,array('district_id'=>$district_id),array('id'));
		//如果该商圈下有街道
		if($a){
			$street_id = array();
			foreach ($a as $value){
				$street_id[] = $value['id'];
			}
			$street_id_str = join(',', $street_id);
			$sql = "select id from ".T_STORE." where street_id in (".$street_id_str.")";
			$a = $this->ci_query($sql);
			//如果街道下有商铺
			if($a){
				foreach ($a as $value){
					$store_in_street[] = $value['id'];
				}
			}
		}
		$store = array_merge($store_in_mall,$store_in_street);
		if($store){
			return $store;
		}
		return false;
	}
}






