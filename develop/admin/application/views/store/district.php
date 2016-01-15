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
					<li class="active">商圈</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
<!-- 					<div class="panel-heading"> -->
<!-- 						<button id="add_district" class="btn btn-primary">添加商圈</button> -->
<!-- 					</div> -->

					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
                  				<th>#id</th>
                  				<th>商圈</th>
                  				<th>经度</th>
                  				<th>纬度</th>
                  				<th>所属城市</th>
                  				<th>状态</th>
                  				<th>商圈图片</th>
                  				<th>操作</th>
                			</tr>
						</thead>
						<tbody>
						<?php
				              	if(isset($records)){
				              		foreach ($records as $row){
				              			echo "<tr>";
				              			echo "<td>$row[id]</td>";
				              			echo "<td>$row[name]</td>";
				              			echo "<td>$row[Longitude]</td>";
				              			echo "<td>$row[Latitude]</td>";
				              			echo "<td>$row[city_name]</td>";
				              			$status = ($row['is_developed'])?"<span style='font-size:12px;' class='label label-success'>开发</span>":"<span style='font-size:12px;' class='label label-default'>未开发</span>";
				              			echo "<td>$status</td>";
				              			$img_url = $row['photo'][0];
				              			echo "<td><img src = '$img_url' width='100px' />";
				              			echo "<td>";
										if($row['is_developed']){
											echo "<button class='un_develop btn btn-xs btn-primary' value = '$row[id]'>不开发</button>&nbsp;";
										}else{
											echo "<button class='develop btn btn-xs btn-success' name='develop' value = '$row[id]'>开发</button>&nbsp;";
										}
										echo "<button class='edit_district btn btn-xs btn-success' value = '$row[id]'>编辑</button>&nbsp;";
										echo "<button class='del_district btn btn-xs btn-danger' value = '$row[id]'>删除</button>&nbsp;";
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

	$(".edit_district").on("click",function(){
			//layer.msg("编辑商圈");
			var district_id = $(this).val();
			console.log(district_id);
			location.href = "<?php echo base_url('store/district_edit');?>" + "?district_id=" + district_id;
		});

	//操作：开发商圈
	$(".develop").on("click",function(){
			var district_id = $(this).val();
			post("<?php echo base_url('api/district_develop');?>",
					{"district_id":district_id},function(data){
							//重新刷新下
							console.log(data);
							window.location.reload();
						});
		});
	//操作：不开放商圈
	$(".un_develop").on("click",function(){
		var district_id = $(this).val();
		post("<?php echo base_url('api/district_un_develop');?>",
				{"district_id":district_id},function(data){
						//重新刷新下
						console.log(data);
						window.location.reload();
					});
		console.log(district_id);
		});
	//删除商圈
	$(".del_district").on("click",function(){
		var district_id = $(this).val();
		layer.confirm('您确定要删除商圈么?',{
		    btn: ['确定','取消'] //按钮
		}, function(){
		post("<?php echo base_url('api/district_del');?>",
				{"district_id":district_id},function(data){
						//重新刷新下
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
