<?php

/*常量*/
$data = "关注我就对了!!到了机子铺有神马问题，随时给我留言，机子君会在第一时间为你解答!\n";
$data .= "1）直接输入苹果序列号即可得到查询结果!\n";
//$data .= "2）输入手机“imei”码，获取更全面信息，轻松鉴定手机真伪！\n";
$data .= "2）二手手机原创干货，翻看历史消息，轻松掌握～\n";

define("ATTENTION_MSG",$data);

/*functions*/
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


function get_apple_serial($imei){
	$url = "http://iphoneimei.info/?imei=$imei";

	//debug($url,'url');
	$res = file_get_contents($url);
	
	//debug($res,'res');
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
	
	//查询后解析正确？
	$contentStr = json_decode($res,true);
	
	//调用apple查询接口,查询错误
	if(!$contentStr){
		return false;
	}
		//重置下$contentStr用于生成返回字符串,这么挫的代码是历史原因,懒得改....
		$c = $contentStr;
		$contentStr = '';
		
		//格式化apple信息
		//$contentStr = "设备型号：$c[model]\n容量：$c[capacity]\n颜色: $c[color]\n版本:$c[number]\n";
		$contentStr = "设备型号：$c[model]\n容量：$c[capacity]\n颜色: $c[color]\n";
		//$contentStr.= "模型：$c[order]\n网络:$c[network]\n";
		//$contentStr.= "模型：$c[order]\n网络:$c[network]\n";
		/*
		if($c['activated']){
			$contentStr .= "激活状态：已激活\n";
			$contentStr .= "激活时间:$c[time]\n";
		}else{
			$contentStr .= "激活状态：未激活\n";
		}
		*/
		$contentStr .= "激活与保修:<a href='https://checkcoverage.apple.com/cn/zh;jsessionid=nlLgWWJcyJlfqjP5G68LymHwQLdJJy58ynkTNyyJDw1FJTHzTqFv!1843384130'>查看苹果官网</a>\n";
		$contentStr .= "产地:$c[origin]\n";
		$contentStr .= "出厂日期:$c[end]\n";
		$contentStr .= "激活锁状态:<a href='https://www.icloud.com/activationlock/'>点击检查</a>\n";
//		$contentStr .= "产品类型:$c[product]\n";
//		$contentStr .= "硬件保修:$c[warranty]\n";
//		$contentStr .= "保修剩余天数:$c[daysleft]\n";
		$contentStr .= "电话支持:$c[tele]\n";
		/*
		if($c['purchasing']){
			$contentStr .= "是否有效购买：是\n";
		}else{
			$contentStr .= "是否有效购买：否\n";
		}
		*/
		/*
		if($c['locked']){
			$contentStr .= "激活锁状态：锁定\n";
		}else{
			$contentStr .= "激活锁状态：关闭\n";
		}
		*/
		$contentStr .="\n";
		$contentStr .= "PS: 此查询结果仅供参考,一切以<a href='https://checkcoverage.apple.com/cn/zh;jsessionid=nlLgWWJcyJlfqjP5G68LymHwQLdJJy58ynkTNyyJDw1FJTHzTqFv!1843384130'>苹果官网</a>查询结果为准\n";
		
		$contentStr .="\n";
		$contentStr .= "销售地(哪国版)：[设置/通用/关于本机/型号]忽略/A最后两位CH为国行,ZP港行,KH韩版,LL美版";
		return $contentStr;
}

/*处理微信事件的类*/
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
		//获取微信发送过来的post请求数据
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr))
		{
			libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
			$msgtype = $postObj->MsgType;
			$time = time();
            $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content><FuncFlag>0</FuncFlag></xml>";
			
			$data = ''; //返回给用户的数据
			
			//如果推送类型是事件
			if(strtolower($postObj->MsgType) == "event"){
				//关注公众号事件
				if(strtolower($postObj->Event == "subscribe")){
					$data .= ATTENTION_MSG;
				}
			//用户发消息给公众号
			}elseif(strtolower($postObj->MsgType) == "text"){
				//获取文本
				$keyword = trim($postObj->Content);
				//当用户输入 10-14位 “字母+数字” 时,使用序列号查询苹果信息
				if(preg_match('/^\w{10,14}$/',$keyword))
				{
					//$data .= "您输入的是序列号!\n";
					$data .= "[$keyword] 信息：\n";
					$msg = get_apple_msg($keyword);
					if($msg){
						$data .= $msg;
					}else{
						$data .= "不好意思，您的序列号可能有误，确认后再试一下吧～ps：如果有问题，可以直接留言，机子君会第一时间为你排忧解难";
					}
				}
				//用户输入14-18位的纯数字查询
				elseif(preg_match('/^\d{14,18}$/',$keyword))
				{
					$imei   = $keyword;
					$serial = get_apple_serial($imei);
					$data .= "[$imei] 信息：\n";
					//查询序列码失败
					if(!$serial){
						$data .= "不好意思，您的imei可能有误，确认后再试一下吧～ps：如果有问题，可以直接留言，机子君会第一时间为你排忧解难";
					}else{
						//根据拿到的序列码查apple信息
						$data .= "序列号：$serial\n";
						$data .= get_apple_msg($serial);
					}
				}else{
            		echo sprintf($textTpl, $fromUsername, $toUsername, $time, 'transfer_customer_service', $data);
					return ;
				}
			}
			//格式化返回给微信的数据
            echo sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $data);
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


/*Jizipu　class*/
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
}
/*end of file*/
