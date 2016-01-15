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
					<div class="panel-heading">
						<button id="add_district" class="btn btn-primary">添加商圈</button>
					</div>

					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
                  				<th>#id</th>
                  				<th>商圈</th>
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
				              			debug($row,'row');
				              			echo "<tr>";
				              			echo "<td>$row[id]</td>";
				              			echo "<td>$row[name]</td>";
				              			echo "<td>$row[city_name]</td>";
				              			$status = ($row['is_developed'])?"已开发":"未开发";
				              			echo "<td>$status</td>";
				              			$img_url = $row['photo'][0];
				              			echo "<td><img src = '$img_url' width='100px' />";
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
	//add district
	$("#add_district").on('click',function(){

			layer.alert("功能暂时移除");return;
			
		    layer.open({
		        type: 2,
		        title: '添加商圈',
		        maxmin: true,
		        shadeClose: true,
		        area : ['800px' , '520px'],
		        content: '<?php echo base_url('base_box/add_district_box');?>',
		        end:function(){
		        	window.location.reload();
			        }
		});
	});

	//
	$(".delete").on('click',function(){
		layer.alert("功能暂时移除!");return ;
	});
});
</script>

<!-- 主页面end -->
<?php $this->load->view('common/footer');?>
