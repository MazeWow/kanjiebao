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
						<input class="form-control" placeholder="商铺名称" id="store_name" />
					</div>
					<div class="col-sm-3">
						<input class="form-control" placeholder="详细地址(F1层-201号 : 只填201号)"
							id="store_addr" />
					</div>
					<div class="col-sm-3">
						<input class="form-control" placeholder="联系电话" id="store_phone" />
					</div>
					<div class="col-sm-3">
						<input class="form-control" placeholder="营业时间(例：9:00 - 22:00)"
							id="store_opening_hours" />
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
	<?php $this->load->view('common/district_mall_floor_select');?>
</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				<p class="bg-info form-square-title">商铺品牌</p>
			</div>
				<?php $this->load->view('common/brand_search');?>	
		</div>
		<br>
<?php $this->load->view('common/category_checkbox');?>

		<div class="row">
			<div class="col-sm-12">
				<p class="bg-info form-square-title">商铺图片</p>
			</div>
			<div class="col-sm-12">
				<?php $this->load->view('common/fileupload_one');?>	
			</div>
		</div>
<br>
		<div class="form-group form_btn_line">
			<div class="col-sm-3 col-sm-offset-4 text-center">
				<button class="btn btn-primary btn-block" id="add_store" value="0">添加商铺</button>
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
			console.log(store_info);
			post("<?php echo base_url('api/store_add');?>",
					store_info,
					function(data){
						if(data.err_num == 0){
								location.href = "<?php echo base_url('store/store');?>";
							}
						else{
								layer.msg("添加商铺失败请重试!");
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








