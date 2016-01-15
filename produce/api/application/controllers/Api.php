<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	//测试 ci 的用例
	public function test(){
		$must = array();
		$res = get_api_data('test/test',$must);op($res);
	}
	/*
	 * @desc	用户注册接口
	 * @desc	用户注册/登录后,后台api返回一个session字段，把这个值存cookie,要访问用户数据时，均需要传该值
	 * @date	Sun Sep 13 10:37:22 CST 2015
	 * */
	public function user_register(){
		$must = array("phone"=>"18101361802","pwd"=>"951010","re_pwd"=>"951010",'verify_code'=>'124932');
		$res = get_api_data('user/register',$must);op($res);
	}
	/*
	 * @desc	用户登录接口
	 * @date    Sun Sep 13 10:37:22 CST 2015
	 * */
	public function user_login(){
		$must = array("phone"=>"18911938192","pwd"=>md5("cky951010"));
		$res = get_api_data('user/login',$must);op($res);
	}
	/*
	 *@desc		用户详情接口
	 *@date    Sun Sep 13 10:37:22 CST 2015
	 * */
	public function user_detail(){
		$must = array("session"=>"64bd3b47fc4a1b715c214eac85f3bfd2");
		$res = get_api_data('user/detail',$must);op($res);
	}
	/*
	 * @desc	已经登录用户修改密码
	 * @date    Tue Sep 15 12:33:12 CST 2015
	 * */
	public function user_up_pass(){
		$must = array("session"=>"73c123a4355b189945128b8236e10fa0",'new_pwd'=>"951010","new_pwd_re"=>"951010");
		$res = get_api_data('user/modify_pwd',$must);op($res);
	}
	/*
	 *@desc		未登录用户找回密码
	 *@date		Sun Sep 13 14:08:40 CST 2015
	 * */
	public function user_find_pwd(){
		$must = array("phone"=>"18911938192",'new_pwd'=>"cky951010",'re_new_pwd'=>"cky951010",'verify_code'=>'228323');
		$res = get_api_data('user/find_pwd',$must);op($res);
	}
	
	/*
	 * @desc	用户收藏一个活动接口
	 * @date	 Tue Sep 15 12:33:12 CST 2015
	 * */
	public function user_add_event(){
		$must = array('session'=>'7e4224fe30b35a9053a25ff7a6f92a3b','event_id'=>14);
		$res = get_api_data('user/like_event',$must);op($res);
	}
	/*
	 *@desc	 用户取消一个收藏活动接口
	 *@date  Thu Sep 10 14:56:15 CST 2015
	 * */
	public function user_cancel_event(){
		$must = array('session'=>'91964fe46dd5d132440784b4a7d38262','event_id'=>29);
		$res = get_api_data('user/cancel_event',$must);op($res);
	}
	
	/*
	 *@desc		用户收藏活动列表接口
	 * */
	public function user_event_list(){
		$must = array('session'=>'1c77e8d6ad1b69eca13d2856160234d0');//可选参数　: page_size :每页显示几个
		$res = get_api_data('user/event_lists',$must);op($res);
	}
	
	/*
	 *@desc		查看用户是否收藏某活动接口
	 * */
	public function event_check_like(){
		$must = array('session'=>'7e4224fe30b35a9053a25ff7a6f92a3b','event_id'=>14);
		$res = get_api_data('user/check_like',$must);op($res);
	}
	
	/*
	 *@desc		用户添加品论接口，应该是对应 ，收集用户想要去哪些商圈的需求
	 *@param	user_name    选传   可以记录下用户名字
	 *@param	user_info    选传	可以记录下用户联系方式
	 *@date     Tue Sep  8 02:31:30 CST 2015
	 * */
	public function user_comment_add(){
		$must = array('comment'=>"额额");
	}
	/*
	 *@desc   用户退出接口
	 * */
	public function user_logout(){
		$must = array('session'=>"fb2faf4a218ebefacf7d3f78ffe9614d");
		$res = get_api_data('user/logout',$must);op($res);
	}
	/*
	 *@desc	  用户注册验证码接口
	 * */
	public function msg_verify(){
		$must = array('phone'=>"18101361802");
		$res = get_api_data('user/msg_verify',$must);op($res);
	}
	
		
	/*
	 * @desc	用户吐槽接口
	 * @param	可选		user_name   吐槽用户名
	 * @date	２０１５－０９－１８　０８：５４：１５
	 * */
	public function user_tucao(){
		$must = array('user_tucao'=>"呵呵呵呵。。。。");
		$res = get_api_data('user/tucao',$must);op($res);
	}
	
	
	/*
	 * @desc	用户列表接口
	 * */
	public function user_list(){
		$must = array();
		$res = get_api_data('user/lists',$must);op($res);
	}
	
	/*
	 * @desc	用户总数
	 * */
	public function users_num(){
		$must = array();
		$res = get_api_data('user/users_num',$must);op($res);
	}
	
	/*
	 * @desc	用户想去哪儿列表接口
	 * */
	
	public function user_want_go_list(){
		$must = array();
		$res = get_api_data('user/want_go_list',$must);op($res);
	}
	
	
	/*
	 * @desc	用户吐槽列表
	 * */
	public function tocao_list(){
		$must = array();
		$res = get_api_data('user/tocao_list',$must);op($res);
	}
	
	/*
	 * @desc	用户吐槽列表
	 * */
	public function login_list(){
		$must = array();
		$res = get_api_data('user/login_list',$must);op($res);
	}
	
	/*
	 * @desc	用户最佳逛街时间
	 * */
	public function user_street_time(){
		$must = array('session'=>'1c77e8d6ad1b69eca13d2856160234d0');
		$res = get_api_data('user/user_street_time',$must);op($res);
	}
	
	
	
	
	
	
	/*
	 * @desc	品牌列表
	 * */
	public function brand_list(){
		$must = array('page_now'=>2,'search_key'=>"优衣库");
		$res = get_api_data('brand/lists',$must);
		op($res);
	}
	
	/*
	 *@desc	brand_style_list	 商品风格列表接口
	 *@date	2015年 09月 21日 星期一 10:40:17 CST
	 * */
	public function brand_style_list(){
		$must = array();
		$res = get_api_data('brand/style_list',$must);
		op($res);
	}
	
	/*
	 * @desc	品牌详情接口
	 * */
	public function brand_detail(){
		$must = array('brand_id'=>30);
		$res = get_api_data('brand/detail',$must);
		op($res);
	}
	
	/*
	 * @desc	查询是否有此品牌
	 * */
	public function brand_search(){
		$must = array('brand_name'=>"优衣库");
		$res = get_api_data('brand/search',$must);
		op($res);
	}
	
	
	/*
	 * @desc	编辑品牌的的接口
	 * */
	public function brand_update(){
		$must = array('brand_id'=>30,
					  "brand_photo"=>"http://admin.jiebao.com/static/img/1509/zF4WZhU01443001427.jpg",
				      "brand_style"=>array(1,2,3),
				      "brand_name"=>"heheh");
		$res = get_api_data('brand/update',$must);
		op($res);
	}
	/*
	 * @desc	城市模块　　api  文档　＋　测试用例
	 * */
	public function city_list(){
		$must = array('province'=>'北京','page_now'=>1);//可选参数　: 'page_size'=>1000
		$res = get_api_data('city/lists',$must);
		op($res);
	}
	/*
	 * @desc	商圈列表接口
	 * @param	'Longitude'=>116.3127671705  经度
	 * @param	'Latitude'=>39.9813386328    纬度
	 * */
	
	/*
	 * @desc	所有商圈
	 * */
	public function all_district(){
		$must = array();
		$res = get_api_data('Statistics/all_district',$must);
		op($res);
	}
	/*
	 * @desc	所有商场
	 * */
	public function all_mall(){
		$must = array();
		$res = get_api_data('Statistics/all_mall',$must);
		op($res);
	}
	/*
	 * @desc	所有商场
	 * */
	public function all_store(){
		$must = array();
		$res = get_api_data('Statistics/all_store',$must);
		op($res);
	}
	/*
	 * @desc	所有活动
	 * */
	public function all_event(){
		$must = array();
		$res = get_api_data('Statistics/all_event',$must);
		op($res);
	}
	
	
	
	public function district_list(){
// 		$must = array('Longitude'=>116.3127671705,'Latitude'=>39.9813386328);
		$must = array('Longitude'=>'','Latitude'=>'');
		$res = get_api_data('district/lists',$must);op($res);
	}
	
	/*
	 * @desc	商圈详情
	 * */
	public function district_detail(){
		$must = array('district_id'=>1);
		$res = get_api_data('district/detail',$must);op($res);
	}
	
	
	/*  商场模块	api  文档　＋　测试用例　*/
	/*
	 *@desc 商场列表接口
	 *@param	page_now		必填参数
	 *@param	district_id 	可选参数   查询某商圈下商场,不填默认查询全部商场
	 *@param	page_size       可选参数   每页大小,默认 10
	 * */
	public function mall_list(){
		$must = array('page_now'=>1);
		$res = get_api_data('mall/lists',$must);
		op($res);
	}
	/*
	 * @desc 	根据商场id 查楼层
	 * @desc	15-09-09
	 * */
	public function mall_floor_list(){
		$must = array('mall_id'=>2);
		$res = get_api_data('mall_floor/lists',$must);
		op($res);
	}
	
	/*
	 * @desc	商场楼层接口
	 * @date	2015-10-19 09:44:24
	 * */
	public function mall_floor_detail(){
		$must = array('floor_id'=>23);
		$res = get_api_data('mall_floor/detail',$must);
		op($res);
	}

	
	
	/*
	 * @desc 	根据商场id 查广告列表
	 * @desc	15-09-06
	 * */
	public function mall_ad_lists(){
		$must = array('mall_id'=>7);
		$res = get_api_data('ad/mall_ad_lists',$must);
		op($res);
	}
	/*
	 * @desc	商业街模块		api  文档　＋　测试用例
	 *　@desc	根据商圈id 查商业街
	 * @date	15-09-04
	 * */
	public function street_list(){
		$must = array('district_id'=>'1','page_now'=>1);//可选参数　: 'page_size'=>10
		$res = get_api_data('street/lists',$must);
		op($res);
	}
	/*
	 * @desc	商铺列表接口
	 * @desc	可选参数 'street_id' 与　mall_floor_id 二选一,分别查询　商业街下，和商场楼层下的商铺
	 * @date	15-09-04
	 * @date	2015-10-16 16:40:50    接口返回的数据有变化，请查看下
	 * */
	public function store_list(){
//		$must = array('search_key'=>"优衣库");
		$must = array('mall_floor_id'=>"23");
		$res = get_api_data('store/lists',$must);op($res);
	}
	/*
	 *@desc		创建商铺验证码接口
	 * */
	public function store_add_verify_code(){
		$must = array('store_id'=>1);
		$res = get_api_data('store/add_verify_code',$must);op($res);
	}
	/*
	 *@desc	    验证商铺id  快速注册的接口
	 * */
	public function store_register(){
		$must = array('verify_code'=>'U52LROVUW05H7X8T',
				'account'=>'caokaiyan',
				'pwd'=>'cky951010',
				're_pwd'=>'cky951010',);
		$res = get_api_data('store/register',$must);op($res);
	}
	/*
	 *@desc		商铺账号登录接口
	 *@date     2015年 09月 20日 星期日 12:02:17 CST
	 * */
	public function store_login(){
		$must = array (
						'store_account'=>'caokaiyan',
						'pwd'=>'cky951010',
				);
		$res = get_api_data('store/login',$must);op($res);
	}
	
	/*
	 *@desc	   商铺详情接口
	 *@date	   2015-10-16 16:40:11  接口返回的数据字段有变化
	 * */
	public function store_detail(){
		$must = array('store_id'=>36);
		$res = get_api_data('store/detail',$must);op($res);
	}
	
	/*
	 *@desc	store_category_list 接口，返回商铺可选的风格列表!
	 *@date	2015年 09月 21日 星期一 10:40:17 CST
	 * */
	public function store_category_list (){
		$must = array();
		$res = get_api_data('store/category_list',$must);
		op($res);
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
	public function store_product_add (){
		$must = array (
				'store_session'=>'98e46e509c9e885b0fec74679fe190af',
				'name'=>"测试添加商品",
				'photo'=>"http://admindev.kanjiebao.com/static/img/1509/q1l8JZzL1441858999.jpg",
				'detail_photo'=>array(
						"http://admindev.kanjiebao.com/static/img/1509/q1l8JZzL1441858999.jpg",
						"http://admindev.kanjiebao.com/static/img/1509/q1l8JZzL1441858999.jpg"
				),
				'category'=>array(
						1,
						3,
						7
				),
				'price'=>100,
				'desc_cirbe'=>"我觉得对这件商品没什么可说的!",
				'size'=>3,
				'color'=>2,
				'stock'=>263
		);
		$res = get_api_data('product/store_product_add',$must);
		op($res);
	}
	
	/*
	 *@desc		活动列表接口
	 *@desc		活动列表接口，重要，而且是最复杂的一个接口
	 *@desc     所有的值都是选传，不是必传
	 *@params   page_size     分页大小
	 *@params	page_now      当前页
	 *@params   cate_id_str   查询某个品类的活动
	 *@params	style_id_str  查询活动的风格条件
	 *@params	expired		  连过期的一起获取　　取值　true
	 *@params	is_publised   是否获取没发布的活动　取值 true
	 *@params   is_del		  是否获取已经删除的活动　取值　true
	 *@params	store_id	  商铺id  ，用于查询某一商铺下的活动
	 *@params   mall_floor_id 商场楼层id ,用于查询某一商场楼层下的所有活动
	 *@params	mall_id		  商场id ,用于查询某一商场下的所有活动
	 *@params   district_id   商圈id ,用于查询某一商圈下所有活动
	 *@params   longitude  　　　经度，latitude 维度，用于查询该位置附近的商圈的所有活动
	 * */
	public function event_list(){
		//$must = array('page_now'=>1, 'page_size'=>2, 'mall_floor_id' => 14,'cate_id_str'=>1,'style_id_str'=>2,'expired'=>true,'is_publised'=>true);
		
		//$must = array('district_id' => 1,'expired'=>true,'is_publised'=>true,'is_del'=>true);
		
		//查询某个商铺下活动列表
// 		$must = array(
// // 				'longitude' => '116.3392167801',
// // 				'latitude'=>'39.9925994873',
// 				'expired'=>true,
// 				'is_publised'=>true,
// 				'is_del'=>true,
// 				'store_id'=>37
// 		);
		
		//查询某个商场楼层下的活动
// 		$must = array(
// 				'expired'=>true,
// 				'is_publised'=>true,
// 				'is_del'=>true,
// 				'mall_floor_id'=>8
// 		);
		
		//查询某个商场下的活动
// 		$must = array(
// 				'expired'=>true,
// 				'is_publised'=>true,
// 				'is_del'=>true,
// 				'mall_id'=>5
// 		);

		//查询某个商圈下的活动
// 		$must = array(
// 				'expired'=>true,
// 				'is_publised'=>true,
// 				'is_del'=>true,
// 				'district_id'=>1
// 		);
		
		//查询某个地理位置附近的商圈下的活动列表
		$must = array(
				'longitude' => '116.3392167801',
				'latitude'=>'39.9925994873',
				'expired'=>false,
				'is_publised'=>true,
				'is_del'=>true,
		);
		
		$res = get_api_data('event/lists2',$must);op($res);
	}
	
	/*
	 * @desc	活动详情接口
	 * */
	public function event_detail(){
		$must = array('event_id'=>14);
		$res = get_api_data('event/detail',$must);op($res);
	}
	
	/*
	 *@desc		发布一个活动接口
	 *@date		Sat Sep 19 14:08:59 CST 2015
	 * */
	public function event_publish(){
		$must = array('event_id'=>16);
		$res = get_api_data('event/publish',$must);op($res);
	}
	
	/*
	 *@desc		取消发布一个活动接口
	 *@date		Sat Sep 19 14:08:59 CST 2015
	 * */
	public function event_cancel_publish(){
		$must = array('event_id'=>16);
		$res = get_api_data('event/cancel_publish',$must);op($res);
	}
	
	/*
	 *@desc		删除一个活动接口
	 *@date		Sat Sep 19 14:08:59 CST 2015
	 * */
	public function event_del(){
		$must = array('event_id'=>16);
		$res = get_api_data('event/del',$must);op($res);
	}
	
	/*
	 *@desc		活动商品详情接口
	 * */
	public function product_detail(){
		$must = array('product_id'=>14);
		$res = get_api_data('product/detail',$must);op($res);
	}
	
	/*
	 *@desc		员工登录接口
	 * */
	public function employee_login(){
		$must = array('account'=>"root",'pwd'=>"jiebao2015");
		$res = get_api_data('employee/login',$must);op($res);
	}
	/*
	 * @desc	管理员列表
	 * */	
	public function employee_list(){
		$must = array();
		$res = get_api_data('employee/lists',$must);op($res);
	}
	/*
	 * @desc	添加一管理员
	 * */
	public function employee_add(){
		$must = array('admin_name'=>"zhangjian",'admin_pwd'=>'951010');
		$res = get_api_data('employee/add',$must);op($res);
	}
	
	/*
	 * @desc	用户是否登录的接口
	 * */
	public function employee_is_login(){
		$must = array('session'=>'6645b0813f4b9c7135457090723dc31b');
		$res = get_api_data('employee/is_login',$must);op($res);
	}
	
	
	
	
	/*
	 * 测试新短信运营商
	 * 
	 * */
	public function test_new_msg(){
		$url = "http://222.73.117.158/msg/HttpBatchSendSM?account=jiekou-clcs-16&pswd=Xch123456&mobile=18101361802&msg=您好，您的验证码是123456&needstatus=true";
		$a = file_get_contents($url);
	}
	
	
	
	
	
	
}











