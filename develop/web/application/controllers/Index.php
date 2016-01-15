<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    // kanjiebao 应用首页
    public function index() {
    	$this->data["title"] = "享优惠看街报";
    	$res = get_api_data('event/lists',$this->get_data);
    	if($res['err_num'] == 0){
    		$this->data['events'] = get_api_data('event/lists',$this->get_data)['results']['records'];
    	}
        $this->load->view('index',$this->data);
    }
    
    
}