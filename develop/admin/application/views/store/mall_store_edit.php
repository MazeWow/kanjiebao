<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span
							class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base')?>">基础管理</a></li>
					<li><a href="<?=base_url('base/city')?>">商铺层级</a></li>
					<li class="active">添加</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row" id="main_page">
			<div class="row">
				<div class="col-sm-12">
					<p class="bg-info form-square-title">商铺名称</p>
				</div>
				<div class="row col-sm-12">
					<div class="col-sm-3">
						<input class="form-control" placeholder="商铺名称" id="store_name" value="<?php echo $store['store_name'];?>"/>
					</div>
					<div class="col-sm-3">
						<input class="form-control" placeholder="详细地址(F1层-201号 : 只填201号)"
							id="store_addr" value="<?php echo (empty($store['store_addr']))?'该商铺未填地址':$store['store_addr'];?>"/>
					</div>
					<div class="col-sm-3">
						<input class="form-control" placeholder="联系电话" id="store_phone" 
						value="<?php echo (empty($store['store_phone']))?'该商铺未填电话':$store['store_phone'];?>"
						/>
					</div>
					<div class="col-sm-3">
						<input class="form-control" placeholder="营业时间(例：9:00 - 22:00)"
							id="store_opening_hours" 
							value="<?php echo (empty($store['store_opening_hours']))?'该商铺未填营业时间':$store['store_opening_hours'];?>"
							/>
					</div>
					<br>
				</div>
			</div>
			<br>
		<div class="row">
			<div class="col-sm-12">
				<p class="bg-info form-square-title">商铺路径</p>
			</div>
		</div>
		<div class="row">
	<div class="col-md-12">
	<div class="form-inline">
		<div class="form-group">
			<select class="form-control" name="district_id" id="district_id">
				<option value=<?php echo $store['district_id'];?>><?php echo $store['district_name'];?></option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="mall_id" id="mall_id">
				<option value=<?php echo $store['mall_id'];?>><?php echo $store['mall_name'];?></option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="mall_floor_id" id="mall_floor_id">
				<option value=<?php echo $store['mall_floor_id'];?>><?php echo $store['mall_floor_name'];?></option>
			</select>
		</div>
	</div>
</div>
<br>
<script>
$(function(){
	//获得商圈
	function get_district(){
			post("<?php echo base_url('api/district_list');?>",{
					'city_id':1,'is_developed':1
				},function(data){
						if(data.err_num == 0){
								var records = data.results.records;
								var options_str = c_option(0,"商圈");
								for(var x in records){
									options_str += c_option(records[x]['id'],records[x]['name']);
								}
								$("#district_id").empty();
								$("#district_id").append(options_str);
							}
					});
		}
	get_district();
	//商圈　－　商场联动
	$("#district_id").bind("change",function(){
			post("<?php echo base_url('api/mall_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商场");
									for(var x in mall){
											options_str += c_option(mall[x]['mall_id'],mall[x]['mall_name']);
										}
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									
								}else{
									options_str = c_option(0,"该商圈下没有商场");
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									}
						});
		});
	//商场　－　商场楼层联动
	$("#mall_id").bind("change",function(){
		post("<?php echo base_url('api/mall_floor_lists');?>",
				{"mall_id":$(this).val()},
				function(data){
						if(data.err_num == 0){
								var mall = data.results.records;
								var options_str = c_option(0,"商场楼层");
								for(var x in mall){
										options_str += c_option(mall[x]['mall_floor_id'],mall[x]['mall_floor_name']);
									}
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该商场下没有楼层");
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								}
					});
	});
});
</script>
</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				<p class="bg-info form-square-title">商铺品牌</p>
			</div>
				<div class="col-sm-12">
	<div class="form-inline">
		<div class="form-group">
			<input class="form-control" placeholder="品牌关键字" id="search_brand" />
		</div>
		<div class="form-group">
			<select class="form-control" name="brand_id" id="brand_id">
				<option value="<?php echo $store['brand_id'];?>"><?php echo $store['brand_name'];?></option>
			</select>
		</div>
	</div>
</div>
<script>
$(function(){
	$("#search_brand").keyup(
			function(){
					console.log($(this).val());
					post("<?php echo base_url('api/brand_list');?>",
							{"search_key":$(this).val()},
							function(data){
									if(data.err_num == 0){
											var mall = data.results.records;
											var options_str = c_option(0,"品牌");
											for(var x in mall){
													options_str += c_option(mall[x]['id'],mall[x]['name']);
												}
											$("#brand_id").empty();
											$("#brand_id").append(options_str);
											
										}else{
											options_str = c_option(0,"品牌关键字下没有品牌");
											$("#brand_id").empty();
											$("#brand_id").append(options_str);
											}
								});
				}
		);
});
</script>	
		</div>
		<br>
<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">品类</p>
</div>
<div class="col-sm-12">
<div class="checkbox">
<?php
//品牌风格
global $CATEGORY;
foreach ($CATEGORY as $key => $value){
	$checked = false;
	foreach ($store['store_category'] as $k => $v){
		if( $k == $key){
			$checked = true;
		}
	}
	if($checked){
		echo "<label><input type='checkbox' name='brand_style' value='$key' checked>$value</label>&nbsp;&nbsp;&nbsp;";
	}else{
		echo "<label><input type='checkbox' name='brand_style' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
	}
}
?>
</div>
</div>
</div>
		<div class="row">
			<div class="col-sm-12">
				<p class="bg-info form-square-title">商铺图片</p>
			</div>
			<div class="col-sm-12">
				<div class="row">

	<div class = "col-sm-4">
		<div id="fileupload">
			<input type="file" id="file" name="file" />
		</div>
	</div>
	
	<div class = "col-sm-2">
		<input type="button" class = "btn btn-primary" id="btnUpload" value="上传图片" />
	</div>
	
</div>

<br>
<div class="row">
	<div class = "col-sm-12">
		<div id="img">
			<!--//放缩略图的地方 -->
			<?php if($store['store_photo']):?>
				<img alt="图片" src="<?php echo $store['store_photo'][0];?>" height = "100px">
			<?php endif;?>
		</div>
	</div>
</div>
<br>
<script>
	$(function(){
		//上传文件事件
		$("#btnUpload").click(function(){
		    $.ajaxFileUpload({
	            url: '<?php echo base_url('file/upload');?>',
	            type: 'post',
	            secureuri: false, //一般设置为false
	            fileElementId: 'file', // 上传文件的id、name属性名
	            dataType: 'json', //返回值类型，一般设置为json、application/json
	            success: function(data, status){
	               var img = $("<img src ='"+data[0]+"'  height=100 class='photo'>");
	               $("#img").empty();
	               $("#img").append(img);
	            },
	            error: function(data, status, e){
	            	layer.alert("您还未上传文件!");
	                console.log(data);
	            }
	        });
		});
		});
</script>
			</div>
		</div>
<br>
		<div class="form-group form_btn_line">
			<div class="col-sm-3 col-sm-offset-4 text-center">
				<button class="btn btn-primary btn-block" id="add_store" value="0">修改商铺</button>
			</div>
		</div>
	</div>
	<br><br><br><br><br>
	<script type="text/javascript">
$(function(){
	//添加商铺
	$("#add_store").on("click",function(){
			var store_info = {};
			store_info.store_name = $("#store_name").val();
			store_info.store_addr = $("#store_addr").val();
			store_info.store_phone = $("#store_phone").val();
			store_info.store_opening_hours = $("#store_opening_hours").val();
			store_info.mall_floor_id = $("#mall_floor_id").val();
			store_info.brand_id = $("#brand_id").val();
			store_info.category = [];
			$("input[type=checkbox]:checked").each(function(){
					store_info.category.push($(this).val());
				});
			store_info.store_photo = get_img("img");
			store_info.store_id = "<?php echo $store['store_id'];?>";
			console.log(store_info);
			post("<?php echo base_url('api/store_edit');?>",
					store_info,
					function(data){
						console.log(data);
						if(data.err_num == 0){
								location.href = "<?php echo base_url('store/store');?>";
							}
						else{
								layer.msg("修改失败请重试!");
							}
				}
					);
		});

	$("#search_brand").keyup(
			function(){
					console.log($(this).val());
					post("<?php echo base_url('api/brand_list');?>",
							{"search_key":$(this).val()},
							function(data){
									if(data.err_num == 0){
											var mall = data.results.records;
											var options_str = c_option(0,"品牌");
											for(var x in mall){
													options_str += c_option(mall[x]['id'],mall[x]['name']);
												}
											$("#brand_id").empty();
											$("#brand_id").append(options_str);
											
										}else{
											options_str = c_option(0,"品牌关键字下没有品牌");
											$("#brand_id").empty();
											$("#brand_id").append(options_str);
											}
								});
				}
		);
	
});
</script>
	<!-- row -->
</div>
<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<?php $this->load->view('common/footer');?> 








