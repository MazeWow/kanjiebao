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
					<li class="active">商场</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
					<div class="col-md-5">
						<form class="form-inline" action="<?php echo base_url('store/mall_floor');?>" method="get" id ="event">
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
							<input id="filter" class="btn btn-primary" type="submit" value="查询"/>
						</form>
						</div>
						<div class="col-md-7">
						<div class = "form-inline">
							<div class="form-group">
									<select class="form-control"  name="district_id" id="district_id_add">
										<option value=0 >全部商圈</option>
										<?php
											foreach ($district as $value){
												echo "<option value=$value[id]>$value[name]</option>";
											}
	 									?>
									</select>
								</div>
							<div class="form-group">
								<select class="form-control" id="mall_id_add" name="mall_id_add">
									<option value=0 >商场</option>
								</select>
								</div>
							<input type="text" class="form-control" id="floor_name"
							required="required" placeholder="楼层名称" />
							<button id="add_mall_floor" class="btn btn-primary">添加楼层</button>
						</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
			                  <th>#id</th>
			                  <th>层数</th>
			                  <th>所属商场</th>
			                  <th>操作</th>
                			</tr>
						</thead>
						<tbody>
	                <?php
		              	if(isset($records)){
		              		foreach ($records as $row){
		              			echo "<tr>";
		              			echo "<td>$row[id]</td>";
		              			echo "<td>$row[floor_name]</td>";
		              			echo "<td>$row[mall_name]商场</td>";
		              			echo "<td><button class='delete　btn btn-xs btn-danger' value = '$row[id]'>删除</button></td>";
		              			echo "</tr>";
		              		}
              			}
              		?>
				</tbody>
					</table>
					<!--　分页 -->
					<?php $this->load->view('common/pager');?>
				</div>
			</div>
		</div>
		<!-- row -->
	</div>
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<script>
$(function(){
	//添加商场
	$("#add_mall_floor").on("click",function(){
			console.log("添加楼层");
			var is_ajax = true;
			var mall_id = $("#mall_id_add").val();
			console.log(mall_id);
			var floor_name = $("#floor_name").val();
			if(!floor_name){
					layer.alert("请写上商场层数");
					is_ajax = false;
					return ;
				}
			var floor_data =  {
						'mall_id'	:	mall_id,
						'floor_name'	:	floor_name
					};
			console.log(floor_data);
			if(is_ajax){
				$.ajax({
					url:"<?php echo base_url('base/ajax_add_mall_floor');?>",
					data:floor_data,
					dataType:'json',
					method:'post',
					success:function(data, textStatus,xmlHttpRequest){
						console.log(data);
						if(0 == data.err_num){
								window.location.reload();
							}
						},
					complete:function(XHR, TS){
							XHR = null;
						}
					});
				}
			
		});

	//商圈　－　商场联动
	$("#district_id").bind("change",function(){
			post("<?php echo base_url('api/mall_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商铺");
									console.log(mall);
									for(var x in mall){
											options_str += c_option(mall[x]['mall_id'],mall[x]['mall_name']);
										}
									console.log(options_str);
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									
								}else{
									options_str = c_option(0,"该商场下没有商铺");
									$("#mall_id").empty();
									$("#mall_id").append(options_str);
									}
						});
		});

	//商圈　－　商场联动
	$("#district_id_add").bind("change",function(){
			post("<?php echo base_url('api/mall_lists');?>",
					{"district_id":$(this).val()},
					function(data){
							if(data.err_num == 0){
									var mall = data.results.records;
									var options_str = c_option(0,"商场");
									console.log(mall);
									for(var x in mall){
											options_str += c_option(mall[x]['mall_id'],mall[x]['mall_name']);
										}
									console.log(options_str);
									$("#mall_id_add").empty();
									$("#mall_id_add").append(options_str);
									
								}else{
									options_str = c_option(0,"该商场下没有商铺");
									$("#mall_id_add").empty();
									$("#mall_id_add").append(options_str);
									}
						});
		});
	
});
</script>
<!-- 主页面end -->
<?php $this->load->view('common/footer');?>
