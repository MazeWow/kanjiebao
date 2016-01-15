<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cityapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
		$must = array('province'=>'北京', 'page_now'=>1);//可选参数　: 'page_size'=>1000
		$res = get_api_data('city/lists', $must);
		echo json_encode($res);
    }
}