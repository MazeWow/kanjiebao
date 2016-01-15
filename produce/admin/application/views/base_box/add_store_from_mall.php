<?php $this->load->view('common/box_header.php');?>
<div class="container-fluid">
<div class="row" id="main_page">
<br>
<div class="col-md-12">
<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">商铺路径</p>
</div>
</div>
<div class="row">
<div class="col-md-12">
		<div class="form-inline">
			<div class="form-group">
				<select class="form-control"  name="district_id" id = "district_id">
					<option value=0 >商圈</option>
					<?php
							foreach ($district as $value){
								echo "<option value=$value[id]>$value[name]</option>";
							}
 					?>
				</select>
			</div>
			<div class="form-group">
				<select class="form-control"  name="mall_id" id = "mall_id">
					<option value=0 >商场</option>
				</select>
			</div>
			<div class="form-group">
				<select class="form-control"  name="mall_floor_id" id = "mall_floor_id">
					<option value=0 >楼层</option>
				</select>
			</div>
		</div>
		
</div>
</div>
<br>
<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">商铺品牌</p>
</div>
<div class="col-sm-12">
	<div class="form-inline">
		<div class="form-group">
			<input class="form-control" placeholder="品牌关键字" id="search_brand"/>
		</div>
		<div class="form-group">
				<select class="form-control"  name="brand_id" id = "brand_id">
					<option value=0 >品牌</option>
					<?php
							foreach ($brand as $value){
								echo "<option value=$value[id]>$value[name]</option>";
							}
 					?>
				</select>
		</div>
	</div>
</div>
</div>
<br>
<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">商铺品类</p>
</div>
<div class="col-sm-12">
		<div class="checkbox">
			<?php
				//品牌风格
				global $CATEGORY;
				foreach ($CATEGORY as $key => $value){
					echo "<label><input type='checkbox' name='brand_style' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
				}
			?>
  		</div>
</div>

</div>
<br>
<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">商铺名称</p>
</div>
<div class="col-sm-12">
	<div class="form-inline">
		<input class="form-control" placeholder="商铺名称" id="store_name"/>
	</div>
	<div class="col-sm-12">
	<br>
<div class="form-group form_btn_line">
	<div class="col-sm-3 col-sm-offset-4 text-center">
		<button class="btn btn-primary btn-block" id="add_store" value="0">添加商铺</button>
	</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
<script type="text/javascript">
$(function(){

	//商圈　－　商场联动
	$("#district_id").bind("change",function(){
			post("<?php echo base_url('api/mall_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商铺");
									for(var x in mall){
											options_str += c_option(mall[x]['mall_id'],mall[x]['mall_name']);
										}
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									
								}else{
									options_str = c_option(0,"该商场下没有商铺");
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
								var options_str = c_option(0,"商铺");
								for(var x in mall){
										options_str += c_option(mall[x]['mall_floor_id'],mall[x]['mall_floor_name']);
									}
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该商场下没有商铺");
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								}
					});
	});

	//品牌页数　－　品牌联动
// 	$("#brand_pager").bind("change",function(){
//		post("<?php echo base_url('api/brand_list');?>",
// 				{"page_now":$(this).val()},
// 				function(data){
// 						if(data.err_num == 0){
// 								var mall = data.results.records;
// 								var options_str = c_option(0,"品牌");
// 								for(var x in mall){
// 										options_str += c_option(mall[x]['id'],mall[x]['name']);
// 									}
// 								$("#brand_id").empty();
// 								$("#brand_id").append(options_str);
								
// 							}else{
// 								options_str = c_option(0,"该页下没有品牌");
// 								$("#brand_id").empty();
// 								$("#brand_id").append(options_str);
// 								}
// 					});
// 	});

	//添加商铺
	$("#add_store").on("click",function(){
// 			alert("heheh");
			//获取　mall_floor
			var mall_floor_id = $("#mall_floor_id").val();
			//获取　brand
			var brand_id = $("#brand_id").val();
			//获取品类
			var category = [];
			$("input[type=checkbox]:checked").each(function(){
					category.push($(this).val());
				});
			//获取名称
			var store_name = $("#store_name").val();
			console.log(mall_floor_id+brand_id);
			console.log(category);
			console.log(store_name);
			post_data = {'mall_floor_id':mall_floor_id,'brand_id':brand_id,'category':category,'store_name':store_name};
			post("<?php echo base_url('api/store_add');?>",
					post_data,
					function(data){
						if(data.err_num == 0){
								layer.alert("添加商铺成功，请刷新！");
								windows.location.reload();
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

<?php $this->load->view('common/box_footer.php');?>