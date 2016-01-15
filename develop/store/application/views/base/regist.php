
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
	<?php $this->load->view('common/js_and_css_include');?>
    <link rel="icon" href="../../favicon.ico">
<style>
.layout_rightmain .inner {background-color:#F4F4F4;width:100%;height:40px;position:absolute;padding:0px;}
	.nav-vertical{position:fixed;width:180px;height:90%;top:51px;}
	.navbar-header{margin-left:60px;}
	#main_page{padding-left:20px;padding-right:20px;}
	ul.pagination {margin-bottom: 40px;}


</style>
    <title>商铺登陆</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/static/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <script>

	function check()
{

	

}




  </script>
<script>



$(document).ready(function(){
	
  $("#btn").click(function(){
var tel = $("#account").val(); //获取手机号
var telReg = !!tel.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

		if($("#verify_code").val()=="")
	{
		alert('请输入注册码');
		return false;

		

	}
	else if(null == $("#account").val().match(/^(\w){6,20}$/))
	{
			alert('请输入正确的邮箱或手机号');
			return false;
	}
	/*else if(telReg==false )
	{
			alert('手机号或邮箱格式错误');
			return false;
	}*/

	else if($("#pwd").val()=="")
	{
			alert('请输入密码');
			return false;
	}
	else if(null == $("#pwd").val().match(/^(\w){6,20}$/))
	{
			alert('密码长度不足');
			return false;	
	}
		else if($("#re_pwd").val()=="")
	{
			alert('请输入确认密码');
			return false;
	}
		else if($("#re_pwd").val()!=$("#pwd").val())
	{
			alert('密码与确认密码不一致');
			return false;
	}
	

	
    $.post("../register",
    {
      verify_code:$("#verify_code").val(),
      account:$("#account").val(),
	  pwd:$("#pwd").val(),
	  re_pwd:$("#re_pwd").val()

    },
    function(data){
		  var obj = $.parseJSON(data);
        if (0 != obj["err_num"])
        {
            console.log(obj["err_msg"]);
			alert(data);
        }
        else
        {
           // window.location.href = "index";
			
			alert('注册商铺成功');
        }
       
    });
  });
});

</script>
  <body>
<nav class="navbar navbar-default navbar-fixed-top layout_header" role="navigation">
  	<div class="container-fluid" style="background-color:#080808" >
	    <div class="navbar-header" style="margin-left:18px;">
	    	<a class="navbar-brand" href="http://storedev.kanjiebao.com/index.php"><img src = "http://storedev.kanjiebao.com/static/img/jiebao.png" height = "30px"/></a>
	    </div>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="background-color:#080808">
	      	<ul class="nav navbar-nav">
			  	      	</ul>
	      	<ul class="nav navbar-nav navbar-right">
	        	<li>
	        		<a href="">注销</a>
	        	</li>
	      	</ul>
	    </div>
  	</div>
</nav>
    <div class="container">

      <form class="form-signin "id="form" >
	  <br/><br/>
        <strong><font size="4px">提交注册码&nbsp;&nbsp;设置商铺的账号、密码</font></strong>
		<br/>
		<br/>
        <label for="verify_code" class="sr-only"></label>
        <input type="text"  name="verify_code" id="verify_code" class="form-control" placeholder="请输入注册码" style="border:1px solid black" required autofocus>
        <label for="account" class="sr-only">account</label>
        <br/>
        <input type="text" name="account" id="account" class="form-control" placeholder="账号设置" style="border:1px solid black" required>
		 <label for="pwd" class="sr-only">pwd</label>
        <br/>
        <input type="password" name="pwd" id="pwd" class="form-control" placeholder="密码设置（8位数字、字母）" style="border:1px solid black" required>
		 <label for="re_pwd" class="sr-only">re_pwd</label>
        <br/>
        <input type="password" name="re_pwd" id="re_pwd" class="form-control" placeholder="密码确认" style="border:1px solid black" required>
        <div class="checkbox">
          <label>
           
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" id="btn" name="btn" style="background:black"type="button" onclick="check()" >注册</button>
	
      </form>

    </div> <!-- /container -->

<?php $this->load->view('common/footer');?>
   

  </body>
</html>


