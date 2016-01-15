<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GetTime extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        	
		$session=$_COOKIE['session'];
		$must = array('session'=>$session);
		$res = get_api_data('user/user_street_time',$must);
		op($res);
		echo json_encode($res);
	}
    }
