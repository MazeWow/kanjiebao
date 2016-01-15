<?php $this->load->view('common/header'); ?>
<!-- 主页面 -->
<div class="main-tab" style="margin-top: 50px;">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				街报 &gt;<a href="#">基础</a> &gt;<a href="#">城市</a>
			</h3>
			<br>
		</div>
		<div class="panel-body">
			<input type="file" id="file" name="file">
			<input type="button" id="btnUpload" value="上传图片" />
		</div>
	</div>
</div>
<!-- 主页面end -->
<script type="text/javascript">
$(function(){
	$("#btnUpload").click(function(){
	    $.ajaxFileUpload({
            url: '<?php echo base_url('file/upload');?>', 
            type: 'post',
            secureuri: false, //一般设置为false
            fileElementId: 'file', // 上传文件的id、name属性名
            dataType: 'json', //返回值类型，一般设置为json、application/json
            success: function(data, status){
                console.log(data);
                alert(data);
            },
            error: function(data, status, e){ 
                console.log(data);
            }
        });
	});
});
</script>


<?php $this->load->view('common/footer');?> 