<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class District extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $district = $this->input->get('district');
        $this->load->view('district.html', array('district'=>$district));
    }
}