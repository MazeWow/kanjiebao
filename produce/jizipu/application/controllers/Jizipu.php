<?php
class Jizipu extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
//		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx57c3018bd11713e4&secret=2dda6ad80590e404df1901ddd4238f33';
// 		$a = file_get_contents($url);
		$query = $this->db->query('select * from city');
		foreach ($query->result() as $row)
		{
			var_dump($row);
		}
	}
}
