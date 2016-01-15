<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cookiesetapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $cookie_str = $this->input->post('cookie');
        $cookie_arr = explode('&', $cookie_str);
        foreach ($cookie_arr as $val)
        {
            $cookie_val = explode('=', $val);
            if ("''" != $cookie_val[1])
            {
		        setcookie($cookie_val[0], $cookie_val[1], time()+86400);
		    }
		    else
		    {
		        setcookie($cookie_val[0], '');
		    }
		}
		echo 1;
    }
}