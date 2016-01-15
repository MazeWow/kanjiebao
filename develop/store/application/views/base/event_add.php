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
					<li><a href="<?=base_url('base/event_add')?>">活动管理</a></li>
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
				<div class="row">
					<div class="form-group col-sm-2">
								<select class="form-control" id = "district_id" name="district_id">
									<option value=0>商圈</option>
									<?php
										foreach ($district as $value){
											echo "<option value=$value[id]>$value[name]</option>";
										}
 									?>
								</select>
							</div>
							<div class="form-group col-sm-2">
								<select class="form-control" id='mall_id'>
									<option value=0>商场</option>
								</select>
							</div>
							<div class="form-group col-sm-2">
								<select class="form-control" id="mall_floor_id">
									<option value=0>商场楼层</option>
								</select>
							</div>
							<div class="form-group col-sm-1">
								<p style="margin-top:5px;">或者</p>
							</div>
							<div class="form-group col-sm-2">
								<select class="form-control" id="street_id">
									<option value=0>商业街</option>
								</select>
							</div>
							<div class="form-group col-sm-3">
								<select class="form-control" id="store_id">
									<option value=0>商铺</option>
								</select>
							</div>
				</div>

			</div>

			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">活动图片信息</p>
					</div>
				</div>
				<div class="row">
					<div class = "col-sm-1">
						活动图片
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

		//商圈　－　商场联动
		$("#district_id").bind("change", function () {
			post("<?php echo base_url('api/mall_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商场");
									for(var x in mall){
											options_str += c_option(mall[x]['mall_id'],mall[x]['mall_name']);
										}
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									
								}else{
									options_str = c_option(0,"商圈下没有商场");
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									}
						});
			post("<?php echo base_url('api/street_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商业街");
									for(var x in mall){
											options_str += c_option(mall[x]['street_id'],mall[x]['street_name']);
										}
									$("#street_id").empty();
									$("#street_id").append(options_str);
									
								}else{
									options_str = c_option(0,"该商场下没有商业街");
									$("#street_id").empty();
									$("#street_id").append(options_str);
									}
						});
                });
    //商场　－　商场楼层联动
	$("#mall_id").bind("change",function(){
		post("<?php echo base_url('api/mall_floor_lists');?>",
				{"mall_id":$(this).val()},
				function(data){
						if(data.err_num == 0){
								var mall = data.results.records;
								var options_str = c_option(0,"楼层");
								for(var x in mall){
										options_str += c_option(mall[x]['mall_floor_id'],mall[x]['mall_floor_name']);
									}
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该商场没有楼层");
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								}
					});
	});

	//商场楼层　－　商铺联动
	$("#mall_floor_id").bind("change",function(){
		post("<?php echo base_url('api/store_lists');?>",
				{"mall_floor_id":$(this).val()},
				function(data){
						if(data.err_num == 0){
								var mall = data.results.records;
								var options_str = c_option(0,"商铺");
								for(var x in mall){
										options_str += c_option(mall[x]['store_id'],mall[x]['store_name']);
									}
								$("#store_id").empty();
								$("#store_id").append(options_str);
								
							}else{
								options_str = c_option(0,"楼层没有商铺");
								$("#store_id").empty();
								$("#store_id").append(options_str);
								}
					});
	});

	//商业街　－　商铺联动
	$("#street_id").bind("change",function(){
		post("<?php echo base_url('api/store_lists');?>",
				{"street_id":$(this).val()},
				function(data){
						if(data.err_num == 0){
								var mall = data.results.records;
								var options_str = c_option(0,"商铺");
								for(var x in mall){
										options_str += c_option(mall[x]['store_id'],mall[x]['store_name']);
									}
								$("#store_id").empty();
								$("#store_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该商业街没有商铺");
								$("#store_id").empty();
								$("#store_id").append(options_str);
								}
					});
	});

		$("#district").bind("change", function () {
                    $.ajax({
                    	url:api_domin + 'mall/mall_in_district',
    					data:{"district_id":$(this).val()},
    					dataType:'json',
    					method:'post',
    					success:function(data, textStatus,xmlHttpRequest){
    						if(0 == data.err_num){
    								var districts = data.results.records;
    								var options_str = c_option(0,"商场");
    								for(var x in districts){
    									options_str += c_option(districts[x].id,districts[x].name);
        								}
    								$("#mall").empty();
    								$("#mall").append(options_str);
    							}
							else{
    								options_str = c_option(0,"该商圈下没有商场");
    								$("#mall").empty();
    								$("#mall").append(options_str);
        							}
    						},
    					complete:function(XHR, TS){
    							XHR = null;
    						}
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
					console.log(event);
					post("<?php echo base_url('api/event_add');?>",
							event,
							function(data){
								if(data.err_num == 0){
										layer.msg("添加活动成功");
										location.href = "<?php echo base_url('base/event');?>";
									}
						});
            });
        

});

</script>
<?php $this->load->view('common/footer');?>