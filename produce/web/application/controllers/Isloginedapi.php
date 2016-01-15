<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Isloginedapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        if (isset($_COOKIE['session']) && ''!=$_COOKIE['session'])
        {
            echo 1;
            exit;
        }
        echo 0;
    }
}