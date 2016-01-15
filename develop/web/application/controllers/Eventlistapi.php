<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Eventlistapi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $must = array();
        $page_now = $this->input->post('page_now');
        $page_size = $this->input->post('page_size');
        if ($page_now)
        {
            $must['page_now'] = $page_now;
        }
        if ($page_size)
        {
            $must['page_size'] = $page_size;
        }
        if (isset($_COOKIE['category']) && ''!=$_COOKIE['category'])
        {
            $cate_id_str = $_COOKIE['category'];
            $must['cate_id_str'] = $cate_id_str;
        }
        if (isset($_COOKIE['style']) && ''!=$_COOKIE['style'])
        {
            $style_id_str = $_COOKIE['category'];
            $must['style_id_str'] = $style_id_str;
        }
        $district = $this->input->post('district');
        $mall = $this->input->post('mall');
        $mall_floor_id = $this->input->post('mall_floor_id');
        $store_id = $this->input->post('store_id');
		if ($district)
		{
		    $must['district_id'] = $district;
		}
		else if ($mall)
		{
		    $must['mall_id'] = $mall;
		}
		else if ($mall_floor_id)
		{
		    $must['mall_floor_id'] = $mall_floor_id;
		}
		else if ($store_id)
		{
		    $must['store_id'] = $store_id;
		}
		$res = get_api_data('event/lists', $must);
		echo json_encode($res);
    }
}