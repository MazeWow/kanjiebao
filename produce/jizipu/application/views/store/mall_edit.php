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
							required="required" placeholder="商场名称" value = "<?php echo $mall['mall_name'];?>"/>
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div id="tips"></div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商场路径 : <?php echo $mall['district_name'];?></p>
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
						<p class="bg-info form-square-title">商场图片&nbsp;&nbsp;&nbsp;
						<button class='btn btn-xs btn-success' id='change_mall_photo'>替换商场图片</button></p>
					</div>
				</div>
				<div  id = "mall_photo_upload" style = "display:none;" >
					<?php $this->load->view('common/fileupload_one');?>
				</div>
				<div class = "row" id = "mall_photo">
					<?php if(isset($mall['mall_photo'])):?>
						<?php foreach ($mall['mall_photo'] as $item): ?>
						<div class="col-sm-2">
							<img src ="<?=$item;?>" height="100px"/>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<br>
			</div>
			<br>
		<div class="col-md-12">
		<div class="form-group form_btn_line">
			<div class="col-sm-3 col-sm-offset-4 text-center">
				<button class="btn btn-primary btn-block" id="edit_mall" value="0">修改商场</button>
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

	//
	$("#change_mall_photo").on("click",function(){
			console.log("change mall photo");
			var mall_display = $("#mall_photo_upload").css("display");
			console.log(mall_display);
			if(mall_display == "none"){
					$("#mall_photo_upload").css("display","block");
					$("#mall_photo").css("display","none");
				}else{
					$("#mall_photo_upload").css("display","none");
					$("#mall_photo").css("display","block");
					}
		});


	
	//添加商场事件
	$("#edit_mall").on("click",function(){

		var mall_info = {};
		
		//商场名称
		mall_info.name = $("#mall_name").val();
		//商圈 id 
		mall_info.district_id = $("#district_id").val();

		if( mall_info.district_id == 0){ 
				delete mall_info.district_id;
			}
		

		//获取活动图片
		mall_info.photo = [];
		$("#img img").each(function(){
				mall_info.photo.push($(this).attr("src"));
			});
		if(mall_info.photo.toString() == ''){
				delete  mall_info.photo;
			}

		//
		
		mall_info.mall_id = "<?php echo $mall['mall_id'];?>";
		
		console.log(mall_info);
		post("<?=base_url('api/mall_edit');?>",
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