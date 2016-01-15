<?php
class Api extends Ad_Controller{
	public function district_list(){
		echo json_encode(get_api_data('district/lists',$this->post_data));
	}
	public function mall_lists(){
		echo json_encode(get_api_data('mall/lists',$this->post_data));
	}
	public function mall_floor_lists(){
		echo json_encode(get_api_data('mall_floor/lists',$this->post_data));
	}
	public function street_lists(){
		echo json_encode(get_api_data('street/lists',$this->post_data));
	}
	public function store_lists(){
		echo json_encode(get_api_data('store/lists',$this->post_data));
	}
	public function brand_list(){
		echo json_encode(get_api_data('brand/lists',$this->post_data));
	}
	public function store_add(){
		echo json_encode(get_api_data('store/add',$this->post_data));
	}
	public function event_add(){
		echo json_encode(get_api_data('event/add',$this->post_data));
	}
	public function mall_ad_add(){
		echo json_encode(get_api_data('ad/mall_ad_add',$this->post_data));
	}
	public function event_product_add(){
		echo json_encode(get_api_data('event/product_add',$this->post_data));
	}
}