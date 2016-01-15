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
					<li class="active">添加</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
				<div class="row" id="main_page">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<p class="bg-info form-square-title">管理员名字</p>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="admin_name"
							required="required" placeholder="管理员名字" value="<?=$employee['account']?>"/>
					</div>
					<div class="form-group col-sm-4 has-feedback">
						<input type="text" class="form-control" id="admin_pwd"
							required="required" placeholder="重新输入管理员登录密码" />
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group form_btn_line">
					<div class="col-sm-3 col-sm-offset-0 text-center">
						<button class="btn btn-primary btn-block" id="add" value="0">更新管理员密码</button>
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
			</div>
		</div>
		<!-- row -->
	</div>
	<!-- container-fluid -->
</div>
<!-- layout_rightmain -->
<script>
$(function(){

$("#add").on('click',function(){
	var admin_info = {};
	admin_info.id = "<?=$employee['id']?>";
	admin_info.employee_name = $("#admin_name").val();
	admin_info.employee_pwd   = $("#admin_pwd").val();
	console.log(admin_info);
	post("<?php echo base_url('api/employee_edit');?>",admin_info,function(data){
			console.log(data);
			location.href = "<?php echo base_url('company/employee_list');?>";
		});
});
	

//end of $();	
});
</script>
<?php $this->load->view('common/footer');?> 