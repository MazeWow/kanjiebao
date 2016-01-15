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
					<div class="panel-heading">
						<div class="row">
								<div class="col-sm-2">
									<input type="date" class="form-control" id='stime'
										required="required" value="<?php if(isset($stime)) echo $stime;?>">
								</div>
								<div class="col-sm-2">
									<input type="date" class="form-control" id='etime'
										required="required" value="<?php if(isset($etime)) echo $etime;?>">
								</div>
								<div class="col-sm-2">
									<button class="btn btn-primary" id="search">查询</button>
								</div>
								<div class="col-sm-4">
								</div>
								<div class="col-sm-2">
									<?php if (isset($records_num)):?>
										<button class="btn btn-default disabled" style = "color:red;" id="search">共&nbsp;<?php echo $records_num;?>&nbsp;位用户</button>
									<?php endif;?>
								</div>
						</div>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>id</th>
								<th>用户账号</th>
								<th>用户昵称</th>
								<th>email</th>
								<th>qq</th>
								<th>注册时间</th>
								<!-- 								<th>操作</th> -->
							</tr>
						</thead>
						<tbody>
							<?php if (isset($users)):?>
							<?php foreach ($users as $user): ?>
								<tr>
								<td><?=$user['id']?></td>
								<td><?=$user['phone']?></td>
								<td><?=$user['name']?></td>
								<td><?=$user['email']?></td>
								<td><?=$user['qq']?></td>
								<td><?=date("Y-m-d H:i:s",$user['register_time']);?></td>
							</tr>
							<?php endforeach; ?>
							<?php endif;?>
						</tbody>
					</table>
					<!--　分页 -->
					<?php if(isset($pager)):?>
						<?php $this->load->view('common/pager');?>
					<?php endif;?>
				</div>
			</div>
		</div>
		<!-- row -->
	</div>
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<script type="text/javascript">
$(function(){
	$("#search").on("click",function(){
		var stime = $("#stime").val();
		if(stime == ""){
			layer.msg("请填写开始时间");
			return;
		}
		var etime = $("#etime").val();
		if(etime == ""){
			layer.msg("请填写结束时间");
			return;
		}
		location.href = "<?=base_url('user/lists')?>"+"?stime="+stime+"&etime="+etime;
		});
});
</script>
<?php $this->load->view('common/footer');?>
