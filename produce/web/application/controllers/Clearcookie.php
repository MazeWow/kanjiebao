<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clearcookie extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        print_r($_COOKIE);
        foreach ($_COOKIE as $key=>$val)
        {
            setcookie($key, '');
        }
    }
}