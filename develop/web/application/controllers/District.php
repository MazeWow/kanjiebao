<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class District extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $this->data['title'] = "商圈详情";
        $this->data['district'] = $this->input->get('district');
        $this->load->view('district', $this->data);
    }
}