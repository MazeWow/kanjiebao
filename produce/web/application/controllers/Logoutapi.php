<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logoutapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $session_val = $_COOKIE['session'];
        $must = array('session' => $session_val);
		$res = get_api_data('user/logout', $must);
		if (0 == $res['err_num'])
		{
		    setcookie('session', '');
		}
		echo json_encode($res);
    }
}