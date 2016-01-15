<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">

		<!-- 面包屑导航 -->
		<?php $this->load->view('common/bread_nav');?>
		
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
						<div class = 'col-lg-5'>
							<?php $this->load->view('common/brand_search');?>
						</div>
						<div class = 'col-lg-6'>
							<?php $this->load->view('common/district_mall_floor_store_select'); ?>
						</div>
						<div class = 'col-lg-1'>
							<button class = 'btn  btn-primary' id="event_search">查询活动</button>
						</div>
						<div style="clear:both;"></div>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>id</th>
								<th>活动名称</th>
								<th>商铺</th>
								<th>开始时间</th>
								<th>剩余天数</th>
								<th>收藏人数</th>
								<th>分享人数</th>
								<th>状态</th>
								<th>活动图</th>
								<th>活动商品图</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset ( $records )) {
								foreach ( $records as $record ) {
									echo "<tr>";
									echo "<td>" . $record ['event_id'] . "</td>";
									echo "<td>" . mb_substr ( $record ['event_name'], 0, 12, 'utf-8' ) . "...</td>";
									echo "<td>" . $record ['store_info'] ['store_name'] . "</td>";
									echo "<td>" . $record ['event_stime'] . "</td>";
									echo "<td>" . $record ['event_left_day'] . "</td>";
									echo "<td>".$record['event_like_num']."</td>";
									echo "<td>".$record['event_shall_num']."</td>";
									if ($record ['is_del'] == 1) {
										echo "<td><span style='font-size:14px;' class='label label-danger'>已删除</span></td>";
									} elseif ($record ['is_publish'] == 0) {
										echo "<td><span style='font-size:14px;' class='label label-primary'>未发布</span></td>";
									} elseif ($record ['event_left_day'] <= 0) {
										echo "<td><span style='font-size:14px;' class='label label-danger'>过期</span></td>";
									} elseif ($record ['stime'] > time ()) {
										echo "<td><span style='font-size:14px;' class='label label-primary'>未开始</span></td>";
									} else {
										echo "<td><span style='font-size:14px;' class='label label-success'>进行中</span></td>";
									}
									
									echo "<td>";
									foreach ( $record ['event_photo'] as $photo ) {
										echo "<img src = '" . $photo . "' height = 50/>";
									}
									echo "</td>";
									echo "<td>";
									if (isset ( $record ['product'] )) {
										foreach ( $record ['product'] as $photo ) {
											if ($photo) {
												echo "<img src = '" . $photo ['photo'] . "' height = 50/>";
												break;
											}
										}
									}
									echo "</td>";
									echo "<td>";
									if($record ['is_publish'] == 0){
										echo "<button class='add_event_product　btn btn-xs btn-primary' value = {$record['event_id']} onclick='publish(this);'>发布</button>";
									}elseif($record ['is_publish'] == 1){
										echo "<button class='add_event_product　btn btn-xs btn-danger' value = {$record['event_id']} onclick='un_publish(this);'>不发布</button>";
									}
									$edit_url = base_url("event/edit?event_id=".$record['event_id']);
									echo "
									<a class='btn btn-xs btn-primary' href = '$edit_url' role='button' >编辑</a>
									<button class='add_event_product　btn btn-xs btn-success' value = {$record['event_id']} onclick='event_product_add(this);'>添加商品</button>";
									if($record ['is_del'] == 0){
										echo "<button class='delete　btn btn-xs btn-danger' value = {$record['event_id']} onclick='delete_event(this);'>删除</button>";
									}
									echo "</td>";
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

	//查询活动事件
	$("#event_search").on("click",function(){

		//查询关键字
		
		var search_key = {};
		
		//按品牌查询
		search_key.brand_id = $("#brand_id").val();

		//按商圈查询
		search_key.district_id = $("#district_id").val();

		//按商场查询 
		search_key.mall_id = $("#mall_id").val();

		//按商场楼层查询 
		search_key.mall_floor_id = $("#mall_floor_id").val();

		//按商铺查询
		search_key.store_id = $("#store_id").val();
		
		console.log(search_key);

// 		search_str = 'brand_id='+search_key.brand_id+"&district_id="search_key.district_id+"&mall_id="+search_key.mall_id+"&mall_floor_id="+search_key.mall_floor_id+"&store_id="+search_key.store_id;
		var search_str = '';
		for(var x in search_key){
				search_str += x+"="+search_key[x]+"&";
			}
		
		console.log(search_str);

		location.href = "<?php base_url('event/lists')?>"+"?"+search_str;
		
		});

});


function event_product_add(e){
	var b = $(e).val();
	var event_product_add_url = "<?php echo base_url('base_box/event_product_add');?>"+"?event_id="+b;
	layer.open({
        type: 2,
        title: '添加活动商品',
        maxmin: true,
        shadeClose: true,
        area : ['800px' , '520px'],
        content: event_product_add_url,
        end:function(){
        		window.location.reload();
	        }
	});
}

//活动详情
function event_detail(e){
	var event_id = $(e).val();
	var event_detail_url = "<?php echo base_url('base_box/event_detail');?>"+"?event_id="+event_id;
	layer.open({
        type: 2,
        title: '活动详情',
        maxmin: true,
        shadeClose: true,
        area : ['800px' , '520px'],
        content: event_detail_url,
        end:function(){
	        }
	});
}

//删除活动
function delete_event(e){
	var event_id =  $(e).val();
	post("<?php echo base_url('api/event_del');?>",{"event_id":event_id},function (data){
				if(data.err_num == 0){
						window.location.reload();
					}
		});
}

//发布活动
function publish(e){
	var event_id =  $(e).val();
	post("<?php echo base_url('api/event_publish');?>",{"event_id":event_id},function (data){
				if(data.err_num == 0){
						window.location.reload();
					}
		});
}

//不发布活动
function un_publish(e){
	var event_id =  $(e).val();
	post("<?php echo base_url('api/event_cancel_publish');?>",{"event_id":event_id},function (data){
				if(data.err_num == 0){
						window.location.reload();
					}
		});
}

</script>

<?php $this->load->view('common/footer');?>
