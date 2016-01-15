<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base')?>">基础管理</a></li>
					<li><a href="<?=base_url('base/city')?>">商铺层级</a></li>
					<li class="active">添加</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
				<div class="row" id="main_page">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">品牌基本信息</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="brand_name"
							required="required" placeholder="品牌名称" />
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div id = "tips">
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-1 has-feedback">
						品牌风格
					</div>
					<div class="form-group col-sm-11 has-feedback">
						<div class="checkbox">
							<?php
								//品牌风格
								global $STYLE;
								foreach ($STYLE as $key => $value){
									echo "<label><input type='checkbox' name='brand_style' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
								}
							?>
  						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">品牌logo信息</p>
					</div>
				</div>
				<div class="row">
					<div class = "col-sm-1">
						品牌logo
					</div>
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
			</div>
			<div class="col-md-12">
				<div class="form-group form_btn_line">
					<div class="col-sm-3 col-sm-offset-5 text-center">
						<button class="btn btn-primary btn-block" id="add_brand" value="0">添加品牌</button>
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
			</div>
		</div>
		<!-- row -->
	</div>
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
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
               $("#img").append(img);
            },
            error: function(data, status, e){ 
                console.log(data);
            }
        });
	});

	//查询是否有此品牌
	$("#brand_name").keyup(
			function(data){
						console.log($("#brand_name").val());
						post("<?php echo base_url("api/brand_search");?>",
								{"brand_name":$("#brand_name").val()},
								function(data){
										if(data.err_num == 0){
												$("#tips").append("<p style='color:red;'>该品牌已经有了，您确定要添加么?</p>");
											}else{
												$("#tips").empty();
												}
										console.log(data);
									});
				}
				
			);

	//添加品牌事件
	$("#add_brand").on('click',function(){
			var is_ajax = true;
			var brand_name = $("#brand_name").val();
		
			//获取品牌商风格
			var brand_style = [];
			$("input[type=checkbox]:checked").each(function(){
					brand_style.push($(this).val());
				}); 
			console.log(brand_style);

			//获取活动图片
			brand_photo = [];
			$("#img img").each(function(){
					brand_photo.push($(this).attr("src"));
				});
			if(brand_photo.toString() == ''){
					layer.alert("请上传品牌商图片！");
					is_ajax = false;
					return;
				}
			
			var brand_data = {
					'brand_name':brand_name,
					'brand_style':brand_style,
					'brand_photo':brand_photo
					};
			console.log(brand_data);
			if(is_ajax){
				$.ajax({
					url:'<?php echo base_url('base/ajax_add_brand');?>',
					data:brand_data,
					dataType:'json',
					method:'post',
					success:function(data,textStatus,xmlHttpRequest){
							console.log(data);
							if(data.err_num == 0){
									layer.alert("添加活动成功");
								}
						}
					});
			}
			
			
		});
//end of $();	
});
</script>
<?php $this->load->view('common/footer');?> 