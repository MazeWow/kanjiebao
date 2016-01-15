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
					<li><a href="<?=base_url('event/lists')?>">活动管理</a></li>
					<li><a href="<?=base_url('event/lists')?>">活动管理</a></li>
					<li class="active">添加活动</li>
				</ol>
			</div>
		</div>
		<div class="row" id="main_page">
		
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">活动基本信息</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="event_name"
							required="required" placeholder="活动名称" />
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div class = "col-sm-4">
							<p>开始时间</p>
						</div>
						<div class = "col-sm-8">
							<input type="date" class="form-control" id='stime' required="required">
						</div>
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div class = "col-sm-4">
							<p>结束时间</p>
						</div>
						<div class = "col-sm-8">
							<input type="date" class="form-control" id='etime' required="required">
						</div>
					</div>
				</div>
			</div>
			
			
			<!-- 商铺路径 -->
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商铺路径</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?php $this->load->view("common/district_to_store_linkage");?>
					</div>
				</div>
			</div>
			
			<!-- 活动图片信息 -->
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">活动图片信息</p>
					</div>
				</div>
					<?php $this->load->view("common/fileupload_one");?>
				<br>
			</div>

			<div class="col-md-12">
			<!-- 品类 -->
				<div class="row">
<div class="col-sm-12">
<p class="bg-info form-square-title">参与活动的品类</p>
</div>
<div class="col-sm-12">
<div class="checkbox">
<?php
//品牌风格
global $CATEGORY;
foreach ($CATEGORY as $key => $value){
	echo "<label><input type='checkbox' name='brand_style' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
}
?>
</div>
</div>
</div>
			
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">活动详细描述</p>
					</div>
				</div>
				<div class="row" style="width: 99.5%; margin: 0 auto;">
					<input name="desc_cribe" id="desc_cribe"></input>
				</div>
				<div class="form-group form_btn_line">
					<div class="col-sm-3 col-sm-offset-5 text-center">
						<button class="btn btn-primary btn-block" id="add_event" value="0">添加活动</button>
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
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<script>
$(function(){
	//初始化编辑器
	CKEDITOR.replace( 'desc_cribe' );



        //获取活动信息，然后提交
        $("#add_event").on("click",function(){
            		var event = {"name":'',"etime":'',"stime":'','store_id':''};
            		var is_ajax = true;
            		event.name = $("#event_name").val();
					if(event.name == ""){
						layer.msg("请填写活动名称");
						return;
					}
					event.stime = $("#stime").val();
					if(event.stime == ""){
						layer.msg("请填写活动开始时间");
						return;
					}
            		event.etime = $("#etime").val();
					if(event.etime == ""){
						layer.msg("请填写活动结束时间");
						return;
					}
					event.store_id = $("#store_id").val();
					if(event.store_id == "0"){
							layer.msg("请选择商铺!");
							return;
						}
					//获取编辑器内容
					event.desc_cribe = CKEDITOR.instances.desc_cribe.getData();

					//获取活动图片
					event.photo = [];
					$("#img img").each(function(){
							event.photo.push($(this).attr("src"));
						});
					if(event.photo.toString() == ''){
							layer.alert("请上传活动图片！");
							is_ajax = false;
							return;
						}
					
					//获取活动品类
					event.brand_style = [];
					$("input[type=checkbox]:checked").each(function(){
						event.brand_style.push($(this).val());
					});
					for(var x in event){
							if(!event[x]){
									layer.alert("还有必填参数没填写!");	
									break;
								}
						}
					console.log(event);
					post("<?php echo base_url('api/event_add');?>",
							event,
							function(data){
								console.log(data);
								if(data.err_num == 0){
 										layer.msg("添加活动成功");
//										location.href = "<?php echo base_url('event/lists');?>";
									}
						});
            });
        

});

</script>
<?php $this->load->view('common/footer');?>