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
								<th>登录id</th>
								<th>管理员</th>
								<th>登录时间</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($login_list as $login):?>
								<tr>
									<td><?=$login['id']?></td>
									<td><?=$login['admin_account']?></td>
									<td><?=$login['login_time']?></td>
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
	//删除品牌
	$(".delete_brand").on("click",function(){
		var brand_id = $(this).val();
		layer.confirm('您确定要删除此品牌么?',{
		    btn: ['确定','取消'] //按钮
		}, function(){
		post("<?php echo base_url('api/brand_del');?>",
				{"brand_id":brand_id},function(data){
						console.log(data);
						window.location.reload();
					});
		}, function(){
			//取消的代码
		});
	});

	//查询品牌
	$(".brand_search").on("click",function(){
			var brand_name = $("#brand_name").val();
			console.log(brand_name);
			location.href = "<?php base_url('base/brand');?>"+"?search_key="+brand_name;
		});
	
//end of $();
});
</script>
<?php $this->load->view('common/footer');?>