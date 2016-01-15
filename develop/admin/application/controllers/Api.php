<?php
class Api extends Ad_Controller{
	
	//商圈有关的接口
	public function district_list(){
		echo json_encode(get_api_data('district/lists',$this->post_data));
	}
	public function district_un_develop(){
		echo json_encode(get_api_data('district/un_develop',$this->post_data));
	}
	public function district_develop(){
		echo json_encode(get_api_data('district/develop',$this->post_data));
	}
	public function district_add(){
		echo json_encode(get_api_data('district/add',$this->post_data));
	}
	public function district_del(){
		echo json_encode(get_api_data('district/del',$this->post_data));
	}
	public function district_edit(){
		echo json_encode(get_api_data('district/edit',$this->post_data));
	}
	
	//商場列表
	public function mall_lists(){
		echo json_encode(get_api_data('mall/lists',$this->post_data));
	}
	public function mall_floor_lists(){
		echo json_encode(get_api_data('mall_floor/lists',$this->post_data));
	}
	public function mall_ad_add(){
		echo json_encode(get_api_data('ad/mall_ad_add',$this->post_data));
	}
	public function mall_add(){
		echo json_encode(get_api_data('mall/add',$this->post_data));
	}
	public function mall_edit(){
		echo json_encode(get_api_data('mall/edit',$this->post_data));
	}
	public function mall_del(){
		echo json_encode(get_api_data('mall/del',$this->post_data));
	}
	public function mall_floor_del(){
		echo json_encode(get_api_data('mall_floor/del',$this->post_data));
	}
	public function mall_floor_edit(){
		echo json_encode(get_api_data('mall_floor/edit',$this->post_data));
	}
	public function mall_floor_add(){
		echo json_encode(get_api_data('mall_floor/add',$this->post_data));
	}
	public function delete_mall_ad(){
		echo json_encode(get_api_data('ad/mall_ad_del',$this->post_data));
	}
	
	//街道
	public function street_lists(){
		echo json_encode(get_api_data('street/lists',$this->post_data));
	}
	
	
	//商鋪接口中轉
	public function store_lists(){
		echo json_encode(get_api_data('store/lists',$this->post_data));
	}
	public function store_add(){
		echo json_encode(get_api_data('store/add',$this->post_data));
	}
	public function store_update(){
		echo json_encode(get_api_data('store/update',$this->post_data));
	}
	public function add_verify_code(){
		echo json_encode(get_api_data('store/add_verify_code',$this->post_data));
	}
	public function store_del(){
		echo json_encode(get_api_data('store/del',$this->post_data));
	}
	public function store_edit(){
		echo json_encode(get_api_data('store/edit',$this->post_data));
	}
	
	//活动接口
	public function event_add(){
		echo json_encode(get_api_data('event/add',$this->post_data));
	}
	public function event_product_add(){
		echo json_encode(get_api_data('event/product_add',$this->post_data));
	}
	public function event_publish(){
		echo json_encode(get_api_data('event/publish',$this->post_data));
	}
	public function event_cancel_publish(){
		echo json_encode(get_api_data('event/cancel_publish',$this->post_data));
	}
	public function event_del(){
		echo json_encode(get_api_data('event/del',$this->post_data));
	}
	public function delete_event_product(){
		echo json_encode(get_api_data('event/delete_product',$this->post_data));
	}
	public function event_edit(){
		echo json_encode(get_api_data('event/edit',$this->post_data));
	}
	
	//活动商品接口
	public function event_product_edit(){
		echo json_encode(get_api_data('product/edit',$this->post_data));
	}
	
	
	
	
	//品牌api 中转下 
	public function brand_update(){
		echo json_encode(get_api_data('brand/update',$this->post_data));
	}
	public function brand_search(){
		echo json_encode(get_api_data('brand/search',$this->post_data));
	}
	public function brand_del(){
		echo json_encode(get_api_data('brand/del',$this->post_data));
	}
	public function brand_list(){
		echo json_encode(get_api_data('brand/lists',$this->post_data));
	}
	
	
	//商业街接口
	public function street_del(){
		echo json_encode(get_api_data('street/del',$this->post_data));
	}


	
	//跟管理员有关的接口
	public function employee_add(){
		echo json_encode(get_api_data('employee/add',$this->post_data));
	}
	public function employee_delete(){
		echo json_encode(get_api_data('employee/del',$this->post_data));
	}
	public function employee_edit(){
		echo json_encode(get_api_data('employee/edit',$this->post_data));
	}
	
	
	
	
	/*微信接口测试*/
	public function test_weixin_api(){
		echo "
				<a href='https://open.weixin.qq.com/connect/qrconnect
				?appid=wx61cac32fbc56a6f2&redirect_uri=http://kanjiebao.com&response_type=code&scope=snsapi_login&state=3d6be0a4035d839573b04816624a415e
				'> 点我 </a>
				";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		
		//http://kanjiebao.com/?code=0314961e06a381b2991e291500025a8h&state=3d6be0a4035d839573b04816624a415e
		
		//获取 access_token 接口
		//https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
		
		echo "
				<a href='https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx61cac32fbc56a6f2
				&secret=d4624c36b6795d1d99dcf0547af5443d&code=0314961e06a381b2991e291500025a8h&grant_type=authorization_code'>获取 access_token </a>
				";
		
		
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		//access_token
		/*
		{
			"access_token":"OezXcEiiBSKSxW0eoylIeHBztoDvNECLFgHQ3GwUC9t3Y3HgnfXcnNLJRElk8Px8HsYr1V5rLsdkzhj31zTiH_TpVMyyrfuD4JtpNGLPiPzU1gn0OblmCwaHqpAvBpI50synnALO6mGsQsMCdqDtNw",
			"expires_in":7200,
			"refresh_token":"OezXcEiiBSKSxW0eoylIeHBztoDvNECLFgHQ3GwUC9t3Y3HgnfXcnNLJRElk8Px8_7ohCfxDD0R38h11HmpjTDqN1JARxx_sCkq4P0UGRHR0m3AEiPSeWWjrbPRwgobQMcOtjSg2T5Zc_wuQL8P0Ug",
			"openid":"o9cqBuJKloHyevIpwqSTldG2E_xU",
			"scope":"snsapi_login",
			"unionid":"o3w2kxKsI24SdoGG22HFCPm7e89Y"
		}
		*/
		
		
		//获取 用户信息
		
		//https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID
		echo "<br>";
		echo "<a href='https://api.weixin.qq.com/sns/userinfo
				?access_token=OezXcEiiBSKSxW0eoylIeHBztoDvNECLFgHQ3GwUC9t3Y3HgnfXcnNLJRElk8Px8HsYr1V5rLsdkzhj31zTiH_TpVMyyrfuD4JtpNGLPiPzU1gn0OblmCwaHqpAvBpI50synnALO6mGsQsMCdqDtNw
				&openid=o9cqBuJKloHyevIpwqSTldG2E_xU'
				>获取用户信息</a>";
		
		
		//拿到了用户信息
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		/*
		{
			"openid":"o9cqBuJKloHyevIpwqSTldG2E_xU",
			"nickname":"开彦",
			"sex":1,
			"language":"zh_CN",
			"city":"",
			"province":"Beijing",
			"country":"CN",
			"headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/4nBicyiawgQp7LvKMXBLZcUlnWsX5o6gibMfcSM68B0VyBHuI5XLFuz8e9ohrXJe6IEftBkaqkeAKjpueVLAz54UpKUH5Q862Tp\/0",
			"privilege":[],
			"unionid":"o3w2kxKsI24SdoGG22HFCPm7e89Y"
		}
		*/
		
		echo "
				<img src='http://wx.qlogo.cn/mmopen/4nBicyiawgQp7LvKMXBLZcUlnWsX5o6gibMfcSM68B0VyBHuI5XLFuz8e9ohrXJe6IEftBkaqkeAKjpueVLAz54UpKUH5Q862Tp/0'/>
				";
		
		
		
		
		/*
		 * 
		 * 
		 * */
	}
	
}










