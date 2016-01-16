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
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
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
	        if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "欢迎来到机子铺";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
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
