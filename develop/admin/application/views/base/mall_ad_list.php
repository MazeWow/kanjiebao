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
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
<!-- 						<button id="add_city" class="btn btn-primary">添加城市</button> -->
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>#id</th>
								<th>广告名称</th>
								<th>广告图</th>
								<th>广告链接</th>
								<th style="width: 120px;">操作</th>
							</tr>
						</thead>
						<tbody>
	                <?php
						if (isset ( $ad )) {
							foreach ( $ad as $row ) {
								echo "<tr>";
								echo "<td>$row[id]</td>";
								echo "<td>$row[ad_name]</td>";
								$img_url = $row['ad_photo'];
								echo "<td><img src='$img_url' width='100px'></td>";
								echo "<td><a href='$row[ad_link]'>$row[ad_link]</a></td>";
								echo "<td><button class='btn btn-xs btn-danger mall_ad_delete' value = '$row[id]'>删除</button></td>";
								echo "</tr>";
							}
						}
				?>
				</tbody>
					</table>

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
	//删除商铺
	$(".mall_ad_delete").on("click",function(){
		var mall_ad_id = $(this).val();
		layer.confirm('您确定要删除商圈么?',{
		    btn: ['确定','取消'] //按钮
		}, function(){
		post("<?php echo base_url('api/delete_mall_ad');?>",
				{"mall_ad_id":mall_ad_id},function(data){
						console.log(data);
						window.location.reload();
					});
		}, function(){
			//取消的代码
		});
	});
});
</script>
<?php $this->load->view('common/footer');?>