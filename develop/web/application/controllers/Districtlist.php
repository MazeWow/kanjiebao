<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Districtlist extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
    	$this->data["title"] = "选择商圈";
        $this->load->view('districtlist');
    }
}