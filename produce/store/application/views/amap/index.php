<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base')?>">基础管理</a></li>
					<li><a href="<?=base_url('base/city')?>">系统概况</a></li>
					<li class="active">系统负载</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
			<div id="amap" style="border:1px solid red;height:400px;width:300px;">
				
			</div>
			<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f980595559486bdd3480b919b24a2905"></script>
			<script type="text/javascript">
				$(function(){
						var map = new AMap.Map('amap',{'zoom':15,'center':[116.39,39.9]});
						var marker = new AMap.Marker({
					        position: [116.39,39.9],
					        map:map
					    });
						var infowindow = new AMap.InfoWindow({
						     content: '<h3>高德地图</h1><div>高德是中国领先的数字地图内容、导航和位置服务解决方案提供商。</div>',
						     offset: new AMap.Pixel(0, -30),
						     size:new AMap.Size(230,0)
						});
						infowindow.open(map,new AMap.LngLat(116.480983, 39.989628));
						mapObj = new AMap.Map('iCenter');
						mapObj.plugin('AMap.Geolocation', function () {
						    geolocation = new AMap.Geolocation({
						        enableHighAccuracy: true,//是否使用高精度定位，默认:true
						        timeout: 10000,          //超过10秒后停止定位，默认：无穷大
						        maximumAge: 0,           //定位结果缓存0毫秒，默认：0
						        convert: true,           //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
						        showButton: true,        //显示定位按钮，默认：true
						        buttonPosition: 'LB',    //定位按钮停靠位置，默认：'LB'，左下角
						        buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
						        showMarker: true,        //定位成功后在定位到的位置显示点标记，默认：true
						        showCircle: true,        //定位成功后用圆圈表示定位精度范围，默认：true
						        panToLocation: true,     //定位成功后将定位到的位置作为地图中心点，默认：true
						        zoomToAccuracy:true      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
						    });
						    mapObj.addControl(geolocation);
						    AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
						    AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
						});
					});
			</script>
		<!-- row -->
	</div>
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<?php $this->load->view('common/footer');?>
