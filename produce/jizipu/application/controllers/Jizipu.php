<?php
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr))
		{
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content><FuncFlag>0</FuncFlag></xml>";
			//如果用户发信息过来了
			debug($keyword,'keyword');
			if(!empty( $keyword ))
			{
				$data = ''; //返回给用户的数据
				//当用户输入 10-14位 “字母+数字” 时，调用序列号查询接口！
				//1,数据返回正确，则正确返回。
				//2,数据查询错误，返回“不好意思，您的序列号可能有误，确认后再试一下吧～ps：如果有问题，可以直接留言，机小妹会第一时间为你排忧解难”！
				if(preg_match('/^\w{10,14}$/',$keyword))
				{
					//$data = get_apple_msg($keyword);
					$data .= "您输入的是序列号!";
					if($data){
						
					}else{
							$data = "不好意思，您的序列号可能有误，确认后再试一下吧～ps：如果有问题，可以直接留言，机小妹会第一时间为你排忧解难";
					}
				}
				if(preg_match('/^\d{14,18}$/',$keyword))
				{
					$data .= "您输入的是imei码";
					$imei = $keyword;
					//$data = get_apple_serial($imei);
				}
				//用户发的普通信息,自动回复如下
				//其他消息均不自动回复
				else
				{
	        			$data = "哈喽！机友！终于等到你咯~到了机子铺，表客气！机小妹随时听候差遣~在这里，你可以一秒轻松鉴定手机真伪、分分钟获取相关干货、还能随时随地请教机小妹！\n";
						$data .= "1）输入手机“序列号”，获取手机的具体信息\n";
						$data .= "2）输入手机“imei”码，获取更全面信息，轻松鉴定手机真伪！\n";
						$data .= "3）二手手机相关干货，翻看历史消息，轻松掌握～\n";
						$data .= "4）有神马问题，随时留言，机小妹会在第一时间为你排忧解难！\n";
				}
				//格式化返回给微信的数据
                echo sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $data);
	        }
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

}

function createSign ($paramArr)
{
	$sign = "";
	ksort($paramArr);
	foreach ($paramArr as $key => $val) {
		if ($key != '' && $val != '') {
			$sign .= $key.$val;
		}
	}
	$sign.='50a2e8e3b42248d1b73739641faa3fa4';
	$sign = strtoupper(md5($sign));
	return $sign;
}

function createStrParam ($paramArr)
{
	$strParam = '';
	foreach ($paramArr as $key => $val) {
		if ($key != '' && $val != '') {
			$strParam .= $key.'='.urlencode($val).'&';
		}
	}
	return $strParam;
}

function get_apple_msg($sn = 'F2LPH9FQG5QV')
{
	date_default_timezone_set("PRC");
	$ch = curl_init();
    $url = "http://apis.baidu.com/3023/apple/apple?sn=$sn";
   	$header = array(
       	'apikey: f71b2732ad014b80ad528ea06d08470f',
    );
	// 添加apikey到header
	curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// 执行HTTP请求
	curl_setopt($ch , CURLOPT_URL , $url);

	//调用api获取下数据
	$res = curl_exec($ch);
	
	debug($res,'get_apple_msg');
	return $res;
	
						if($contentStr = json_decode($res,true)){
							$c = $contentStr;
							$contentStr = "设备型号：$c[model]\n容量：$c[capacity]\n颜色: $c[color]\n版本:$c[number]\n类型:$c[identifier]\n";
							$contentStr.= "模型：$c[order]\n网络:$c[network]\n";
							if($c['activated']){
								$contentStr .= "激活状态：已激活\n";
								$contentStr .= "激活时间:$c[time]\n";
							}else{
								$contentStr .= "激活状态：未激活\n";
							}
							$contentStr .= "产地:$c[origin]\n";
							$contentStr .= "出厂日期:$c[end]\n";
							$contentStr .= "产品类型:$c[product]\n";
							$contentStr .= "硬件保修:$c[warranty]\n";
							$contentStr .= "保修剩余天数:$c[dayleft]\n";
							$contentStr .= "电话支持:$c[tele]\n";
							if($c['purchasing']){
								$contentStr .= "是否有效购买：是\n";
							}else{
								$contentStr .= "是否有效购买：否\n";
							}
							if($c['locked']){
								$contentStr .= "激活锁状态：锁定\n";
							}else{
								$contentStr .= "激活锁状态：关闭\n";
							}
							$contentStr .= "PS: 此查询结果仅供参考,一切以<a href='https://checkcoverage.apple.com/cn/zh;jsessionid=nlLgWWJcyJlfqjP5G68LymHwQLdJJy58ynkTNyyJDw1FJTHzTqFv!1843384130'>苹果官网</a>查询结果为准\n";
							$contentStr .= "销售地(哪国版)：[设置/通用/关于本机/型号]忽略/A最后两位CH为国行,ZP港行,KH韩版,LL美版";
	







}

function get_apple_serial($imei){
    $url = "http://iphoneimei.info/?imei=$imei";
	$res = file_get_contents($url);

	//第一次处理网页输出
	//输出:Serial Number: </span><span class="value">F2LP7419G5QW</span></div>
	$pos = strpos($res,"Serial Number");
	//能否找到?
	if($pos){
		$res1 = substr($res,$pos,100);
		//第二次处理匹配查找
		$res2 = [];
		$pos = preg_match('/\w{10,}/',$res1,$res2);
		if($pos){
			$serial = $res2[0];
			return $serial;
		}
	}
	return false;
}





class Jizipu extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function weixin_access_token_update(){
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx57c3018bd11713e4&secret=2dda6ad80590e404df1901ddd4238f33';
 		$response = json_decode(file_get_contents($url),true);
		$access_token = (isset($response['access_token']))?$response['access_token']:false;
		if(!$access_token) {echo "update access token fail:response error"; return false;}
		
		$this->load->database();
		$sql = "delete from jizipu_weixin_access_token";
		$query = $this->db->query($sql);
		$sql = "insert into jizipu_weixin_access_token (access_token) values ('$access_token')";
		$query = $this->db->query($sql);
		echo "weixin_access_token update success!";
		return true;
	}

	public function weixin_access_token_get(){
		$this->load->database();
		$sql = "select access_token from jizipu_weixin_access_token limit 1";
	        $query = $this->db->query($sql);
	        $access_token = $query->result_array()[0]['access_token'];
		return $access_token;
	}

	public function index(){
		define("TOKEN",'codekissyoung');
		$wechatObj = new wechatCallbackapiTest();
		if(isset($_GET['echostr'])){
			$wechatObj -> valid();
		}else{
			$wechatObj -> responseMsg();
		}
	}
	
	public function test(){
		$ch = curl_init();
    	$url = 'http://apis.baidu.com/3023/apple/apple?sn=F2LPH9FQG5QV';
   		$header = array(
        	'apikey: f71b2732ad014b80ad528ea06d08470f',
    	);
	    // 添加apikey到header
	    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // 执行HTTP请求
	    curl_setopt($ch , CURLOPT_URL , $url);
	    $res = curl_exec($ch);
	
	    var_dump(json_decode($res));
	}
}
}