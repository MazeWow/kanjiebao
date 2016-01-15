<link href="<?php echo base_url('static/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static/css/base.css'); ?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('static/js/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/common.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/layer/layer.js');?>"></script>
<script src="<?php echo base_url('static/js/ajaxfileupload.js');?>"></script>
<script src="<?php echo base_url('static/js/ckeditor/ckeditor.js');?>"></script>
<script src="<?php echo base_url('static/js/echarts.js');?>"></script>
<script src='http://www.ichartjs.com/ichart.latest.min.js'></script>
<script>
	//全站点　js 的一些配置
	var api_domin = '<?php echo API_URL;?>';	//获取　api 数据  的url
	/*
		时间格式化函数
		eg:format="YYYY-MM-dd hh:mm:ss";
	*/
	Date.prototype.format = function(format) {
    var o = {
        "M+" :this.getMonth() + 1, // month
        "d+" :this.getDate(), // day
        "h+" :this.getHours(), // hour
        "m+" :this.getMinutes(), // minute
        "s+" :this.getSeconds(), // second
        "q+" :Math.floor((this.getMonth() + 3) / 3), // quarter
        "S" :this.getMilliseconds()
    // millisecond
    }
 
    if (/(y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "")
                .substr(4 - RegExp.$1.length));
    }
 
    for ( var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k]
                    : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
}
	function c_option(value,name){
		return "<option value="+value+">"+name+"</option>";
	}
	function c_td(value){
		return "<td>"+value+"</td>";
	}
	
	
</script>

