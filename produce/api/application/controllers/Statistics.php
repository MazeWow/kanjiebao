<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Statistics extends JB_Controller {
	public function __construct(){
		parent::__construct();
	}
	/*
	 * @desc	所有商圈
	 * */
	public function all_district(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select count(id) as develop_nums from ".T_DISTRICT." where is_developed = 1";
			$res = $this->Base_model->ci_query($sql);
			$developed_district = $res[0]['develop_nums'];
			$sql = "select count(id) as develop_nums from ".T_DISTRICT." where is_developed = 0";
			$res = $this->Base_model->ci_query($sql);
			$un_developed_district = $res[0]['develop_nums'];
			$this->st(array('developed_district'=>$developed_district,
					'un_developed_district'=>$un_developed_district
			));
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	所有商场
	 * */
	public function all_mall(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select count(id) as all_mall from ".T_MALL;
			$res = $this->Base_model->ci_query($sql);
			$all_mall = $res[0]['all_mall'];
			$this->st(array('mall_nums'=>$all_mall));
		}while(0);
		$this->op();
	}
	
	/*
	 * @desc	所有商铺数
	 * */
	public function all_store(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select count(id) as all_store from ".T_STORE;
			$res = $this->Base_model->ci_query($sql);
			$all_store = $res[0]['all_store'];
			$this->st(array('store_nums'=>$all_store));
		}while(0);
		$this->op();
	}
	/*
	 * @desc	所有活动
	 * */
	public function all_event(){
		$must = array();
		$this->check_param($must);
		$this->check_sign();
		extract($this->params);
		do{
			$sql = "select count(id) as all_event from ".T_EVENT." where is_del = 0";
			$res = $this->Base_model->ci_query($sql);
			$all_event = $res[0]['all_event'];
			
			$sql = "select count(id) as all_event_on from ".T_EVENT." where is_del =0 and stime < ".time()." and etime > ".time();
			$res = $this->Base_model->ci_query($sql);
			$all_event_on = $res[0]['all_event_on'];
			
			$this->st(array('all_event_nums'=>$all_event,'show_event_nums'=>$all_event_on));
		}while(0);
		$this->op();
	}
	
	
}













