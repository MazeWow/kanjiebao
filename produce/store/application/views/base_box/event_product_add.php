<?php $this->load->view('common/box_header.php');?>
<div class="container-fluid">
<div class="row" id="main_page">
<br>
<div class="row">

</div>
<div class="col-md-12">
<div class="row">
<div class="col-sm-12">
</div>
<div class="col-sm-12">
<p class="bg-info form-square-title">活动名称 &nbsp;:&nbsp; <?=$event['event_name']?></p>
</div>
<div class="col-sm-12">
	<div class="form-inline">
		<input class="form-control" placeholder="商品名称" id="product_name"/>
		<input class="form-control" placeholder="商品原价" id="price"/>
		<input class="form-control" placeholder="促销价" id="promote_price"/>
	</div>
	
	<div class="col-sm-12">
	<br>
<!-- <div class="form-group form_btn_line"> -->
<!-- 	<div class="col-sm-3 col-sm-offset-4 text-center"> -->
<!-- 		<button class="btn btn-primary btn-block" id="add_store" value="0">添加商铺</button> -->
<!-- 	</div> -->
<!-- </div> -->
</div>
</div>
<div class="col-sm-12">
<p class="bg-info form-square-title">商品描述</p>
<textarea class="form-control" rows="3" id="product_desc"></textarea>
</div>

</div>
<br>
<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">商品品类</p>
</div>
<div class="col-sm-12">
		<div class="checkbox">
			<?php
				global $CATEGORY;
				foreach ($CATEGORY as $key => $value){
					echo "<label><input type='radio' name='product_cate' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
				}
			?>
  		</div>
</div>
</div>

<br>
	<div class="row">
		<div class="col-sm-12">
			<p class="bg-info form-square-title">商品图片</p>
		</div>
	</div>
	<div class="row">
		<div class = "col-sm-4">
				<input type="file" id="file" name="file_text"/>
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
			</div>
		</div>
	</div>
	<br>
	
	
	<!-- 轮播图 -->
	<div class="row">
		<div class="col-sm-12">
			<p class="bg-info form-square-title">商品详情图片</p>
		</div>
	</div>
		<div class="row">
		<div class = "col-sm-4">
				<input type="file" id="add_product_photo" name="add_product_photo"/>
		</div>
		<div class = "col-sm-2">
			<input type="button" class = "btn btn-primary" id="add_product_photo_btn" value="上传图片" />
		</div>
	</div>
	<br>
	<div class="row">
		<div class = "col-sm-12">
			<div id="product_photos">
				<!-- 放置商品详情图片 -->
			</div>
		</div>
	</div>
	
	<!-- 添加商品按钮 -->
				<br>
				<div class="col-md-12">
				<div class="form-group form_btn_line">
					<div class="col-sm-3 col-sm-offset-4 text-center">
						<button class="btn btn-primary btn-block" id="event_product_add" value="0">添加商品</button>
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
			</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function(){

	//上传活动商品展示图
	file_component("btnUpload","<?php echo base_url('file/upload');?>","file","img");

	//上传活动轮播图
	file_component("add_product_photo_btn","<?php echo base_url('file/upload');?>","add_product_photo","product_photos");
	
	//添加活动商品事件
	$("#event_product_add").on("click",function(){
			var product_name = $("#product_name").val();
			var price = $("#price").val();
			var promote_price = $("#promote_price").val();
			var product_desc  = $("#product_desc").val();
			var event_id = <?=$event['event_id']?>;
			var product_cate= $('input[name="product_cate"]:checked').val();

			//获取 商品在活动页面的 展示图
			var photo = [];
			photo = get_img("img","请上传品牌商图片！");
		
			//获取商品的轮播图
			var product_photos = [];
			product_photos = get_img("product_photos","请上传商品详情图!");

			product_data = {
						product_name:product_name,
						price:price,
						promote_price:promote_price,
						product_desc:product_desc,
						event_id:event_id,
						photo:photo,
						product_cate:product_cate,
						product_photos:product_photos
					};
			console.log(product_data);
			post("<?=base_url('api/event_product_add')?>",
					product_data,
					function(data){
						if(data.err_num == 0){
								layer.alert("添加活动商品成功");
								window.location.reload();
							}
				});
		});

	
});
</script>

<?php $this->load->view('common/box_footer.php');?>