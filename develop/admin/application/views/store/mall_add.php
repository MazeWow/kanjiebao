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
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商场名称</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-3 has-feedback">
						<input type="text" class="form-control" id="mall_name"
							required="required" placeholder="商场名称" />
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div id="tips"></div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商场路径</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<select class="form-control" name="district_id"
								id="district_id">
								<option value=0>商圈</option>
											<?php
												foreach ($district as $value){
													echo "<option value=$value[id]>$value[name]</option>";
												}
		 									?>
							</select>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商场图片</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<input type="file" id="file" name="file_text"/>


					</div>
					<div class="col-sm-3">
						<input type="button" class = "btn btn-primary" id="btnUpload" value="上传图片" />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div id="img">
									<!--//放缩略图的地方 -->
							</div>
					</div>
				</div>
			</div>
			<br>
		<div class="col-md-12">
		<div class="form-group form_btn_line">
			<div class="col-sm-3 col-sm-offset-5 text-center">
				<button class="btn btn-primary btn-block" id="add_mall" value="0">添加商场</button>
			</div>
		</div>
		<br> <br> <br> <br> <br>
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
              //如果上传单张图片，可以加上 $("#img").empty();
               $("#img").empty();
               $("#img").append(img);
            },
            error: function(data, status, e){
                layer.alert("您还未选择文件!");
                console.log(data);
            }
        });
	});

	//添加商场事件
	$("#add_mall").on("click",function(){

		var mall_info = {};
		
		//商场名称
		mall_info.name = $("#mall_name").val();
		//商圈 id 
		mall_info.district_id = $("#district_id").val();
		

		//获取活动图片
		mall_info.photo = [];
		$("#img img").each(function(){
				mall_info.photo.push($(this).attr("src"));
			});
		if(mall_info.photo.toString() == ''){
				layer.alert("请上传图片！");
				return;
			}

		console.log(mall_info);

		post("<?=base_url('api/mall_add');?>",
				mall_info,
				function(data){
					console.log(data);
					if(data.err_num == 0){
						location.href = "<?php echo base_url('store/mall')?>";
					}
			});
		
		
		});

	 
	

});
</script>
<?php $this->load->view('common/footer');?> 