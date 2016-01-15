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
					<li class="active">商铺</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div id="add_store">
		<div class="row" id = "add_mall_store">
<!-- 			<h2>add_mall_store</h2> -->
		</div>
		</div>

		
		
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
						<button id="add_mall_store_btn" class="btn btn-primary">商场添加商铺</button>
						<button id="add_street_store_btn" class="btn btn-primary">商业街添加商铺</button>
					</div>

					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
			                  <th>#id</th>
			                  <th>商铺</th>
			                  <th>所属关系</th>
							  <th>品牌图片</th>
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
		              			$addr = '';
		              			if(isset($row['street_name'])&&(!empty($row['street_name']))){
		              				$addr = $row['district_name']."--".$row['street_name'];
		              			}
		              			if(isset($row['mall_name'])){
		              				$addr = $row['district_name']."--".$row['mall_name'].'--'.$row['floor_name'];
		              			}
		              			$img_url =$row['brand_logo'];
		              			echo "<td>$addr</td>";
		              			echo "<td><img src = '$img_url' width='100px' /></td>";
		              			echo "<td><button class='delete　btn btn-xs btn-danger' value = '$row[id]'>删除</button></td>";
		              			echo "</tr>";
		              		}
		              	}
              		?>
				</tbody>
					</table>
					<!-- 分页 -->
<!-- 					<div class="col-md-12 text-right"> -->
<!-- 						<ul class="pagination"> -->
<!-- 							<li class="first disabled"><a href="javascript:void(0);">首页</a></li> -->
<!-- 							<li class="prev disabled"><a href="javascript:void(0);">上一页</a></li> -->
<!-- 							<li class="page active"><a -->
<!-- 								href="?&amp;category_id=&amp;keyword=&amp;page=1">1</a></li> -->
<!-- 							<li class="page"><a -->
<!-- 								href="?&amp;category_id=&amp;keyword=&amp;page=2">2</a></li> -->
<!-- 							<li class="next"><a -->
<!-- 								href="?&amp;category_id=&amp;keyword=&amp;page=2">下一页</a></li> -->
<!-- 							<li class="last"><a -->
<!-- 								href="?&amp;category_id=&amp;keyword=&amp;page=2">尾页</a></li> -->
<!-- 						</ul> -->
<!-- 					</div> -->
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
	//delete store
	$(".delete").on('click',function(){
			var id = $(this).val();
		    console.log($(this).val());
		    layer.confirm('您确定要删除吗？', {
		        btn: ['确定','取消'], //按钮
		        shade: false //不显示遮罩
		    }, function(){
			    //确定
		        $.ajax({
					url:"<?php echo base_url('base/store_del');?>",
					data:{"id":id},
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
});
</script>

		<script>
			$(function(){
					//从商场添加商铺事件
					$("#add_mall_store_btn").on("click",function(){
						    layer.open({
						        type: 2,
						        title: '从商场添加商铺',
						        maxmin: true,
						        shadeClose: true,
						        area : ['800px' , '520px'],
						        content: '<?php echo base_url('base_box/add_store_from_mall');?>',
						        end:function(){
						        	window.location.reload();
							        }
							});
						});
					//从商业街道添加商铺事件
					$("#add_street_store_btn").on("click",function(){
					    layer.open({
					        type: 2,
					        title: '从商场添加商铺',
					        maxmin: true,
					        shadeClose: true,
					        area : ['800px' , '520px'],
					        content: '<?php echo base_url('base_box/add_store_from_street');?>',
					        end:function(){
					        	window.location.reload();
						        }
						});
					});
				});
		</script>
<?php $this->load->view('common/footer');?>



