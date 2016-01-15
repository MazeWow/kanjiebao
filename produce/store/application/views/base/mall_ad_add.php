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
					<li class="active">城市</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
				<div class="row" id="main_page">
				<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">广告所在商场</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 has-feedback">
						<form class="form-inline" action="<?php echo base_url('base/mall_floor');?>" method="get" id ="event">
							<div class="form-group">
									<select class="form-control"  name="district_id" id="district_id">
										<option value=0 >全部商圈</option>
										<?php
											foreach ($district as $value){
												echo "<option value=$value[id]>$value[name]</option>";
											}
	 									?>
									</select>
								</div>
							<div class="form-group">
								<select class="form-control"  name="mall_id" id = "mall_id">
									<option value=0 >商场</option>
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
				
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">广告名称</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="name"
							required="required" placeholder="广告名称" />
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">广告链接</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-8 has-feedback">
						<input type="text" class="form-control" id="ad_url"
							required="required" placeholder="广告链接,填写详细url(如:https://www.baidu.com)" />
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">广告图片</p>
					</div>
				</div>
				<div class="row">
					<div class = "col-sm-1">
						广告图片
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
						<button class="btn btn-primary btn-block" id="add_ad" value="0">添加广告图</button>
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

	//添加品牌事件
	$("#add_ad").on('click',function(){

			//广告名称
			var name 		=	$("#name").val();
			var mall_id 	= 	$("#mall_id").val();
			var ad_url		=	$("#ad_url").val();
			//获取活动图片
			photo = [];
			$("#img img").each(function(){
					photo.push($(this).attr("src"));
				});
			if(photo.toString() == ''){
					layer.alert("请上传品牌商图片！");
					is_ajax = false;
					return;
				}
			var add_info = {name:name,mall_id:mall_id,ad_url:ad_url,photo:photo};
			console.log(add_info);
			post("<?=base_url('api/mall_ad_add')?>",
					add_info,
					function(data){
						console.log(data);
						if(data.err_num == 0){
								layer.alert("添加广告成功");
								window.location.reload();
							}
						else{
								layer.alert("添加广告失败，请重试!");
							}
				});
		});

	//商圈　－　商场联动
	$("#district_id").bind("change",function(){
			post("<?php echo base_url('api/mall_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商场");
// 									console.log(mall);
									for(var x in mall){
											options_str += c_option(mall[x]['mall_id'],mall[x]['mall_name']);
										}
// 									console.log(options_str);
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									
								}else{
									options_str = c_option(0,"该商场下没有商场");
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									}
						});
		});

	
	
//end of $();
});
</script>
<?php $this->load->view('common/footer');?>