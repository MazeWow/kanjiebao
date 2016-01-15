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
						<p class="bg-info form-square-title">商场楼层名称</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-3 has-feedback">
						<input type="text" class="form-control" id="mall_name"
							required="required" placeholder="商场楼层名称" value="<?=$mall_floor['mall_floor_name'];?>"/>
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<div id="tips"></div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商场楼层路径</p>
					</div>
				</div>
				<div class="row">
					<?php //$this->load->view('common/district_mall_select');?>
					<div class="col-md-12">
		<div class="form-inline">
			<div class="form-group">
			<select class="form-control" name="district_id" id="district_id">
				<option value=0>商圈</option>
			</select>
			</div>
		<div class="form-group">
			<select class="form-control" name="mall_id" id="mall_id">
				<option value="<?=$mall_floor['mall_id'];?>"><?=$mall_floor['mall_name'];?></option>
			</select>
		</div>
	</div>
</div>
<br>
<script>
$(function(){
	//获得商圈
	function get_district(){
			post("<?php echo base_url('api/district_list');?>",{
					'city_id':1,'is_developed':1
				},function(data){
						if(data.err_num == 0){
								var records = data.results.records;
								var options_str = c_option(0,"商圈");
								for(var x in records){
									options_str += c_option(records[x]['id'],records[x]['name']);
								}
								$("#district_id").empty();
								$("#district_id").append(options_str);
							}
					});
		}
	get_district();
	//商圈　－　商场联动
	$("#district_id").bind("change",function(){
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
									options_str = c_option(0,"该商圈下没有商场");
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
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
								var options_str = c_option(0,"商场楼层");
								for(var x in mall){
										options_str += c_option(mall[x]['mall_floor_id'],mall[x]['mall_floor_name']);
									}
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该商场下没有楼层");
								$("#mall_floor_id").empty();
								$("#mall_floor_id").append(options_str);
								}
					});
	});

	//商场楼层 - 商铺联动
	$("#mall_floor_id").bind("change",function(){
		post("<?php echo base_url('api/store_lists');?>",
				{"mall_floor_id":$(this).val()},
				function(data){
						if(data.err_num == 0){
								var store = data.results.records;
								var options_str = c_option(0,"商铺");
								for(var x in store){
										options_str += c_option(store[x]['store_id'],store[x]['store_name']);
									}
								$("#store_id").empty();
								$("#store_id").append(options_str);
								
							}else{
								options_str = c_option(0,"该楼层下没有商铺");
								$("#store_id").empty();
								$("#store_id").append(options_str);
								}
					});
	});
});
</script>
					
				</div>
				<br>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">商场楼层图片</p>
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
									<img alt="" src="<?=$mall_floor['mall_floor_photo'][0];?>" width="200">
							</div>
					</div>
				</div>
			</div>
			<br>
		<div class="col-md-12">
		<div class="form-group form_btn_line">
			<div class="col-sm-3 col-sm-offset-5 text-center">
				<button class="btn btn-primary btn-block" id="add_mall" value="0">修改楼层</button>
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

		mall_info.mall_id = $("#mall_id").val();
		if(mall_info.mall_id == 0){
				layer.alert("请选择商场");
				return ;
			}
		//获取活动图片
		mall_info.photo = [];
		$("#img img").each(function(){
				mall_info.photo.push($(this).attr("src"));
			});
		if(mall_info.photo.toString() == ''){
				layer.alert("请上传图片！");
				return;
			}

		mall_info.mall_floor_id = <?=$mall_floor['mall_floor_id'];?>;

		console.log(mall_info);
		post("<?=base_url('api/mall_floor_edit');?>",
				mall_info,
				function(data){
					console.log(data);
					if(data.err_num == 0){
						location.href = "<?php echo base_url('store/mall_floor')?>";
					}
			});
		
		
		});

	 
	

});
</script>
<?php $this->load->view('common/footer');?> 