<?php $this->load->view('common/header'); ?>
<div class="layout_rightmain">
	<div class="inner"></div>
	<div class="container-fluid">
		<!-- 面包屑导航 -->
		<div class="row" id="bread_url">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span></a></li>
					<li><a href="<?=base_url('base/statistics')?>">数据统计</a></li>
				
					<li class="active">活动数据</li>
				</ol>
			</div>
		</div>
		<!-- 功能操作和列表 -->
		<div class="row">
			<div class="col-md-12" id="main_page">
				<!--<div class="panel panel-default ">-->
					<!-- 功能按钮栏 -->
					<div class="panel-heading">
					<hr>
						<div class="well well-sm col-md-3"style="background-color:white" >活动内容</div>
						
					
					<div class="col-md-12">
					<div class="col-md-4">
					<!-- <div id='canvasDiv'></div>-->
				
						 <div id="main" style="height:280px;width:280px"></div>
						 
						</div>
						<div class="col-md-4">
						<div id="main1" style="height:280px;width:280px"></div>
						<!-- <hr color="black" style="width:1px;height:200px; ">-->
						</div>
						<div class="col-md-4">
					<div id="main2" style="height:280px;width:280px"></div>
					</div>
					</div>
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

var myChart = echarts.init(document.getElementById('main')); 
var myChart1 = echarts.init(document.getElementById('main1'));
var myChart2 = echarts.init(document.getElementById('main2'));
option = {
  
  

  
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['一','二','三','四','五']
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
             
            }
        }
    ],
    series : [
        {
           
       
            markPoint : {
             
            },
       
        },
        {
            name:'数量',
            type:'line',
            data:[120, 220, 220, 50, 312, 98, 42],
         
            markLine : {
                data : [
                    {type : 'average', name : '平均值'}
                ]
            }
        }
    ]
};
	  myChart.setOption(option); 
	   myChart1.setOption(option); 
	    myChart2.setOption(option); 
                    
});
</script>
<?php $this->load->view('common/footer');?>