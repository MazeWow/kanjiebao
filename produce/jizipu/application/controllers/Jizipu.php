<?php
class wechatCallbackapiTest
{
	public function valid()
    {/*{{{*/
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }/*}}}*/

    public function responseMsg()
    {/*{{{*/
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>0</FuncFlag>
			     </xml>";
	        if(!empty( $keyword )){
					$contentStr = '';
					if(preg_match('#\w{10,}#',$keyword)){
						$contentStr = get_apple_msg($keyword);
						if($contentStr = json_decode($contentStr,true)){
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
							$p = $c['renovate']['probability'];
							$r = $c['renovate']['result'];
							$contentStr .= "翻新机概率:$p\n";
							$contentStr .= "鉴定结果:$r\n";
							$contentStr .= "详细规格如下 : \n";
							$s = $c['spec'];
							$contentStr .= "产品：$s[item]\n";
							$contentStr .= "上市时间：$s[intro]\n";
							$contentStr .= "停产时间：$s[disc]\n";
							$contentStr .= "显示屏：$s[display]\n";
							$contentStr .= "分辨率：$s[resolution]\n";
							$contentStr .= "处理器：$s[cpu]\n";
							$contentStr .= "处理器核心：$s[processor]\n";
							$contentStr .= "处理器频率：$s[speed]\n";
							$contentStr .= "内存：$s[ram]\n";
							$contentStr .= "储存：$s[storage]\n";
							$contentStr .= "尺寸：$s[dimension]\n";
							$contentStr .= "重量：$s[weight]";

							$img = $c['img'];
							$contentStr .="设备图片:$img\n";
						}else{
							$contentStr = "不好意思，您的序列号/imei码可能有误，确认后再试一下吧～";
						}
					}else{
	        			$contentStr = "这位机友迷路了吧？机子铺里，你可以一秒轻松鉴定手机真伪、分分钟获取相关干货、还能随时随地请教机小妹！\n";
						$contentStr .= "1）输入手机“序列号”，获取手机的具体信息；\n";
						$contentStr .= "2）输入手机“imei”码，获取更全面信息，轻松鉴定手机真伪！\n";
						$contentStr .= "3）二手手机相关干货，查看历史消息即可～";
					}
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
                	echo $resultStr;
	        }else{
                	echo "您没有输入任何内容!";
            }
        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{/*{{{*/
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
	/*}}}*/}

}

function createSign ($paramArr) 
{/*{{{*/
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
/*}}}*/}

function createStrParam ($paramArr) 
{/*{{{*/
	$strParam = '';
	foreach ($paramArr as $key => $val) {
		if ($key != '' && $val != '') {
			$strParam .= $key.'='.urlencode($val).'&';
		}
	}
	return $strParam;
/*}}}*/}

function get_apple_msg($sn = 'F2LPH9FQG5QV')
{/*{{{*/
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
	return $res = curl_exec($ch);
	/*	
	$paramArr = array(
			'showapi_appid'=> '14742',
			'sn' => $sn,
			'showapi_timestamp' => date('YmdHis')
	);
	$sign = createSign($paramArr);
	$strParam = createStrParam($paramArr);
	$strParam .= 'showapi_sign='.$sign;
	$url = 'http://route.showapi.com/864-1?'.$strParam;
	$result = file_get_contents($url);
	$result = json_decode($result,true);
	return $result;
	*/
/*}}}*/}

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
