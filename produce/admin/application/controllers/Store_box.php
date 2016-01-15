<?php
class Store_box extends Ad_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function edit_store(){
		$store_id = $this->get_data['store_id'];
		$ret = get_api_data('store/detail',array('store_id'=>$store_id));
		$this->data['store_info'] = $ret['results'];
		$this->load->view('store_box/store_edit',$this->data);
	}
	
}









