<div class="col-sm-12">
	<div class="form-inline">
		<div class="form-group">
			<input class="form-control" placeholder="品牌关键字" id="search_brand" />
		</div>
		<div class="form-group">
			<select class="form-control" name="brand_id" id="brand_id">
				<option value=0>品牌</option>
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