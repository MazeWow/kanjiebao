<html>
	<h1>接口使用demo</h1>
	<?php 
		echo "<h2>ajax异步调用接口，要经过一层中转ajax_city</h2>";
	?>
	
	<form >
		<input type="text">
		<input type="button" value="获取数据，看console.log" id = "btn"/>
		
		
		<hr>
		<?php 
			echo "<h2>直接使用接口拿到数据</h2>";
			echo "<pre>";
				print_r($city_results);
			echo "</pre>";
		?>
	</form>
	<script src="//cdn.bootcss.com/jquery/3.0.0-alpha1/jquery.min.js"></script>
	<script>
		$(function(){
				$("#btn").on('click',function(){
						console.log("开始获取api数据!");
						$.ajax({  
					        url: "<?php echo base_url('index_demo/ajax_city');?>",  
					        data: {},  
					        dataType:"json",
             				method:'post',
					        success: function (data, textStatus,xmlHttpRequest) {  
					           //do something... 
						           console.log(data); 
						           console.log("取到的data数据随便用！");
					        },  
					        complete: function (XHR, TS) { XHR = null }/*释放 ajax 对象内存*/
					    }); 
					});;
			});

	</script>
</html>