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
							required="required" placeholder="活动名称"
							value="<?php echo $event['event_name'] ;?>" />
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div class="col-sm-4">
							<p>开始时间</p>
						</div>
						<div class="col-sm-8">
							<input type="date" class="form-control" id='stime'
								required="required"
								value="<?php echo date("Y-m-d",$event["stime"]);?>">
						</div>
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div class="col-sm-4">
							<p>结束时间</p>
						</div>
						<div class="col-sm-8">
							<input type="date" class="form-control" id='etime'
								required="required"
								value="<?php echo date("Y-m-d",$event["etime"]);?>">
						</div>
					</div>
				</div>
			</div>
			<!-- 商铺路径 -->
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商铺路径&nbsp;&nbsp;&nbsp;<?php
						echo ":" . $event ["store_info"] ["district_name"];
						echo "--";
						if (isset ( $event ["store_info"] ["mall_name"] )) {
							echo $event ["store_info"] ["mall_name"];
						}
						echo "--";
						if (isset ( $event ["store_info"] ["floor_name"] )) {
							echo $event ["store_info"] ["floor_name"];
						}
						echo "--";
						if (isset ( $event ["store_info"] ["street_name"] )) {
							echo $event ["store_info"] ["street_name"];
						}
						echo "--";
						if (isset ( $event ["store_info"] ["store_name"] )) {
							echo $event ["store_info"] ["store_name"];
						}
						?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class='btn btn-xs btn-success' id='edit_store_url'>编辑商铺路径</button>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" id="district_to_store_linkage"
						style="display: none;">
						<?php $this->load->view("common/district_to_store_linkage");?>
					</div>
				</div>
			</div>
			<!-- 活动图片信息 -->
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">
							活动图片信息
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<button class='btn btn-xs btn-success' id='change_event_photo'>替换活动图片</button>
						</p>

					</div>
				</div>
				<div class="col-sm-12" id="file_upload" style="display: none;">
					<?php $this->load->view("common/fileupload_one");?>
				</div>
				<div id="photo_now">
					<img alt="活动图片" src="<?php echo $event["event_photo"][0];?>"
						width="200">
				</div>
				<br>
			</div>

			<div class="col-md-12">
				<!-- 品类 -->
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">品类</p>
					</div>
					<div class="col-sm-12">
						<div class="checkbox">
<?php
global $CATEGORY;
foreach ( $CATEGORY as $key => $value ) {
	if (!empty($event['store_info']["category_id_arr"])){
		$is_checked = true;
		foreach ($event['store_info']["category_id_arr"] as $cate){
			if($key == $cate){
				echo "<label><input type='checkbox' name='brand_style' checked value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
				$is_checked = false;
				break;
			}
		}
		if($is_checked){
			echo "<label><input type='checkbox' name='brand_style' value='$key'>$value</label>&nbsp;&nbsp;&nbsp;";
		}
		
	}
}
?>
</div>
</div>
</div>
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">活动详细描述
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class='btn btn-xs btn-success' id='change_event_desc'>更改活动描述</button>
						</p>
					</div>
				</div>
				<div id = "event_desc">
					<?php echo $event["event_describe"];?>
				</div>
				<div id="ck_editor" style="display:none">
					<div class="row" style="width: 99.5%; margin: 0 auto;">
						<input name="desc_cribe" id="desc_cribe" value="<?php echo $event["event_describe"];?>"></input>
					</div>
				</div>
				
				
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">活动商品信息</p><!--     //写功能名称 -->
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12"><!--      //里面写表单code.....或者其他 -->
						<?php 
							if(isset($event['product'])){
								foreach ($event['product'] as $p){
									$product_img = $p['photo'];
									$product_id = $p['id'];
									echo "<div class = 'col-sm-2'>
									<div style='border:2px solid #31A4D9;height:250px;text-align:center;padding-top:10px;'>
									<img src = '$product_img' width = '100px'/>
									<p>{$p['name']}</p>
									<button class='edit_product btn btn-xs btn-primary'value = '$product_id'>编辑</button>
									<button class='delete_product btn btn-xs btn-danger'value='$product_id'>删除</button>
									</div>
									</div>";
								}
							}
							
						?>
					</div>
					<br>
				</div>
			</div>
			<br>
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3"><!--      //里面写表单code.....或者其他 -->
						<button class="btn btn-primary btn-block" id="add_event" value="0">确认修改</button>
					</div>
				</div>
				<br> <br> <br> <br> <br><br> <br> <br> <br> <br>
		</div>
			
	<!-- main_page -->
	
	</div>
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<script>
$(function(){

	//编辑商品
	$(".edit_product").on("click",function(){
			var product_id = $(this).val();		
			console.log(product_id);
			var event_product_edit_url = "<?php echo base_url('event/event_product_edit');?>"+"?product_id="+product_id;
			layer.open({
		        type: 2,
		        title: '编辑活动商品',
		        maxmin: true,
		        shadeClose: true,
		        area : ['800px' , '520px'],
		        content: event_product_edit_url,
		        end:function(){
	//	        		window.location.reload();
			        }
			});
		});

	
	//删除商品
	$(".delete_product").on("click",function(){
				var product_id = $(this).val();
				console.log(product_id);
				post("<?php echo base_url("api/delete_event_product")?>",
						{"product_id":product_id},
							function(data){
								console.log(data);
								window.location.reload();
							}
						);
		});
	//初始化编辑器
	CKEDITOR.replace( 'desc_cribe' );
	//获取活动信息，然后提交
        $("#add_event").on("click",function(){
            		var event = {};
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
							delete event.store_id;
							console.log("不修改商铺!");
						
						}
					//获取编辑器内容
					event.desc_cribe = CKEDITOR.instances.desc_cribe.getData();
					if(event.desc_cribe == ""){
						delete event.desc_cribe;
						console.log("不修改活动描述");
					}
					console.log(event);
					//获取活动图片
					event.photo = [];
					$("#img img").each(function(){
							event.photo.push($(this).attr("src"));
						});
					if(event.photo.toString() == ''){
// 							layer.alert("请上传活动图片！");
							console.log("不替换活动图片!");
							delete event.photo;
						}
					console.log(event);
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
					
					//活动id 
					event.event_id = "<?php echo $event['event_id'];?>";
					
					post("<?php echo base_url('api/event_edit');?>",
							event,
							function(data){
								console.log(data);
								if(data.err_num == 0){
 										layer.msg("修改活动成功!");
 										setTimeout(function(){window.location.reload();},1000);
									}
						});
            });
});

//是否修改商铺
$("#edit_store_url").on("click",function(){
	 var a =  $("#district_to_store_linkage").css('display');
	 if(a == "none"){
		 $("#district_to_store_linkage").css('display',"block");
	 }else{
		 $("#district_to_store_linkage").css('display',"none");
	}
});



//是否重新上传图片?
$("#change_event_photo").on("click",function(){
	 var a =  $("#file_upload").css('display');
	 if(a == "none"){
		 $("#file_upload").css('display',"block");
		 $("#photo_now").css('display',"none");
	 }else{
		 $("#file_upload").css('display',"none");
		 $("#photo_now").css('display',"block");
	}
	
});


// 是否更改描述
$("#change_event_desc").on("click",function(){
	var a =  $("#event_desc").css('display');
	 if(a == "none"){
		 $("#event_desc").css('display',"block");
		 $("#ck_editor").css('display',"none");
	 }else{
		 $("#event_desc").css('display',"none");
		 $("#ck_editor").css('display',"block");
	}
});










</script>
<?php $this->load->view('common/footer');?>