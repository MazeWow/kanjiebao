<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base/goods#one')?>">商品管理</a></li>
				
					<li class="active">已发布活动</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<!--<div class="panel panel-default ">-->
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
					
							
					
						
						
					</div>
				
					<div class="col-md-12" align="left">
					<div class="div" style="width:95%;height:550px;margin-left:30px;line-height:45px;border:4px solid #D7D7D7;">
					<div >
					<form class="form-inline">
					<span class="col-lg-9">
					  <a href="add_goods"> <button type="button" class="btn btn-default">添加商品</button></a>
					   </span>
					   <span class="col-lg-3">
					  <input type="text" style="height:35px;width:120px" class="form-control" id="search" placeholder="商品名关键字">
					  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <button type="submit" class="btn btn-default">查询</button>
					   </span>
					 
					</div>
					<br/><p/>
					<div class="div" style="width:12%;height:180px;margin-left:30px;line-height:45px;border:4px solid #D7D7D7;background-color:#E9E9E9">

				 </div>

					  </form>
					</div>
			  
					<br/>
					
					
					</div>


					<!-- 列表栏 -->
					
				
				<!--</div>-->
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