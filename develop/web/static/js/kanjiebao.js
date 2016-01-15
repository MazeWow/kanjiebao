// kanjiebao 首页移植过来的 getData
function getData()
{
    $.post("eventlistapi", {page_now:pageNow, page_size:pageSize}, 
    function(data)
    {
        var datas = "";
        if(datas = checkData(data))
        {
            setData(datas, Array(true));
        }
    });
}
/******************************  host/index  ***********************************/
$(document).ready(function()    
{
	/*  kanjiebao 整个应用 */

	var view_port_h = $(window).height();			// 视口高度
	
	var page_now   = 1;								// 页码
	
	var page_size  = 6;								// 记录数
	
	// 屏幕滚动事件 
	$(window).scroll(function(){
		var h = $(window).scrollTop();				//视口顶部距离文档顶部距离		
		var document_h = $(document.body).height();	//文档高度
		
		//文档底部 还剩 4 时 ，文档到达底部
		if(document_h < h+view_port_h+4){
			console.log("到达底部");
			console.log("page_now ：" + page_now);
			$.post(
					"eventlistapi",
					{page_now:page_now, page_size:page_size}, 
					function(data){
						console.log(data);
				        var datas = "";
				        if(datas = checkData(data))
				        {
				            setData(datas, Array(true));
				        }
				    });
			page_now++;
		}
	});
	
	
    hOld = $(window).scrollTop();
    time = new Date();
    start = time.getTime();
});

$(window).scroll(function()
{
    var hNow = $(window).scrollTop();
    if (hNow <= hOld)
    {
        if ("none" == $("#headBlank").css("display"))
        {
            $("#head").addClass("head-fixed");
            $("#headBlank").show();
        }
    }
    else
    {
        if ("block" == $("#headBlank").css("display"))
        {
            $("#head").removeClass("head-fixed");
            $("#headBlank").hide();
        }
    }
    hOld = hNow;
    
    if (pageMax && pageMax<=pageNow)
    {
        return false;
    }
    if (isBottom(1000))
    {
        time = new Date();
        var now = time.getTime();
        if (500 > now-start)
        {
            start = now;
            return false;
        }
        start = now;
        ++pageNow;
        getData();
    }
});
/******************************  host/index end ***********************************/



/******************************  host/district  ***********************************/
function setHeight1()
{
    var screenWidth = document.body.clientWidth;
    var adHeight = screenWidth*0.50625;
    $("#districtImgContainer").css("height", adHeight + "px");
    $("#act-header").show();
}

function setHeight2()
{
    var screenWidth = document.body.clientWidth;
    var mallHeight = screenWidth*0.2319444444444444;
    $(".district-mall-img").css("height", mallHeight + "px");
    $("#mall-header").show();
}
$(document).ready(function()
{
    districtId = getQuerystring("district");
    districtId = districtId ? districtId : 2;
    $.post("districtdetailapi", {district_id:districtId}, 
    function(data)
    {
        var datas = "";
        if (datas = checkData(data))
        {
            $("#title").text(datas["name"]);
            $("#title").show();
            $("#districtImgContainer").append('<div class="area-name"><div class="area-name-detail">'+datas["name"]+'</div></div><img src="application/views/inc/img/loading_districtlist.jpg" class="img-responsive area-img" id="districtImg"/>');
            setHeight1();
            lazyImg(datas["photo"][0] ? datas["photo"][0] : "application/views/inc/img/1.jpg", "districtImg", "#districtImgContainer");
        }
    });
    
    $.post("malllistapi", {district_id:districtId}, 
    function(data)
    {
        var datas = "";
        if (datas = checkData(data))
        {
		    var num = datas.length;
		    $("#districtMall").css("width", 45*num+"%");
            for (var i in datas)
            {
                $("#districtMall").append('<div class="district-mall-container pull-left"><a href="mall?mall='+datas[i]["mall_id"]+'" class="district-mall-a"><img class="district-mall-img" id="district-mall-img-'+i+'"/><div class="district-mall-name">'+datas[i]["mall_name"]+'</div></a></div>');
                lazyImg(datas[i]["mall_photo"][0] ? datas[i]["mall_photo"][0] : "application/views/inc/img/1.jpg", "district-mall-img-"+i, ".district-mall-img");
            }
            setHeight2();
            var mg = 100/45/num*2;
            $(".district-mall-container").css("margin", "0 "+mg+"%");
			$(".district-mall-container").css("width", (100/num-mg*2)+"%");
        }
    });
//    pageNow = 1;
//    pageSize = 10;
//    pageMax = 0;
//    getData();
    hOld = $(window).scrollTop();
    time = new Date();
    start = time.getTime();
});

$(window).scroll(function()
{
    var hNow = $(window).scrollTop();
    if (hNow <= hOld)
    {
        if ("none" == $("#headBlank").css("display"))
        {
            $("#head").addClass("head-fixed");
            $("#headBlank").show();
        }
    }
    else
    {
        if ("block" == $("#headBlank").css("display"))
        {
            $("#head").removeClass("head-fixed");
            $("#headBlank").hide();
        }
    }
    hOld = hNow;
    
    if(pageMax && pageMax<=pageNow)
    {
        return false;
    }
    if(isBottom(1000))
    {
        time = new Date();
        var now = time.getTime();
        if(500 > now-start)
        {
            start = now;
            return false;
        }
        start = now;
        ++pageNow;
        getData();
    }
});

/******************************  host/district  end ***********************************/











































