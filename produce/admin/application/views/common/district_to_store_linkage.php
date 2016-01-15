<?php //从商圈到商铺的联动组件?>
<div class="row">
	<div class="form-group col-sm-2">
				<select class="form-control" id = "district_id" name="district_id">
					<option value=0>商圈</option>
					<?php
						foreach ($district as $value){
							echo "<option value=$value[id]>$value[name]</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group col-sm-2">
				<select class="form-control" id='mall_id'>
					<option value=0>商场</option>
				</select>
			</div>
			<div class="form-group col-sm-2">
				<select class="form-control" id="mall_floor_id">
					<option value=0>商场楼层</option>
				</select>
			</div>
			<div class="form-group col-sm-1">
				<p style="margin-top:5px;">或者</p>
			</div>
			<div class="form-group col-sm-2">
				<select class="form-control" id="street_id">
					<option value=0>商业街</option>
				</select>
			</div>
			<div class="form-group col-sm-3">
				<select class="form-control" id="store_id">
					<option value=0>商铺</option>
				</select>
			</div>
</div>

<script>
$(function(){
	//商圈　－　商场联动
	$("#district_id").bind("change", function () {
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
								options_str = c_option(0,"商圈下没有商场");
								$("#mall_id").empty();
								$("#mall_id").append(options_str);
								}
					});
		post("<?php echo base_url('api/street_lists');?>",
				{"district_id":$(this).val()},
				function(data){
						if(data.err_num == 0){
								var mall = data.results.records;
								var options_str = c_option(0,"商业街");
								for(var x in mall){
										options_str += c_option(mall[x]['street_id'],mall[x]['street_name']);
									}
								$("#street_id").empty();
								$("#street_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该商场下没有商业街");
								$("#street_id").empty();
								$("#street_id").append(options_str);
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
							var options_str = c_option(0,"楼层");
							for(var x in mall){
									options_str += c_option(mall[x]['mall_floor_id'],mall[x]['mall_floor_name']);
								}
							$("#mall_floor_id").empty();
							$("#mall_floor_id").append(options_str);
							
						}else{
							options_str = c_option(0,"该商场没有楼层");
							$("#mall_floor_id").empty();
							$("#mall_floor_id").append(options_str);
							}
				});
});

//商场楼层　－　商铺联动
$("#mall_floor_id").bind("change",function(){
	post("<?php echo base_url('api/store_lists');?>",
			{"mall_floor_id":$(this).val()},
			function(data){
					if(data.err_num == 0){
							var mall = data.results.records;
							var options_str = c_option(0,"商铺");
							for(var x in mall){
									options_str += c_option(mall[x]['store_id'],mall[x]['store_name']);
								}
							$("#store_id").empty();
							$("#store_id").append(options_str);
							
						}else{
							options_str = c_option(0,"楼层没有商铺");
							$("#store_id").empty();
							$("#store_id").append(options_str);
							}
				});
});

//商业街　－　商铺联动
$("#street_id").bind("change",function(){
	post("<?php echo base_url('api/store_lists');?>",
			{"street_id":$(this).val()},
			function(data){
					if(data.err_num == 0){
							var mall = data.results.records;
							var options_str = c_option(0,"商铺");
							for(var x in mall){
									options_str += c_option(mall[x]['store_id'],mall[x]['store_name']);
								}
							$("#store_id").empty();
							$("#store_id").append(options_str);
							
						}else{
							options_str = c_option(0,"该商业街没有商铺");
							$("#store_id").empty();
							$("#store_id").append(options_str);
							}
				});
});
});
</script>











