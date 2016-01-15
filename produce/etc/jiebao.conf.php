<?php
/*網站的路徑*/

//整個jiebao系統(web ,api ,admin)的根路徑
define('ROOTPATH',dirname(__FILE__).'/../');

//web路徑
define('WEBPATH',ROOTPATH.'web/');

//etc路徑
define('ETCPATH',ROOTPATH.'etc/');

//admin路徑
define('ADMINPATH',ROOTPATH.'admin/');

//api 路徑
define('APIPATH',ROOTPATH.'api/');

//static path
define("STATICPATH",ROOTPATH."static/");

define("ADMIN_IMG_PATH",ADMINPATH.'static/img/');

//定义微信 TOKEN
define("WEIXIN_TOKEN", "kanjiebao");

//数据库的表名
define('T_EVENT','event');									//活动表
define('T_STORE', 'store');									//商铺表
define("T_STORE_ACCOUNT", "store_account");					//商铺账号表
define("T_STORE_SESSION", "store_session");					//商铺账号登录session 表
define('T_BRAND', 'brand');									//品牌表
define("T_STORE_PRODUCT_LIB", "store_product_lib");			//商铺商品库
define('T_DISTRICT', 'district');							//商圈表
define('T_MALL', 'mall');									//商场表
define('T_MALL_FLOOR', 'mall_floor');						//商场层表
define('T_STREET','street');								//商业街表
define('T_PRODUCT', 'product');								//商品表
define('T_USER', 'user');									//用户表
define('T_USER_LIKE', 'user_like');							//用户收藏列表
define('T_USER_SESSION', 'user_session');					//用户 session 表
define("T_USER_TUCAO", "user_tucao");						//用户吐槽表
define('T_CITY', 'city');									//城市表
define('T_MALL_AD', "mall_ad");								//商场广告表
define("T_USER_COMMENT", "user_comment");					//用户评论表
define("T_PRODUCT_DETAIL","product_detail");				//商品详情表
define("T_USRE_REGISTER_VERIFY", "user_register_verify");	//用户短信验证表
define("T_EMPLOYEE", "employee");							//管理员工表
define("T_EMPLOYEE_SESSION","employee_session");			//管理员工登录　session 　表


//街报的一些平常的配置
//品类配置
$CATEGORY = array(
		1 => "上衣",
		2 => "裤子",
		3 => "内衣",
		4 => "配饰",
		5 => "箱包",
		6 => "鞋子",
		7 => "运动户外",
		8 => "裙子",
		9 => "套装",
		
);

//风格配置
$STYLE = array(
		1 => "学院",
		2 => "欧美",
		3 => "日韩",
		4 => "民族",
		5 => "休闲",
		6 => "户外",
		7 => "运动",
		8 => "简约",
		9 => "复古",
		10 =>"街头",
		11 =>"森系",
		12 =>"商务"
);

//性别分类
$SEX = array(
		1 => "男装",
		2 => "女装"
);

//引入其他配置和公共类
foreach (glob(ETCPATH.'*') as $file) {
	require_once $file;
}
/*the end of the file :/var/www/html/jiebao/develop/etc/jiebao.conf.php*/






