<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mall extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $mall = $this->input->get('mall');
        //这个 mall 你在mall.html 里面用都没用。。。如何传的参数?
        $this->load->view('mall.html', array('mall'=>$mall));
    }
}