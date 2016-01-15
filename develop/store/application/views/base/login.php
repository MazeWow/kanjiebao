
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
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<script>



$(document).ready(function(){
	
  $("#btn").click(function(){

		if($("#username").val()=="")
	{
		alert('请输入用户名');
		return false;

		

	}
	else if($("#inputPassword").val()=="")
	{
			alert('请输入密码');
			return false;
	}
	

	
    $.post("../login",
    {
      store_account:$("#username").val(),
	  pwd:$("#inputPassword").val()

    },
    function(data){
		 console.log(data);
		  var obj = $.parseJSON(data);
        if (0 != obj["err_num"])
        {
            console.log(obj["err_msg"]);
			alert('用户名或密码错误');
        }
        else
        {
           // window.location.href = "index";
			
			alert('登陆商铺成功');
        }
       
    });
  });
});

</script>










  <body style="margin:0;padding:0;">
<nav class="navbar navbar-default navbar-fixed-top layout_header" role="navigation">
  	<div class="container-fluid" style="background-color:#080808" >
	    <div class="navbar-header" style="margin-left:18px;">
	    	<a class="navbar-brand" href="http://storedev.kanjiebao.com/index.php"><img src = "http://storedev.kanjiebao.com/static/img/logo.png" height = "30px"/></a>
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


    
 <div id="web_bg" style="position:absolute; width:100%; height:100%; z-index:-1;border:none"> 
<img style="border:none; display:block;width:100%;"; src="http://storedev.kanjiebao.com/static/img/background.png"; /> 
</div>
<br/><br/><br/>
<div align="left" style="margin-top:10%;margin-left:8%">
<img style=""; src="http://storedev.kanjiebao.com/static/img/user.png"; /> 
<img style=""; src="http://storedev.kanjiebao.com/static/img/point.png"; />
<img style=""; src="http://storedev.kanjiebao.com/static/img/sale.png"; />
<br/>
<font style="color:black">
<h1>打造用户购物逛街第一入口</h1>
</div>
<div style="margin-left:50%;margin-top:-13%">

      <form class="form-signin " id="form" method="post" >
        <h2 >商铺登陆</h2><br/>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text"  style="background-color:transparent;background:;color:#000000;border:1px solid black" name="username" id="username" class="form-control" placeholder="账号" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <br/>
        <input type="password" name="passwd" style="background-color:transparent;background:;color:#000000;border:1px solid black" id="inputPassword" class="form-control" placeholder="密码" required></font>
        <div class="checkbox">
          <label>
           
          </label>
        </div>
        <button class="btn  btn-primary " id="btn" type="button" style="background:black">&nbsp;&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;陆&nbsp;&nbsp;&nbsp;</button>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="regist"><button class="btn  btn-primary " type="button" style="background:black">验证ID,快速注册</button></a>
      </form>
</div>
 

<?php $this->load->view('common/footer');?>

  </body>
</html>


