<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        //$mall = $this->input->get('mall');
        //$this->load->view('mall.html'.($mall ? "?mall=$mall" : ''));
        $this->load->view('user.html');
    }
}