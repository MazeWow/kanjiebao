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
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>管理员id</th>
								<th>管理员名字</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($admin as $v):?>
								<tr>
									<td><?=$v['id']?></td>
									<td><?=$v['account']?></td>
									<td>
									<button class="btn-xs btn-success edit" value="<?=$v['id']?>">编辑</button>&nbsp;
									<button class="btn-xs btn-danger delete" value="<?=$v['id']?>">删除</button>&nbsp;
									</td>
								</tr>
							<?php endforeach;?>
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
	$(".delete").on('click',function(){
			console.log($(this).val());
			post("<?=base_url('api/employee_delete');?>",{'employee_id':$(this).val()},function(data){
					console.log(data);
					window.location.reload();
				});
		});
	$(".edit").on('click',function(){
		console.log($(this).val());
		location.href = "<?=base_url('company/employee_edit');?>?employee_id="+$(this).val();
	});


	
});
</script>
<?php $this->load->view('common/footer');?>