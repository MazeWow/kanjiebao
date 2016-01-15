<div class="col-md-12">
	<div class="form-inline">
		<div class="form-group">
			<select class="form-control" name="district_id" id="district_id">
				<option value=0>商圈</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="mall_id" id="mall_id">
				<option value=0>商场</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="mall_floor_id" id="mall_floor_id">
				<option value=0>楼层</option>
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