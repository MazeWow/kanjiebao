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
						<div class="col-md-6">
							<form class="form-inline" action="<?php echo base_url('store/mall');?>" method="get" id ="event">
								<div class="form-group">
									<select class="form-control"  name="district_id">
										<option value=0 >全部商圈</option>
										<?php
											foreach ($district as $value){
												echo "<option value=$value[id]>$value[name]</option>";
											}
	 									?>
									</select>
								</div>
								<input id="filter" class="btn btn-primary" type="submit" value="查询"/>
							</form>
						</div>
						<div class="col-md-6">
							<div class="form-inline">
									<div class="form-group">
										<select class="form-control"  name="add_district_id" id="add_district_id">
											<option value=0 >商圈</option>
											<?php
												foreach ($district as $value){
													echo "<option value=$value[id]>$value[name]</option>";
												}
		 									?>
										</select>
									</div>
									<div class="form-group">
										<input class="form-control" name = "mall_name" id= "mall_name" placeholder="商场名称">
									</div>
									<input id="add_mall" class="btn btn-primary" type="submit" value="添加商场"/>
								</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
			                  <th>#id</th>
			                  <th>商场</th>
			                  <th>商圈</th>
			                  <th>操作</th>
                			</tr>
						</thead>
						<tbody>
	                <?php
		              	if(isset($records)){
		              		foreach ($records as $row){
		              			echo "<tr>";
		              			echo "<td>$row[mall_id]</td>";
		              			echo "<td>$row[mall_name]</td>";
		              			echo "<td>$row[district_name]</td>";
		              			echo "<td><button class='delete　btn btn-xs btn-danger' value = '$row[id]'>删除</button></td>";
		              			echo "</tr>";
		              		}
              			}
              		?>
				</tbody>
					</table>
					<!-- 分页 -->
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
	$("#add_mall").on("click",function(){
			var $district_id = $("#add_district_id").val();
			var $mall_name = $("#mall_name").val();
			console.log($district_id + $mall_name);
			post("<?=base_url('store/ajax_add_mall');?>",
					{'district_id':$district_id,'mall_name':$mall_name},
					function(data){
						if(data.err_num == 0){
								location.reload();
							}else{
								layer.alert("添加商场失败，请重试！");
						}
				});
		});

	//删除商场
	$(".delete").on('click',function(){
		var id = $(this).val();
	    console.log($(this).val());
	    layer.confirm('您确定要删除吗？', {
	        btn: ['确定','取消'], //按钮
	        shade: false //不显示遮罩
	    }, function(){
		    //确定
	        $.ajax({
				url:"<?php echo base_url('base/mall_del');?>",
				data:{"id":id},
				dataType:'json',
				method:'post',
				success:function(data, textStatus,xmlHttpRequest){
					if(0 == data.err_num){
							window.location.reload();
						}
					},
				complete:function(XHR, TS){
						XHR = null;
					}
				});
	    }, function(){
		    //如果取消
	    });
	});
	
});
</script>
<!-- 主页面end -->
<?php $this->load->view('common/footer');?>
