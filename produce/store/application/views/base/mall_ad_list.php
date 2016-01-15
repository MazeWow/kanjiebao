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
								echo "<td><button class='city_delete btn btn-xs btn-danger' value = '$row[id]'>删除</button></td>";
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
	//add city
	$("#add_city").on('click',function(){
		    layer.open({
		        type: 2,
		        title: '添加城市',
		        maxmin: true,
		        shadeClose: true,
		        area : ['800px' , '520px'],
		        content: '<?php echo base_url('base_box/add_city_box');?>',
		        end:function(){
		        	window.location.reload();
			        }
		});
	});

	//delete city
	$(".city_delete").on('click',function(){
			var city_id = $(this).val();
		    console.log($(this).val());
		    layer.confirm('您确定要删除吗？', {
		        btn: ['确定','取消'], //按钮
		        shade: false //不显示遮罩
		    }, function(){
			    //确定
		        $.ajax({
					url:"<?php echo base_url('base/city_delete');?>",
					data:{"city_id":city_id},
					dataType:'json',
					method:'post',
					success:function(data, textStatus,xmlHttpRequest){
						if(0 == data.err_num){
								window.location.reload();
							}
						},
					complete:function(XHR, TS){
							XHR = null;
						}
					});
		    }, function(){
			    //如果取消
		    });
	});
//end of $();
});
</script>
<?php $this->load->view('common/footer');?>