<?php
/*
 * 整个CURL都是一个静态单例
 * 连续使用 CURL::get ,CURL::post 其实是在一个实例化对象的$curl上不断的改写请求规则,发送请求
 * 可以将CURL理解为一个小型浏览器了,它为你保存cookie...发送请求时再带上cookie
 */
class CURL
{

	public static $curl = FALSE;
	
	//初始化一个$curl
	public static function init()
	{
		if (! self::$curl) {
			self::$curl = curl_init ();
		}
		curl_setopt ( self::$curl, CURLOPT_RETURNTRANSFER, TRUE );
		//获取到数据后不直接打印出来
	}
	
	//执行curl请求
	public static function exec()
	{
		$output = curl_exec ( self::$curl );
		if (! curl_errno ( self::$curl )) {
			return $output;
		} else {
			return FALSE;
		}
	
	}

	public static function close()
	{
		curl_close ( self::$curl );
	
	}

	public static function get($url)
	{
		self::init ();
		curl_setopt ( self::$curl, CURLOPT_URL, $url );
		curl_setopt ( self::$curl, CURLOPT_POST, 0 );
		curl_setopt ( self::$curl, CURLOPT_HTTPHEADER, [ 
				"Content-type:text/xml" 
		] );
		return self::exec ();
	
	}

	public static function post($url, $data)
	{
		self::init ();
		curl_setopt ( self::$curl, CURLOPT_URL, $url );
		curl_setopt ( self::$curl, CURLOPT_HEADER, FALSE );
		//cookie 相关设置
		date_default_timezone_set ( "PRC" );
		curl_setopt ( self::$curl, CURLOPT_COOKIESESSION, TRUE );
		curl_setopt ( self::$curl, CURLOPT_COOKIEFILE, 'cookiefile' ); //
		curl_setopt ( self::$curl, CURLOPT_COOKIEJAR, 'cookiefile' ); //
		curl_setopt ( self::$curl, CURLOPT_COOKIE, session_name () . "=" . session_id () );
		curl_setopt ( self::$curl, CURLOPT_FOLLOWLOCATION, TRUE ); //支持curl页面链接跳转
		

		//获取https 资源
		//date_default_timezone_set("PRC"); 也需要设置时间
		curl_setopt ( self::$curl, CURLOPT_SSL_VERIFYPEER, FALSE ); //不对服务器进行验证，因为我不关心你服务器是否是官网
		

		curl_setopt ( self::$curl, CURLOPT_POST, TRUE ); //请求类型：post
		curl_setopt ( self::$curl, CURLOPT_POSTFIELDS, $data ); //post 携带的数据
		curl_setopt ( self::$curl, CURLOPT_HTTPHEADER, [ 
				"application/x-www-form-urlencoded;charset=utf-8",
				"Content-length:" . strlen ( $data ) 
		] );
		return self::exec ();
	
	}

	public static function getHeader()
	{
		return curl_getinfo ( self::$curl );
	
	}

}
/* end of file*/
