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
					<li><a href="<?=base_url('store/district')?>">商户管理</a></li>
					<li><a href="<?=base_url('store/district')?>">商圈管理</a></li>
					<li class="active">添加商圈</li>
				</ol>
			</div>
		</div>
		<div class="row" id="main_page">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商圈基本信息</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="district_name" value="<?=$district['name']?>"
							required="required" placeholder="商圈名称" />
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="Longitude"
							required="required" placeholder="商圈经度" value = "<?=$district['Longitude']?>"/>
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="Latitude"
							required="required" placeholder="商圈纬度" value = "<?=$district['Latitude']?>"/>
					</div>
				</div>
			</div>
			<!-- 活动图片信息 -->
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商圈图片信息&nbsp;&nbsp;&nbsp;
						<button class='btn btn-xs btn-success' id='change_district_photo'>替换图片</button>
						</p>
					</div>
				</div>
					<div class = "row" id = "upload_district_file" style= "display:none;">
						<div class="col-sm-12">
						<?php $this->load->view("common/fileupload_one");?>
						</div>
					</div>
					<div class = "row" id="district_photo">
						<div class="col-sm-12">
							<img src = "<?php echo $district['photo'][0];?>" height="100px"/> 
						</div>
					</div>
				<br>
			</div>
				<div class="form-group">
					<div class="col-sm-3 col-sm-offset-0 text-center">
						<button class="btn btn-primary btn-block" id="edit_district" value="0">确认编辑商圈</button>
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
		</div>
	</div>
	<!-- container-fluid -->
</div>
<script>
$(function(){
	//替换商场图片事件
	$("#change_district_photo").on("click",function(){
			var a = $("#upload_district_file").css("display");
			console.log(a);
			if(a == 'none'){
					$("#upload_district_file").css("display",'block');
					$("#district_photo").css("display",'none');
				}
			else{
					$("#upload_district_file").css("display",'none');
					$("#district_photo").css("display",'block');
				}
		});
	


	
//add district
$("#edit_district").on("click",function(){

	district_info  = {};
	//

	district_info.district_name = $("#district_name").val();
	district_info.Longitude = $("#Longitude").val();
	district_info.Latitude = $("#Latitude").val();

	district_info.district_photo = [];
	$("#img img").each(function(){
			district_info.district_photo.push($(this).attr("src"));
		});
	if(district_info.district_photo.toString() == ''){
			delete district_info.district_photo;
		}

	district_info.district_id = "<?php echo $district['id'];?>";
	console.log(district_info );

	post(
			"<?php echo base_url('api/district_edit');?>",
			district_info,
			function(data){
					console.log(data);
					location.href = "<?php echo base_url("store/district");?>";
				});
	
});



	
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