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
						<div class="col-md-4">
							<input class="form-control" placeholder="品牌名称">
						</div>
						<div class="col-md-4">
							<button id="add_city" class="btn btn-primary">查询</button>
						</div>
						<div style="clear:both;"></div>
					</div>

					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>#id</th>
								<th>品牌名称</th>
								<th>品牌logo</th>
								<th style="width: 120px;">操作</th>
							</tr>
						</thead>
						<tbody>
	                <?php
						if (isset ( $records )) {
							foreach ( $records as $row ) {
								echo "<tr>";
								echo "<td>$row[id]</td>";
								echo "<td>$row[name]</td>";
								$img_url = $row['logo'][0];
								echo "<td><img src='$img_url' width='100px'></td>";
								echo "<td>
									<button class='city_delete btn btn-xs btn-success' value = '$row[id]'>编辑</button>
									<button class='city_delete btn btn-xs btn-danger' value = '$row[id]'>删除</button>
								</td>";
								echo "</tr>";
							}
						}
				?>
				</tbody>
					</table>
					<div class="col-md-12 text-right">
						<ul class="pagination">
							<?php $url = 'base/brand';?>
							<li class="first "><a href="<?php echo base_url("$url?page_now=1");?>">首页</a></li>
							<li class="prev"><a href="<?php echo base_url("$url?page_now=$pager[pre_page]");?>">上一页</a></li>
							<?php foreach ($pager['pages'] as $item): ?>
								<?php if ($item == $pager['page_now']): ?>
									<li class="page active"><a href="<?=base_url("$url?page_now=$item")?>"><?=$item?></a></li>
									<?php continue;?>
								<?php endif; ?>
								<li class="page"><a href="<?=base_url("$url?page_now=$item")?>"><?=$item?></a></li>
							<?php endforeach;?>
							<li class="next"><a href="<?php echo base_url("$url?page_now=$pager[next_page]")?>">下一页</a></li>
							<li class="last"><a href="<?php echo base_url("$url?page_now=$pager[total_pages]")?>">尾页</a></li>
						</ul>
					</div>
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