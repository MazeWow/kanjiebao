<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cookiegetapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $name = $this->input->post('name');
        if (isset($_COOKIE[$name]))
        {
            echo json_encode(array(1,$_COOKIE[$name]));
        }
        else
        {
            echo json_encode(array(0));
        }
    }
}