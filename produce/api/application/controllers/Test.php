<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends JB_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function test(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			
			$this->load->model("District_model");
// 			$res = $this->District_model->get_all_districts();

// 			$res = $this->District_model->get_district_where(array('id'=>1));

			
			$this->load->model('Mall_model');
// 			$res = $this->Mall_model->info(1);
// 			$res = $this->Mall_model->get_mall_where(array('id'=>1));
			
			$this->load->model('Mall_floor_model');
// 			$res = $this->Mall_floor_model->get_mall_floor_where(array('id'=>22));
// 			$res = $this->Mall_floor_model->get_all_floor();
			$res = $this->Mall_floor_model->get_records_nums(T_MALL_FLOOR,array('mall_id'=>1));
			
			
			$this->st($res);
		}while(0);
		$this->op();
		
	}
	

}