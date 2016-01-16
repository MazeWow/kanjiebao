<?php
//判断是否是 json 格式的字符串
function is_json($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}
/*
 * @desc  返回一个 array('err_no'=>0,'err_msg'=>'message','results'=>array()); 格式的数组
 * */
function return_format($res = array(),$msg = "success!",$num = 0){
	return array('err_num'=>$num,'err_msg'=>$msg,'results'=>$res);
}
/*
 * @desc  格式化输出的浏览器，用于调试
 * @author caokaiyan
 * */
function op($param){
	echo "<pre>";
		print_r($param);
	echo "</pre>";
	return 0;
}
//封装　curl , 用于发送　带　post 的　http 请求
function send_request( $url, $params=array(), $header=array() ){
	$ch = curl_init();
	$res= curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	if( isset($_SERVER['HTTP_USER_AGENT']) ){
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	}
	if( $params ){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	}
	if( $header ){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	}
	$result = curl_exec ($ch);
	curl_close($ch);
	if ($result == NULL) {
		return false;
	}
	return $result;
}

/*
 * @desc 签名加密函数
 * */
function encrypt($arr){
	ksort($arr);
	return @md5(md5(implode('',$arr)).APIKEY);
}

/*
 * @desc 获取　api 数据函数
 * */
function get_api_data($url,$param = array()){
	$url = API_URL.$url;
	$sign = encrypt($param);
	$param['sign'] = $sign;
	$api_str = send_request($url,$param);
	if(is_json($api_str)){
		return json_decode($api_str,TRUE);
	}else{
		return return_format(array($api_str),"json_str 解析错误,这是api内部报错！请联系1162097842@qq.com",API_NORMAL_ERR);
	}
}

function object_to_array($obj)
{
	$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
	foreach ($_arr as $key => $val)
	{
		$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
		$arr[$key] = $val;
	}
	return $arr;
}

/*
 * @desc 创建一定范围内的随机字符
 * @param $length 字符串长度
 * @param $chars 字符范围
 * @return $rand_str 随机字符串
 * @author  caokaiyan
 * */
function rand_str($length = '4',$chars = '')
{
	if('' == $chars){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	}
	$rand_str = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		$rand_str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $rand_str;
}

/*
 * @desc 将变量打印到指定目录的文本
 * @param  $param 变量　　$str　变量名字　　$path  文本路径
 * @return 0
 * @author  caokaiyan
 * */
function debug($param,$str="value",$path = '/var/www/jiebao/develop/api/debug.php'){
	$star = "\n**********************$str*************************\n";
	file_put_contents($path, $star,FILE_APPEND);
	file_put_contents($path,var_export($param,true),FILE_APPEND);
	file_put_contents($path, $star."\n\n",FILE_APPEND);
	return 0;
}


/*
 * @分页函数
 * @param		$total		总记录数
 * @param		$page_now	当前页码
 * @param		$page_size	一页的记录条数
 * @param		$pages		显示的最大页码数
 * */
function paging($total,$page_now = 1,$page_size = 8,$pages = 6){
	$return['total_pages'] 	= 	ceil($total/$page_size);//总页数
	$return['pre_page']		=	($page_now>1)?$page_now-1:1;//前一页数
	$return['next_page'] 	=	($page_now<$return['total_pages'])?$page_now+1:$return['total_pages'];//下一页
	$return['page_now']		=	$page_now;//当前页面

	//生成页码 : 小于设定的最大页码数　｜　大于设定的最大的页码数
	if($pages>=$return['total_pages']){
		for ($p = 1;$p<=$return['total_pages'];$p++){
			$return['pages'][] = $p;
		}
	}else{
		//如果　page_now 太小了的话
		if($page_now<=$pages/2){
			for ($p = 1;$p<=$pages;$p++){
				$return['pages'][] = $p;
			}
		}
		//如果page_now 接近总页数了
		elseif($return['total_pages']-$page_now<=$pages/2){
			for ($a = 1,$p=$return['total_pages'];$a<=$pages;$p--,$a++){
				$return['pages'][] = $p;
			}
			sort($return['pages']);
		}
		//page_now 在页码中间
		else{
			//处理奇数页时，一个向上取整，一个去除小数
			for ($p = $page_now -intval($pages/2);$p<$page_now+ceil($pages/2);$p++){
				$return['pages'][] = $p;
			}
		}
	}
	return $return;
}

/*
 * @desc	给用户密码加密的函数
 * */
function pass_encrypt($pass){
	return md5(md5($pass.'pass'));
}

/*
 * @desc	给　session 加密的函数
 * */
function session_encrypt($session){
	return md5($session.'session'.time());
}

/**
 * Send a GET requst using cURL
 * @param string $url to request
 * @param array $get values to send
 * @param array $options for cURL
 * @return string
 */
function curl_get($url, array $get = NULL, array $options = array())
{
	$defaults = array(
			CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : '').http_build_query($get),
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 4
	);
	$ch = curl_init();
	curl_setopt_array($ch, ($options + $defaults));
	if( ! $result = curl_exec($ch))
	{
		trigger_error(curl_error($ch));
	}
	curl_close($ch);
	return $result;
}
	/*
	 * @desc	发送短信函数
	 * */
	 function SMS_send($phone,$contents){
		$data = array (
				'cpid' => "jiexiangkeji",
				'cppwd' => "111111/*-",
				'phone' => $phone,
				'msgcont' => $contents
		);
		$query_str = '';
		foreach ($data as $key => $value){
			$query_str .=rawurlencode(iconv('UTF-8', 'GB2312',$key)).'='.rawurlencode(iconv('UTF-8', 'GB2312',$value)).'&';
		}
		$url = "http://3g.3gxcm.com/sms/push_mt.jsp?".$query_str;
// 		debug($url,'url');	//调试url查询是否正确
		$html = file_get_contents($url);
// 		debug($html,'html');	//调试返回结果是否正确
		return $html;
	}

	/**
	 *  @desc 根据两点间的经纬度计算距离
	 *  @param float $lat 纬度值
	 *  @param float $lng 经度值
	 *  @param http://www.nhc.noaa.gov/gccalc.shtml  在线测试的一个网址
	 */
	function getDistance($lat1, $lng1, $lat2, $lng2)
	{
		$earthRadius = 6367000; //approximate radius of earth in meters
	
		/*
		 Convert these degrees to radians
		 to work with the formula
		 */
	
		$lat1 = ($lat1 * pi() ) / 180;
		$lng1 = ($lng1 * pi() ) / 180;
	
		$lat2 = ($lat2 * pi() ) / 180;
		$lng2 = ($lng2 * pi() ) / 180;
	
		/*
		 Using the
		 Haversine formula
	
		 http://en.wikipedia.org/wiki/Haversine_formula
		
		 calculate the distance
		 */
	
		$calcLongitude = $lng2 - $lng1;
		$calcLatitude = $lat2 - $lat1;
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
		$calculatedDistance = $earthRadius * $stepTwo;
	
		return round($calculatedDistance);
	}
	
	//检查字符串
	function CheckSubstrs($substrs,$text){
		foreach($substrs as $substr){
			if(false!==strpos($text,$substr)){
				return true;
			}
		}
		return false;
	}
	
	//判断是否是 手机
	function is_mobile(){
		$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$useragent_commentsblock = preg_match('|\(.*?\)|',$useragent,$matches)>0 ? $matches[0] : '';
		$mobile_os_list = array(
				'Google Wireless Transcoder',
				'Windows CE',
				'WindowsCE',
				'Symbian',
				'Android',
				'armv6l',
				'armv5',
				'Mobile',
				'CentOS',
				'mowser',
				'AvantGo',
				'Opera Mobi',
				'J2ME/MIDP',
				'Smartphone',
				'Go.Web',
				'Palm',
				'iPAQ',
		);
		$mobile_token_list = array(
				'Profile/MIDP',
				'Configuration/CLDC-',
				'160×160',
				'176×220',
				'240×240',
				'240×320',
				'320×240',
				'UP.Browser',
				'UP.Link',
				'SymbianOS',
				'PalmOS',
				'PocketPC',
				'SonyEricsson',
				'Nokia',
				'BlackBerry',
				'Vodafone',
				'BenQ',
				'Novarra-Vision',
				'Iris',
				'NetFront',
				'HTC_',
				'Xda_',
				'SAMSUNG-SGH',
				'Wapaka',
				'DoCoMo',
				'iPhone',
				'iPod',
		);
		$found_mobile = CheckSubstrs($mobile_os_list,$useragent_commentsblock) || CheckSubstrs($mobile_token_list,$useragent);
		if( $found_mobile ){
			return true;
		} else {
			return false;
		}
	}





