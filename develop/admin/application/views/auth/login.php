<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>街巷科技后台管理系统</title>
<?php $this->load->view('common/js_and_css_include');?>
<link href="<?php echo base_url('static/css/bootstrap.min.css'); ?>"
	rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static/css/base.css'); ?>"
	rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-color: #eeeeee;
	padding-top: 100px;
}

#login-header {
	color: #666666;
	padding-bottom: 15px;
}

.glyphicon-home {
	font-size: 20px;
}

.panel-footer {
	padding: 20px 15px;
}

.panel-default {
	box-shadow: 0 0 6px 2px rgba(0, 0, 0, 0.1);
	background: rgba(255, 255, 255, 0.65);
}

.panel-body {
	padding-top: 35px;
}
</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 text-center" id="login-header">
				<h3>
					<span class="glyphicon glyphicon-home"></span> 街巷科技后台管理系统
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4 col-xs-offset-4">
				<div role="form">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="alert alert-danger" id="danger_alert" role="alert"
								style="display: none;"></div>
							<div class="form-group">
								<label for="account">用户名</label> <input type="text"
									class="form-control" name="account" id="account"
									placeholder="员工账号">
							</div>
							<div class="form-group">
								<label for="pass">密码</label> <input type="password"
									class="form-control" name="pass" id="pwd" placeholder="密码"
									autocomplete="off">
							</div>
							<!--                         <div class="form-group"> -->
							<!--                             <label for="verify">验证码</label> -->
							<!--                             <div class="row"> -->
							<!--                                 <div class="col-xs-7"> -->
							<!--                                     <input type="text" class="form-control" id="verify" name="verify"> -->
							<!--                                 </div> -->
							<!--                                 <div class="col-xs-5"> -->
							<!--                                     <p class="form-control-static"> -->
							<!--                                         看不清，<a id="changeV" class="flk13" href="javascript:void(0)">换一张</a> -->
							<!--                                     </p> -->
							<!--                                 </div> -->
							<!--                             </div> -->
							<!--                         </div> -->
							<div class="form-group">
								<div id="verify_img"></div>
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-primary btn-block"
								id="login_btn">登 录</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('static/js/jquery.min.js'); ?>"
		type="text/javascript"></script>
	<script src="<?php echo base_url('static/js/validator.js'); ?>"
		type="text/javascript"></script>
	<script type="text/javascript">
$(function(){
	$("#login_btn").on("click",function(){
			var account = $("#account").val();
			var pwd = $("#pwd").val();
			console.log(account+pwd);
			post("<?php echo base_url('auth/do_login');?>"
					,{"account":account,"pwd":pwd},
					function(data){
							console.log(data);
							if(data.err_num == 0){
									location.href = "<?php echo base_url();?>";
								}
						});
		});
});

</script>
</body>
</html>