<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Product extends JB_Controller {
	public function __construct() {
		parent::__construct ();
	}
	/*
	 * @desc 商品详情
	 * @
	 */
	public function detail() {
		$must = array (
				'product_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do {
			$this->Table_model->init ( T_PRODUCT );
			$res = $this->Table_model->record_one ( array (
					'id' => $product_id
			) );
			if ($res) {
				$res ['product_photos'] = json_decode ( $res ['product_photos'] );
				$this->st ( $res, '获取商品详情成功' );
			}
		} while ( 0 );
		$this->op ();
	}
	
	/*
	 * @desc 往商铺的商品库里添加商品
	 * @desc 这个接口暂时只有　store 端用的上吧。。。。。
	 * 　store_session	商铺登录session
		name varchar(255) 否 商品名称
		photo varchar(255) 否 商品展示图
		detail_photo varchar(1000) 否 商品轮播图
		category tinyint(1) 否 商品种类
		price float 否 商品原价
		desc_cirbe text 否 商品描述
		size varchar(50) 否 商品尺寸/规格
		color varchar(50) 否 色系
		stock int(10) 否 商品库存
	 */
	public function store_product_add() {
		$must = array (
				'name',
				'photo',
				'detail_photo',
				'category',
				'price',
				'desc_cirbe',
				'size',
				'color',
				'stock'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		$this->check_store_session ();
		extract ( $this->params );
		do {
			$store_product_info = array (
					'name'=>$name,
					'photo'=>$photo,
					'detail_photo'=>json_encode($detail_photo),
					'category'=>json_encode($category),
					'price'=>$price,
					'desc_cirbe'=>$desc_cirbe,
					'size'=>$size,
					'color'=>$color,
					'stock'=>$stock,
					'store_id'=>$this->store_info['store_id']
			);
			$this->Table_model->init(T_STORE_PRODUCT_LIB);
			$res = $this->Table_model->records_add($store_product_info);
			if($res['err_num'] == 0){
				$this->st(array(),"添加商品成功!");break;
			}
			$this->st(array(),"添加商品失败",API_NORMAL_ERR);
		} while ( 0 );
		$this->op ();
	}
	
	
	//修改商品
	public function edit(){
		$must = array (
				'product_id'
		);
		$this->check_param ( $must );
		$this->check_sign ();
		extract ( $this->params );
		do{
			/*
			 *
			 *********************params*************************
			 array (
			 'product_id' => '31',
			 'product_name' => '优雅女士圆头靴子',
			 'price' => '369',
			 'promote_price' => '232',
			 'product_desc' => 'OL秦岚田馥甄瞿颖同款西遇女鞋木林森优雅女士圆头靴子',
			 'photo' => 'false',
			 'product_cate' => '6',
			 )
			 **********************params*************************
			 * */
			$product_info = array(
				'name' => $product_name,
				'price'=>$price,
				'cate_id_str'=>$product_cate,	
				'promote_price'=>$promote_price,
				'product_desc'=>$product_desc,
			);
			if(isset($photo)&&!empty($photo)){
				$product_info['photo'] = $photo[0];
			}
			if(isset($product_photos)&&!empty($product_photos)){
				$product_info['product_photos'] = json_encode($product_photos);
			}
			$this->Base_model->ci_update(T_PRODUCT,array('id'=>$product_id),$product_info);
			$this->st();
		}while(0);
		$this->op();
		
	}
	
	
	
	
}
