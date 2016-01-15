<?php $this->load->view('common/box_header.php');?>
<div class="container-fluid">
	<div class="row" id="main_page">
		<br>
		<div class="col-md-12">

			<div class="row">
				<div class="col-sm-12">
					<p class="bg-info form-square-title">商铺名称</p>
				</div>
				<div class="col-sm-12">
					<div class="form-inline">
						<input class="form-control" placeholder="商铺名称" id="store_name"
							value="<?=$store_info['store_name']?>" />
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12">
					<p class="bg-info form-square-title">
						商铺路径 : <span><?=$store_info['district_name']?></span> -- <span><?=$store_info['mall_name']?></span>
						-- <span><?=$store_info['floor_name']?></span> &nbsp;&nbsp;&nbsp;
						<button class="btn btn-xs btn-success" id="change_mall_floor_btn">更改商铺路径</button>
					</p>

				</div>
			</div>
			<div class="row" style="display: none;" id='change_mall_floor'>
				<?php $this->load->view('store_box/district_mall_floor');?>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<p class="bg-info form-square-title">
						商铺品牌: <span><?=$store_info['brand_name']?></span>
						&nbsp;&nbsp;&nbsp;
						<button class="btn btn-xs btn-success" id="change_brand_btn">更改品牌</button>
					</p>
				</div>
				<div class="col-sm-12" id="change_brand" style="display: none;">
				<?php $this->load->view('common/brand_search');?>
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
			$checked_cate = $store_info ['category_id_arr'];
			$checkbox_name = "cate";
			global $CATEGORY;
			foreach ( $CATEGORY as $key => $value ) {
				$is_checked = true;
				foreach ( $checked_cate as $v ) {
					if ($key == $v) {
						echo "<label><input type='checkbox' name='$checkbox_name' checked value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
						$is_checked = false;
					}
				}
				if($is_checked){
					echo "<label><input type='checkbox' name='$checkbox_name' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
				}
				
			}
			?> 
  		</div>
				</div>

			</div>
			<br>
			<div class="col-sm-12">
				<br>
				<div class="form-group form_btn_line">
					<div class="col-sm-3 col-sm-offset-4 text-center">
						<button class="btn btn-primary btn-block" id="store_edit" value="0">确定修改</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){

	//更改商铺路径
	$("#change_mall_floor_btn").on("click",function(){
				$a = $("#change_mall_floor").css('display');
				if($a == 'none'){
					$("#change_mall_floor").css('display','block');
						}else{
					$("#change_mall_floor").css('display','none');
							}
		});

	//change_brand_btn
	$("#change_brand_btn").on("click",function(){
			$a = $("#change_brand").css('display');
			if($a == 'none'){
				$("#change_brand").css('display','block');
					}else{
				$("#change_brand").css('display','none');
						}
	});

	//change  store 
	$("#store_edit").on("click",function(){
			var store_info = {};
			store_info.store_id = "<?=$store_info['store_id']?>";
			store_info.name = $("#store_name").val();
			store_info.mall_floor_id = $("#mall_floor_id").val();
			store_info.brand_id = $("#brand_id").val();
			var category = [];
			$("input[type=checkbox]:checked").each(function(){
					category.push($(this).val());
				});
			store_info.cate_id_arr = category;

			console.log(store_info);
			//過濾下
			for(var x in store_info){
					if(store_info[x] == 0){
							delete store_info[x];
						}
				}
			console.log(store_info);

			post("<?php echo base_url('api/store_update');?>",store_info,function(data){
					if(data.err_num == 0){
								layer.msg("更新商铺成功!");
						}
				});
		});
	
	
	$("#add_store").on("click",function(){
			//获取　mall_floor
			var mall_floor_id = $("#").val();
			//获取　brand
			var brand_id = $("").val();
			//获取品类
			
			//获取名称
			var store_name = $("#store_name").val();
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

	
});
</script>
<?php $this->load->view('common/box_footer.php');?>