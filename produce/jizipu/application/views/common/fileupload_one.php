<div class="row">

	<div class = "col-sm-4">
		<div id="fileupload">
			<input type="file" id="file" name="file" />
		</div>
	</div>
	
	<div class = "col-sm-2">
		<input type="button" class = "btn btn-primary" id="btnUpload" value="上传图片" />
	</div>
	
</div>

<br>
<div class="row">
	<div class = "col-sm-12">
		<div id="img">
			<!--//放缩略图的地方 -->
		</div>
	</div>
</div>
<br>
<script>
	$(function(){
		//上传文件事件
		$("#btnUpload").click(function(){
		    $.ajaxFileUpload({
	            url: '<?php echo base_url('file/upload');?>',
	            type: 'post',
	            secureuri: false, //一般设置为false
	            fileElementId: 'file', // 上传文件的id、name属性名
	            dataType: 'json', //返回值类型，一般设置为json、application/json
	            success: function(data, status){
	               var img = $("<img src ='"+data[0]+"'  height=100 class='photo'>");
	               $("#img").empty();
	               $("#img").append(img);
	            },
	            error: function(data, status, e){
	            	layer.alert("您还未上传文件!");
	                console.log(data);
	            }
	        });
		});
		});
</script>