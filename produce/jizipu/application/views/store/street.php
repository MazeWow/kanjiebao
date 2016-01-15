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
					<li class="active">商场</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
					<div class="col-md-6">
						<form class="form-inline" action="<?php echo base_url('store/street');?>" method="get">
							<div class="form-group">
								<select class="form-control"  name="district_id">
									<option value=0 >商圈</option>
									<?php
										foreach ($district as $value){
											echo "<option value=$value[id]>$value[name]</option>";
										}
 									?>
								</select>
							</div>
							<input id="filter" class="btn btn-primary" type="submit" value="查询"/>
						</form>
						</div>
						<div class="col-md-6">
						<div class = "form-inline">
							<div class="form-group">
								<select class="form-control"  name="district_id" id="district">
									<option value=0 >商圈</option>
									<?php
										foreach ($district as $value){
											echo "<option value=$value[id]>$value[name]</option>";
										}
 									?>
								</select>
								</div>
							<input type="text" class="form-control" id="street_name"
							required="required" placeholder="商业街名称" />
							<button id="add_street" class="btn btn-primary">添加商业街</button>
						</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
			                  <th>#id</th>
			                  <th>商业街</th>
			                  <th>商圈</th>
			                  <th>操作</th>
                			</tr>
						</thead>
						<tbody>
	                <?php
		              	if(isset($records)){
		              		foreach ($records as $row){
		              			echo "<tr>";
		              			echo "<td>$row[street_id]</td>";
		              			echo "<td>$row[street_name]</td>";
		              			echo "<td>$row[district_name]</td>";
		              			echo "<td><button class='btn btn-xs btn-danger delete_street' value = '$row[street_id]'>删除</button></td>";
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
	//删除街道
	$(".delete_street").on("click",function(){
		var street_id = $(this).val();
		layer.confirm('您确定要删除商圈么?',{
		    btn: ['确定','取消'] //按钮
		}, function(){
		post("<?php echo base_url('api/street_del');?>",
				{"street_id":street_id},function(data){
						//重新刷新下
						console.log(data);
						window.location.reload();
					});
		}, function(){
			//取消的代码
		});
	});

	
	//添加商业街
	$("#add_street").on("click",function(){
//			layer.msg("heh");
			var is_ajax = true;
			var district_id = $("#district").val();
			var street_name = $("#street_name").val();
			if(district_id==0){
					layer.alert("请选择商圈");
					is_ajax = false;
					return ;
				}
			if(!street_name){
					layer.alert("请写好商业街名称");
					is_ajax = false;
					return ;
				}
			var street_data = {
						'street_name'	:	street_name,
						'district_id'	:	district_id
					};
			console.log(street_data);
			if(is_ajax){
				$.ajax({
					url:"<?php echo base_url('base/ajax_add_street');?>",
					data:street_data,
					dataType:'json',
					method:'post',
					success:function(data, textStatus,xmlHttpRequest){
						console.log(data);
						if(0 == data.err_num){
								window.location.reload();
							}
						},
					complete:function(XHR, TS){
							XHR = null;
						}
					});
				}
			
			console.log(district_id);
		});


	
	//add district
	$("#add").on('click',function(){
		    layer.open({
		        type: 2,
		        title: '添加商场',
		        maxmin: true,
		        shadeClose: true,
		        area : ['800px' , '520px'],
		        content: '<?php echo base_url('base_box/add_mall_box');?>',
		        end:function(){
		        	window.location.reload();
			        }
		});
	});
	$(".delete").on('click',function(){
		var id = $(this).val();
	    console.log($(this).val());
	    layer.confirm('您确定要删除吗？', {
	        btn: ['确定','取消'], //按钮
	        shade: false //不显示遮罩
	    }, function(){
		    //确定
	        $.ajax({
				url:"<?php echo base_url('base/mall_del');?>",
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
<!-- 主页面end -->
<?php $this->load->view('common/footer');?>
