
<?php $this->load->view('common/header'); ?>
<script>
$(document).ready(function(){
	



	
    $.post("../storeDetail",
    {
      store_session:$("store_session").val(),
	  

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

</script>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base/storeDetail')?>">商铺设置</a></li>
				
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
					<div class="div" style="width:95%;height:550px;line-height:80px;border:4px solid #D7D7D7;">
					<div style="margin-top:20px;margin-left:20px">
					<span  class="col-lg-4 info_">品牌logo</span>
					<span  class="col-lg-8">asdasdsadsaasd</span>
					<br/>
					<hr/>
					
					</div>
					
					<div style="margin-top:15px;margin-left:20px">
					<span  class="col-lg-4 info_">商铺名称</span>
					<span  class="col-lg-8">asdasdsadsaasd</span>
					<br/>
					<hr/>
					</div>
					<div style="margin-top:15px;margin-left:20px">
					<span  class="col-lg-4 info_">商铺地址</span>
					<span  class="col-lg-8">asdasdsadsaasd</span>
					<br/>
					<hr/>
					</div>
					<div style="margin-top:15px;margin-left:20px">
					<span  class="col-lg-4 info_">经营品类</span>
					<span  class="col-lg-8">asdasdsadsaasd</span>
					<br/>	
					<hr/>
					</div>


				 


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