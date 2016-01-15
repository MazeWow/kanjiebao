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
					<li><a href="<?=base_url('base/event')?>">活动管理</a></li>
					<li class="active">活动列表</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<div class="panel panel-default">
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
						<form class="form-inline" action="<?php echo base_url('base/event');?>" method="get" id ="event">
							<div class="form-group">
								<select class="form-control" id="city" name="city">
									<option value=0 >城市</option>
									<?php
										foreach ($citys as $city){
											echo "<option value=$city[id]>$city[name]</option>";
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<select class="form-control" id='district' name='district'>
									<option value=0>商圈</option>
								</select>
							</div>
							<div class="form-group">
								<select class="form-control" id="mall" name="mall">
									<option value=0>商场</option>
								</select>
							</div>
							<div class="form-group">
								<select class="form-control" id="store" name="store">
									<option value=0>商铺</option>
								</select>
							</div>
							<div class="form-group">
								<div class="col-sm-２">
									<input type="date" class="form-control" id="time"
										value="<?php echo date('Y-m-d',time());?>" name="time">
								</div>
							</div>
							<input id="filter" class="btn btn-primary" type="submit" value="查询"/>
						</form>
					</div>
					<!-- 列表栏 -->
					<table class="table table-striped table-hover text-center">
						<thead>
							<tr>
								<th>id</th>
								<th>活动名称</th>
								<th>商铺</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>活动图</th>
								<th>活动商品图</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($records)){
									foreach ($records as $record){
										debug($record,'record');
										echo "<tr>";
										echo "<td>".$record['event_id']."</td>";
										echo "<td>".mb_substr($record['event_name'],0,12,'utf-8')."...</td>";
										echo "<td>".$record['store_info']['store_name']."</td>";
										echo "<td>".$record['event_stime']."</td>";
										echo "<td>".$record['event_etime']."</td>";
										echo "<td>";
										foreach ($record['event_photo'] as $photo){
											echo "<img src = '".$photo."' height = 50/>";
										}
										echo "</td>";
										echo "<td>";
										if(isset($record['product'])){
										foreach ($record['product'] as $photo){
											if($photo){
												echo "<img src = '".$photo['photo']."' height = 50/>";
											}
										}}
										echo "</td>";
										echo "<td>
											<button class='add_event_product　btn btn-xs btn-success' value = {$record['event_id']} onclick='event_detail(this);'>编辑</button>
											<button class='add_event_product　btn btn-xs btn-success' value = {$record['event_id']} onclick='event_product_add(this);'>添加商品</button>
											<button class='delete　btn btn-xs btn-danger' value = {$record['event_id']} onclick='delete_event(this);'>删除</button>
										</td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
					</table>
					<!-- 分页 -->
					<div class="col-md-12 text-right">
						<ul class="pagination">
							<?php
// 								echo "<li class='first'><a href='".base_url('base/event/1?'.$query_str)."'>首页</a></li>";
// 								echo "<li class='prev'><a href='".base_url('base/event/'.$pager['pre_page'].'?'.$query_str)."'>上一页</a></li>";
// 								foreach ($pager['pages'] as $page){
// 									echo "<li class='page'><a href='".base_url('base/event/'.$page.'?'.$query_str)."'>".$page."</a></li>";
// 								}
// 								echo "<li class='next'><a href='".base_url('base/event/'.$pager['next_page'].'?'.$query_str)."'>下一页</a></li>";
// 								echo "<li class='last'><a href='".base_url('base/event/'.$pager['total_pages'].'?'.$query_str)."'>尾页</a></li>";
// 								?>
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
	
	//商圈select值改变事件，改变商场的options
	$("#district").bind("change", function () {
                $.ajax({
                	url:api_domin + 'mall/mall_in_district',
					data:{"district_id":$(this).val()},
					dataType:'json',
					method:'post',
					success:function(data, textStatus,xmlHttpRequest){
						if(0 == data.err_num){
								var districts = data.results.records;
								var options_str = c_option(0,"商场");
								for(var x in districts){
									options_str += c_option(districts[x].id,districts[x].name);
    								}
								$("#mall").empty();
								$("#mall").append(options_str);
							}
						else{
								options_str = c_option(0,"该商圈下没有商场");
								$("#mall").empty();
								$("#mall").append(options_str);
    							}
						},
					complete:function(XHR, TS){
							XHR = null;
						}
					});
            });
	//商场select值改变事件，改变商铺的options
	$("#mall").bind("change", function () {
                $.ajax({
                	url:api_domin + 'store/store_in_mall',
					data:{"mall_id":$(this).val()},
					dataType:'json',
					method:'post',
					success:function(data, textStatus,xmlHttpRequest){
						if(0 == data.err_num){
								var districts = data.results.records;
								var options_str = c_option(0,"商铺");
								for(var x in districts){
									options_str += c_option(districts[x].id,districts[x].name);
    								}
								$("#store").empty();
								$("#store").append(options_str);
							}
						else{
								options_str = c_option(0,"该商场下没有商铺");
								$("#store").empty();
								$("#store").append(options_str);
    							}
						},
					complete:function(XHR, TS){
							XHR = null;
						}
					});
            });
	//城市select值改变事件，改变商圈的options
	$("#city").bind("change", function () {
		  		   jb_post('district/district_in_city',{"city_id":$(this).val()},
				  		   function(data, textStatus,xmlHttpRequest){
						if(0 == data.err_num){
							var districts = data.results.records;
							var options_str = c_option(0,"商圈");
							for(var x in districts){
								options_str += c_option(districts[x].id,districts[x].name);
								}
							$("#district").empty();
							$("#district").append(options_str);
						}
					else{
							options_str = c_option(0,"该城市下没有商圈");
							$("#district").empty();
							$("#district").append(options_str);
							}
					});
            });

    //添加活动商品
    $(".add_event_product").on("click",function(){
				layer.alert("添加活动商品");
				alert("heheh");
        });

    //
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
        	//window.location.reload();
	        }
	});
}

//删除活动
function delete_event(e){
	console.log(e);
	alert("删除活动!");
}


</script>

<?php $this->load->view('common/footer');?>
