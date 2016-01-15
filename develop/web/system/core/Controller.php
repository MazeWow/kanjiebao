<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Controller {
	private static $instance;
	
	//用于存放传递到 view 的数据
	protected $data = [];
	
	protected  $get_data;			//传过来的  $_GET 数据
	
	protected  $post_data;			//传过来的　$_POST 数据
	
	public function __construct()
	{
		self::$instance =& $this;
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}
		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		
		$this->load->library('session');/*加载 session 类*/
		
		$this->get_data = $this->input->get();
		if(!isset($this->get_data['page_now'])){
			$this->get_data['page_now']  = 1;
		}
		if(!isset($this->get_data['page_size'])){
			$this->get_data['page_size'] = 6;
		}
		$this->post_data= $this->input->post();
		
	}
	public static function &get_instance()
	{
		return self::$instance;
	}

}
