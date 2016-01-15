<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base/published')?>">活动管理</a></li>
				
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
					
							<h3>活动内容管理<h3>
					
						
						
					</div>
				
					<div class="col-md-3" align="right">
					<div class="div" style="width:250px;height:150px;border:2px solid #D7D7D7">
					
					</div>
					<div class="div" style="width:250px;height:38px;border:2px solid #D7D7D7">
					
					</div>
					<br/>
					 <button type="button" class="btn btn-danger">申请删除</button>
					
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