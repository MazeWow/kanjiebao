<?php
class Jizipu extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		debug($_GET);
		$tamp 	   = $_GET['timestamp'];
		$nonce	   = $_GET['nonce'];
		$token	   = 'codekissyoung';
		$array     = array($timestamp,$nonce,$token);
		sort($array,SORT_STRING);
		$tmpstr = implode($array);
		$tmpstr = sha1($tmpstr);
		debug($tmpstr,'tmpstr');
		echo $_GET['echostr'];
	}
}
