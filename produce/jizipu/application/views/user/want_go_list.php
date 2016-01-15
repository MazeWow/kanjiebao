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
					<li><a href="<?=base_url('base/city')?>">系统概况</a></li>
					<li class="active">系统负载</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading"></div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>id</th>
								<th>用户名称</th>
								<th>用户评论</th>
								<th>用户信息</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user): ?>
								<tr>
									<td><?=$user['id']?></td>
									<td><?=$user['user_name']?></td>
									<td><?=$user['comment']?></td>
									<td><?=$user['user_info']?></td>
									<td><button class="btn btn-xs btn-danger">删除</button></td>
								</tr>
							<?php endforeach; ?>
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
<?php $this->load->view('common/footer');?>
