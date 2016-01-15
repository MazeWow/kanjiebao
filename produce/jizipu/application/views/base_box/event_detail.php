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
		<input class="form-control" placeholder="商品名称" id="product_name" value= ""/>
		<input class="form-control" placeholder="商品原价" id="price"/>
		<input class="form-control" placeholder="促销价" id="promote_price"/>
	</div>
	
	<div class="col-sm-12">
	<br>
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
			</div>
		</div>
	</div>
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
               $("#img").append(img);
            },
            error: function(data, status, e){
                console.log(data);
            }
        });
	});
	//添加活动商品事件
	$("#event_product_add").on("click",function(){
			var product_name = $("#product_name").val();
			var price = $("#price").val();
			var promote_price = $("#promote_price").val();
			var product_desc  = $("#product_desc").val();
			var event_id = <?=$event['event_id']?>;
			var product_cate= $('input[name="product_cate"]:checked').val();
			var photo = [];
			$("#img img").each(function(){
					photo.push($(this).attr("src"));
				});
			if(photo.toString() == ''){
					layer.alert("请上传品牌商图片！");
					is_ajax = false;
					return;
				}

			product_data = {
						product_name:product_name,
						price:price,
						promote_price:promote_price,
						product_desc:product_desc,
						event_id:event_id,
						photo:photo,
						product_cate:product_cate
						
					};
			console.log(product_data);
			post("<?=base_url('api/event_product_add')?>",
					product_data,
					function(data){
						if(data.err_num == 0){
								layer.alert("添加活动商品成功");
								windows.location.reload();
							}
				});
		});

	
});
</script>
<?php $this->load->view('common/box_footer.php');?>