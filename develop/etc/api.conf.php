<?php
//api key
define("APIKEY", 'jiebao_123456');
//api 白名单
$api_map = array(
		'/test/test',						//测试接口
		
		'/user/register',					//用户注册接口
		'/user/login',						//用户登录接口
		'/user/detail',						//用户详情接口
		'/user/modify_pwd',					//用户修改密码接口
		'/user/like_event',					//用户收藏一个活动接口
		'/user/event_lists',				//用户收藏活动列表接口
		'/user/check_like',					//检查用户是否喜欢某个活动接口
		'/user/comment_add',				//添加用户评论接口
		'/user/logout',						//用户登出接口
		'/user/cancel_event',				//取消收藏活动接口
		'/user/msg_verify',					//短信验证接口
		'/user/find_pwd',					//用户找回密码接口
		'/user/tucao',						//用户吐槽接口
		'/user/lists',						//用户列表
		'/user/want_go_list',				//想去的地方的列表
		'/user/tocao_list',					//用户吐槽列表
		'/user/login_list',					//用户登录列表
		'/user/user_street_time',			//用户最佳逛街时间
		'/user/users_num',					//用户总数
		
		
		'/brand/add',						//添加品牌接口
		'/brand/lists',						//品牌列表接口
		'/brand/style_list',				//品牌风格列表接口
		'/brand/detail',					//品牌详情接口
		'/brand/update',					//修改品牌接口
		'/brand/search',					//查询是否有这个品牌
		'/brand/del',						//删除一个品牌
		
		'/city/lists',						//城市列表接口
		
		'/district/lists',					//商圈列表接口
		'/district/un_develop',				//不开发商圈
		'/district/develop',				//开发商圈
		'/district/add',					//添加商圈
		'/district/del',					//删除商圈
		'/district/detail',					//商圈详情
		'/district/edit',					//编辑商圈
		
		'/mall/lists',						//商场列表接口
		'/mall/detail',						//商场详情接口
		'/mall/add',						//添加商场
		'/mall/del',						//删除一个商场
		'/mall/edit',						//编辑商场
		
		
		'/mall_floor/lists',				//商场层数接口
		'/mall_floor/add',					//添加商场层数接口
		'/mall_floor/del',					//删除商场楼层接口
		'/mall_floor/detail',				//商场楼层详情接口
		'/mall_floor/edit',					//商场楼层编辑接口
		
		'/street/lists',					//商业街列表接口
		'/street/add',						//添加商业街接口
		'/street/detail',					//商业街道详情接口(未开发)
		'/street/del',						//删除街道
		
		'/store/lists',						//商铺列表接口
		'/store/detail',					//商铺详情接口
		'/store/add',						//添加商铺接口
		'/store/add_verify_code',			//生成商铺注册码接口
		'/store/register',					//用户通过验证码注册的接口
		'/store/login',						//商铺账号登录的接口
		'/store/category_list',				//商铺经营品类接口
		'/store/del',						//删除一家商铺
		'/store/update',					//更新商铺
		'/store/edit',						//编辑商铺
		
		
		'/event/lists',						//活动列表接口
		'/event/lists2',					//正在开发的活动列表
		'/event/detail',					//活动详情接口
		'/event/add',						//活动添加接口
		'/event/product_add',				//添加活动商品
		'/event/publish',					//发布一个活动接口
		'/event/cancel_publish',			//取消发布一个活动接口
		'/event/del',						//删除一个活动接口
		'/event/delete_product',			//删除活动商品接口
		'/event/edit',						//修改活动信息接口
		
		
		'/msg/send',						//发送短信接口
		
		'/ad/mall_ad_add',					//给商场添加广告接口
		'/ad/mall_ad_lists',				//商场广告接口
		'/ad/mall_ad_del',					//删除广告接口
				
		'/product/detail',					//商品详细
		'/product/store_product_add',		//给商铺的商品库添加商品的接口
		'/product/edit',					//编辑商品
				
		'/employee/login',					//员工登录接口
		'/employee/logout',					//员工登出接口
		'/employee/is_login',				//判断员工是否登录接口
		'/employee/lists',					//员工列表
		'/employee/add',					//添加一个管理员
		'/employee/employee_login_list',	//员工登录列表
		'/employee/del',					//删除一个员工
		'/employee/detail',					//拿到员功工详情
		'/employee/edit',					//编辑员工
		
		
		'/Statistics/all_district',			//得到所有商圈
		'/Statistics/all_mall',				//得到所有商场
		'/Statistics/all_store',			//得到所有商铺
		'/Statistics/all_event',			//得到所有活动
		
		
		
		
		
);

//系统接口错误格式　　:   1xxx   ;
define('API_SUCCESS',0000);									//请求成功代码
define('API_PARAM_ERR',1000);								//参数验证失败
define('API_SIGN_ERR',1001);								//签名校验失败
define('API_DB_ERR',1002);									//数据库错误
define('API_URL_ERR',1003);									//访问不允许访问的接口
define("API_MAP_ERR",1004);									//api 白名单错误



//跟用户有关的接口错误返回代码格式　:  8xxx ;
define("API_PHONE_REGISTERED",8001);						//手机号已经被注册
define("API_SESSION_ERR",8002);								//用户　session 错误
define("API_REGISTER_VERIFY_CODE_ERR",8003);				//用户注册验证码错误
define("API_PWD_ERR",8004);									//用户密码错误
define("API_PWD_FORMAT_ERR",8005);							//密码格式错误
define("API_PWD_DIFF_ERR",8006);							//用户两次输入密码对不上
define("API_PWD_MODIFY_ERR",8007);							//更新用户密码失败
define("API_USER_ERR",8008);								//广义上的用户错误
define("API_PWD_SAME_ERR",8009);							//两次输入密码不一致错误

//平常普通的错误
define("API_NORMAL_ERR",9000);								//，或者判断正确　与　错误时　，表示错误的一方



//未知错误
define('API_UNKNOW_ERR',9999);

























