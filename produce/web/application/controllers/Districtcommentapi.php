<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Districtcommentapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $comment = $this->input->post('comment');
		$must = array('comment'=>$comment);
		$res = get_api_data('user/comment_add', $must);
		echo json_encode($res);
    }
}