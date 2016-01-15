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
<p class="bg-info form-square-title">商品详细信息</p>
</div>
<div class="col-sm-12">
	<div class="form-inline">
		<input class="form-control" placeholder="商品名称" id="product_name" value='<?=$product['name']?>'/>
		<input class="form-control" placeholder="商品原价" id="price" value='<?=$product['price']?>'/>
		<input class="form-control" placeholder="促销价" id="promote_price"  value='<?=$product['promote_price']?>'/>
	</div>
	
	<div class="col-sm-12">
	<br>
</div>
</div>
<div class="col-sm-12">
<p class="bg-info form-square-title">商品描述</p>
<textarea class="form-control" rows="3" id="product_desc"><?php echo $product['product_desc'];?></textarea>
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
					if($key == $product['cate_id_str']){
						echo "<label><input type='radio' name='product_cate' value='$key' checked>$value</label>&nbsp;&nbsp;&nbsp;";
						continue;
					}
					echo "<label><input type='radio' name='product_cate' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
				}
			?>
  		</div>
</div>
</div>

<br>
	<div class="row">
		<div class="col-sm-12">
			<p class="bg-info form-square-title">商品图片&nbsp;&nbsp;&nbsp;
			<button class='btn btn-xs btn-success' id='change_product_photo'>替换商品图片</button></p>
		</div>
	</div>
	<div id="upload_product_file" style="display:none;">
		<div class="row" >
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
	</div>
	<div class="row" id="product_photo">
		<div class = "col-sm-12">
			<img src = "<?php echo $product['photo'];?>" height='100px'/>
		</div>
	</div>
	<!-- 轮播图 -->
	<div class="row">
		<div class="col-sm-12">
			<p class="bg-info form-square-title">商品详情图片&nbsp;&nbsp;&nbsp;
				<button class='btn btn-xs btn-success' id='change_product_detail_photo'>替换商品详情图片</button>
			</p>
		</div>
	</div>
		<div class="row" id="upload_product_detail_photo" style="display:none;">
		<div class = "col-sm-4">
				<input type="file" id="add_product_photo" name="add_product_photo"/>
		</div>
		<div class = "col-sm-2">
			<input type="button" class = "btn btn-primary" id="add_product_photo_btn" value="上传图片" />
		</div>
		</div>
		<div class="row" id="product_detail_photo">
			<div class="col-sm-12">
				<?php foreach ($product['product_photos'] as $img_url):?>
					<img alt="商品详情图片" src="<?php echo $img_url;?>" width="100px;" style="border: 2px solid #aaa;">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php endforeach;?>
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
						<button class="btn btn-primary btn-block" id="event_product_add" value="0">确认修改商品</button>
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

	//
	$("#change_product_detail_photo").on("click",function(){
			var css_display = $("#upload_product_detail_photo").css('display');
			if(css_display == "none"){
					$("#upload_product_detail_photo").css('display','block');
					$("#product_detail_photo").css('display','none');
				}else{
					$("#upload_product_detail_photo").css('display','none');
					$("#product_detail_photo").css('display','block');
					}
		});
	

	//
	$("#change_product_photo").on("click",function(){
			var css_display = $("#upload_product_file").css('display');
			if(css_display == 'none'){
					$("#upload_product_file").css('display','block');
					$("#product_photo").css('display','none');
				}else{
					$("#upload_product_file").css('display','none');
					$("#product_photo").css('display','block');
					}
		});
	

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
			var product_cate= $('input[name="product_cate"]:checked').val();

			//获取 商品在活动页面的 展示图
			var photo = [];
			photo = get_img("img","请上传品牌商图片！");
		
			//获取商品的轮播图
			var product_photos = [];
			product_photos = get_img("product_photos","请上传商品详情图!");

			product_data = {
						product_id:<?php echo $product['id'];?>,
						product_name:product_name,
						price:price,
						promote_price:promote_price,
						product_desc:product_desc,
						photo:photo,
						product_cate:product_cate,
						product_photos:product_photos
					};
			for(var x in product_data){
						if(!product_data[x]){
								delete product_data[x];		
							}
				}
			console.log(product_data);
			post("<?=base_url('api/event_product_edit')?>",
					product_data,
					function(data){
						console.log(data);
						if(data.err_num == 0){
// 								layer.alert("添加活动商品成功");
								window.location.reload();
							}
				});
		});

	
});
</script>

<?php $this->load->view('common/box_footer.php');?>