<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $product = $this->input->get('product');
        $this->load->view('product.html', array('product'=>$product));
    }
}