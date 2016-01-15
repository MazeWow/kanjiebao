(function() {
	$(document).ready(function(){
		// Store variables
        var accordion_head = $('.accordion > li > a'),
            accordion_body = $('.accordion li > .sub-menu');
        // Open the first tab on load
        accordion_head.next().show();
        // Click function
        accordion_head.on('click', function(event) {
            // Disable header links
            event.preventDefault();
            // Show and hide the tabs on click

            if ($(this).attr('class') != 'active'){
                $(this).next().show();
                $(this).next().stop(true,true).slideToggle(200);
                //accordion_head.removeClass('active');
                $(this).addClass('active');
            }else{
                $(this).next().slideUp(200);
                $(this).next().stop(true,true).slideToggle(200);
                $(this).removeClass('active');
            }
        });

        $('#check_all_chk').click(function(event) {
            var $check_single_chks = $(this).parent('th').parent('tr').parent('thead').next('tbody').find('.check_single_chk');
            
            if($(this).prop('checked')){
                $check_single_chks.prop('checked', true);
           }
            else{
                $check_single_chks.prop('checked', false);
            }
        });

	});
	
}).call(this);

function open_loading_window(){
    $("#loading_window").modal("show");
}
function close_loading_window(){
    $("#loading_window").removeAttr('title').modal("hide");
}

//发送　post 请求组件
function post(api_url,api_data,func){
	$.ajax({
		url:api_url,
		data:api_data,
		dataType:'json',
		method:'post',
		success:func,
		complete:function(XHR, TS){
			XHR = null;
		}
		});
}
//发送　get 请求组件
function get(api_url,api_data,func){
	$.ajax({
		url:api_url,
		data:api_data,
		dataType:'json',
		method:'get',
		success:func,
		complete:function(XHR, TS){
			XHR = null;
		}
		});
}

//文件上传组件
function file_component(click_btn,url,fileElementId,show_place){
	//上传文件事件
	$("#"+click_btn).click(function(){
	    $.ajaxFileUpload({
            url: url,
            type: 'post',
            secureuri: false, //一般设置为false
            fileElementId:fileElementId, // 上传文件的id、name属性名
            dataType: 'json', //返回值类型，一般设置为json、application/json
            success: function(data, status){
               var img = $("<img src ='"+data[0]+"'  height=100 class='photo'>");
               $("#"+show_place).append(img);
            },
            error: function(data, status, e){
                console.log(data);
            }
        });
	});
}

//获取某个 id 区域内的 img  的 url  数组
function get_img(id,msg){
	var photo = [];
	$("#"+id+" img").each(function(){
		photo.push($(this).attr("src"));
	});
	if(photo.toString() == ''){
		layer.alert(msg);
		return false;
	}
	return photo;
}


































