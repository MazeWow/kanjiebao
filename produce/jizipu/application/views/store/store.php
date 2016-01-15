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
		</div>
		</div>
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
						<div class="col-md-9">
								<!-- 废弃按钮  -->
<!-- 							<button id="add_mall_store_btn" class="btn btn-primary">商场添加商铺</button> -->
<!-- 							<button id="add_street_store_btn" class="btn btn-primary">商业街添加商铺</button> -->
						</div>
						<div class="col-md-2">
							<input type="text" class="form-control" id="search_key" required="required" placeholder="商铺查询关键字" />
						</div>
						<div class="col-md-1">
							<button id="search_store" class="btn btn-primary">查询</button>
						</div>
						<div style="clear: both"></div>
					</div>
					<script type="text/javascript">
							$("#search_store").on("click",function(){
										location.href = "<?=base_url('store/store');?>"+"?search_key="+$("#search_key").val();
							});
					</script>

					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
			                  <th>#id</th>
			                  <th>商铺</th>
			                  <th>所属关系</th>
							  <th>品牌图片</th>
							  <th>经营品类</th>
							  <th>商铺图片</th>
							  <th>验证码</th>
			                  <th>操作</th>
               				</tr>
						</thead>
						<tbody>
						<tr>
	                <?php
		              	if(isset($records)){
		              		foreach ($records as $row){
		              			echo "<tr>";
		              			echo "<td>$row[store_id]</td>";
		              			echo "<td>$row[store_name]</td>";
		              			$addr = '';
		              			if(isset($row['street_name'])&&(!empty($row['street_name']))){
		              				$addr = $row['district_name']."--".$row['street_name'];
		              			}
		              			if(isset($row['mall_name'])){
		              				$addr = $row['district_name']."--".$row['mall_name'].'--'.$row['mall_floor_name'];
		              			}
		              			$img_url =$row['brand_logo'];
		              			echo "<td>$addr</td>";
		              			echo "<td><img src = '$img_url' width='50px' /></td>";
		             ?>
		             <td>
		             <?php foreach ($row['store_category'] as $item): ?>
		             	<?=$item?>
		             <?php endforeach; ?>
		             </td>
		             <td>
		             	<?php if($row['store_photo']):?>
		             		<img alt="商铺图片" src="<?=$row['store_photo'][0]?>" width="100px">
		             	<?php endif;?>
		             </td>
		             <?php 
		              			echo "<td>".$row['verify_code']."</td>";
		              			echo "<td>";
		              			
	              				if(!$row['verify_code']){
	              					echo "	<button class='create_verify_code　btn btn-xs btn-primary' value = '$row[store_id]' name='create_verify_code'>生成验证码</button>&nbsp;";
	              				}
		              			echo "<button class='btn btn-xs btn-success edit_store' value = '$row[store_id]'>编辑</button>";
		              			echo "&nbsp;";
		              			echo "<button class='btn btn-xs btn-danger delete_store' value = '$row[store_id]'>删除</button>";
		              			echo 	"</td>";
		              			echo "</tr>";
		              		}
		              	}
              		?>
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
			//编辑商铺
			$(".edit_store").on("click",function(){
					var store_id = $(this).val();
					location.href = "<?php echo base_url('store/store_edit');?>" + "?store_id="+store_id;
				});
		
			//删除商铺
			$(".delete_store").on("click",function(){
				var store_id = $(this).val();
				layer.confirm('您确定要删除商铺么?',{
				    btn: ['确定','取消'] //按钮
				}, function(){
				post("<?php echo base_url('api/store_del');?>",
						{"store_id":store_id},function(data){
								console.log(data);
								window.location.reload();
							});
				}, function(){
					//取消的代码
				});
			});
			
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
			//生成验证码
			$("button[name=create_verify_code]").on('click',function(){
					var store_id = $(this).val();
					post("<?php echo base_url('api/add_verify_code');?>",{'store_id':store_id},function(data){
								console.log(data);
								if(data.err_num == 0){
// 										layer.alert("生成验证码成功!");
										location.reload();
									}
								else{
										layer.alert("生成验证码失败，请重试!");
									}
						});
				});
		});


	
</script>
<?php $this->load->view('common/footer');?>



