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
			                  <th>商场图片</th>
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
		              			echo "<td>";
		              			if($row['mall_photo']){
		              				$mall_img_url = $row['mall_photo'][0];
		              				echo "<img src = '$mall_img_url' width='100px'/>";
		              			}
		              			echo "</td>";
		              			echo "<td>";
		              			echo "<button class='edit_mall btn btn-xs btn-success' value = '$row[id]'>编辑</button>";
		              			echo "&nbsp;";
		              			echo "<button class='delete_mall btn btn-xs btn-danger' value = '$row[id]'>删除</button>";
		              			echo "</td>";
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
	//编辑商场
	$(".edit_mall").on("click",function(){
			console.log($(this).val());
			var mall_id = $(this).val();
			location.href = "<?php echo base_url('store/mall_edit');?>"+"?mall_id="+mall_id;
		});
	
	//删除商场
	$(".delete_mall").on("click",function(){
		var mall_id = $(this).val();
		layer.confirm('您确定要删除商场么?',{
		    btn: ['确定','取消'] //按钮
		}, function(){
		post("<?php echo base_url('api/mall_del');?>",
				{"mall_id":mall_id},function(data){
						console.log(data);
						window.location.reload();
					});
		}, function(){
			//取消的代码
		});
	});
	
});
</script>
<!-- 主页面end -->
<?php $this->load->view('common/footer');?>
