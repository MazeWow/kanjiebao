<?php
class Jizipu extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx57c3018bd11713e4&secret=2dda6ad80590e404df1901ddd4238f33';
		$a = file_get_contents($url);
		var_dump($a);
		/*
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		echo $file_contents;
		*/
	}
}
