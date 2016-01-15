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
					<li class="active">品牌列表</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
						<div class="col-md-3">
<!-- 							<input class="form-control" placeholder="品牌名称" id = "brand_name"> -->
						</div>
						<div class="col-md-4">
<!-- 							<button id="add_city" class="btn btn-primary brand_search">查询</button> -->
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>统计项目</th>
								<th>数量</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>累计注册人数</td>
								<td><?=$user_num?></td>
							</tr>
						</tbody>
					</table>
					<!--　分页 -->
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

	
//end of $();
});
</script>
<?php $this->load->view('common/footer');?>