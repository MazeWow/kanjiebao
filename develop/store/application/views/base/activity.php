<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base/activity')?>">活动管理</a></li>
				
					<li class="active">编辑、发布活动</li>
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
					<div class="col-md-4" align="center">
					<div class="div" style="width:250px;height:150px;border:2px solid #D7D7D7">
					
					</div>
					<div class="div" style="width:250px;height:38px;border:2px solid #D7D7D7">
					活动内容（标题+主要内容）
					</div>
					（首页效果实例）
					</div>

					<div class="col-md-4 col-md-offset-2">
					
					<form method="post" action="" enctype="multipart/form-data" >
		 <div class="form-group">
			 <label for="title">活动标题</label>
			<input type="text" class="form-control" id="title" placeholder="">
			<label for="content">活动内容概括</label>
			<input type="text" class="form-control" id="content" placeholder=""><br/>
			 <label for="file">封面图片</label><br/>
				 <div class="div1">
			<div class="div2">上传</div>
			<input type="file" id="file" class="inputstyle">
			</div></br>
				<p class="help-block">尺寸要求(750*392)</p>
				
			</div>
			<div id="preview" style="width:187px;height:98px;border:1px solid #D7D7D7"  >

			</div>
			<label for="text">参加此次活动品类</label>
			<input type="text" class="form-control" id="label" placeholder="">
			<label for="rules">活动详情</label>
			<textarea class="form-control" id="rules" rows="3"></textarea>
			<label for="time">活动时间</label>
			<input type="text" class="form-control" id="time" placeholder="">
			<label for="details" class=" col-lg-5 ">精选活动商品</label>
			<br/>
			<div  style="width:180px;height:100px;border:2px solid #D7D7D7">
			<span align="right" class="col-lg-7 glyphicon glyphicon-plus-sign" aria-hidden="true"></span>		
					
				
			</div>		
			 </div>
			

		
					
					
					
					
					
					</div>


						
					
				

				
				
				<br>
				<br>
			</div>
					<!-- 列表栏 -->
				<center> <button type="submit" class="btn btn-default">保存</button>
			   <button type="button" class="btn btn-default">预览</button></center>	
				
				<!--</div>-->
			</div>
			
			
			 </form>
		</div>
		<!-- row -->
	</div>
	<!-- container-fluid -->
</div>
 
<!-- layout_rightmain -->
<script>
$(document).ready(function(){
$("#file").change(function()
				{
					   var file = this.files[0];
					   var url = null ; 
								if(window.createObjectURL!=undefined)
								{
									   url = window.createObjectURL(file);
								}
								else if(window.URL!=undefined)
								{
								   	url = window.URL.createObjectURL(file);
								}
								else if(window.webkitURL!=undefined)
								{
   									url = window.webkitURL.createObjectURL(file);
								}
					   $("#preview").html('<img style="" height="98px" width="187px" src="'+url+'"/>');
				});

});



</script>
<script>
$(function(){
	
	var gg = document.getElementById("img1");
	var ei = document.getElementById("large");
	gg.onmousemove = function(event){
		event = event || window.event;
		ei.style.display = "block";
		ei.innerHTML = '<img style="border:1px solid gray;" src="' + this.src + '" />';
		ei.style.top  = document.body.scrollTop + event.clientY + 12 + "px";
		ei.style.left = document.body.scrollLeft + event.clientX + 12 + "px";
	}
	gg.onmouseout = function(){
		ei.innerHTML = "";
		ei.style.display = "none";
	}	
	$("#f1").change(function(){
		$("#img1").attr("src","file:///"+$("#f1").val());
	})
//end of $();



});
</script>

<?php $this->load->view('common/footer');?>