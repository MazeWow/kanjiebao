<?php
class Weixin extends Ad_Controller{
	public function __construct(){
	}
	public function index(){
		$weixin = new Weixin_verify();
		var_dump($weixin);
// 		$weixin->valid();
	}
}
/*end of file of Base.php*/






