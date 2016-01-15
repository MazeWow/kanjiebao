function getQuerystring(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r!=null)
    {
        return  unescape(r[2]);
    }
    return null;
}

function isLogined()
{
    var flag = false;
    $.ajax(
    {
        type:"POST",
        url:"isloginedapi",
        async:false,
        success:function(data)
        {
            if ("1" == data)
            {
                flag = true;
            }
            else
            {
                flag = false;
            }
        }
    });
    return flag;
}

function logOut()
{
    $.post("logoutapi", {}, 
    function(data)
    {
        var obj = $.parseJSON(data);
        if (0 != obj["err_num"])
        {
            console.log(obj["err_msg"]);
        }
        else
        {
            window.location.href = "index";
            return false;
        }
    });
}

function cookieSet(str)
{
    var flag = false;
    $.ajax(
    {
        type:"POST",
        url:"cookiesetapi",
        data:{cookie:str},
        async:false,
        success:function(data)
        {
            if ("1" == data)
            {
                flag = true;
            }
        }
    });
    return flag;
}

function cookieGet(name)
{
    var c = "";
    $.ajax(
    {
        type:"POST",
        url:"cookiegetapi",
        data:{name:name},
        async:false,
        success:function(data)
        {
            var obj = $.parseJSON(data);
            if (1 == obj[0])
            {
                c = obj[1];
            }
        }
    });
    return c;
}

function isBottom(offset)
{
	var h1 = $("body").get(0).clientHeight;
    var h2 = $(window).scrollTop();
    var h3 = $(window).height();
    //console.log("h1:"+h1+" h2:"+h2+" h3:"+h3);
    if(h1-offset <= h2+h3)
    {
        return true;
    }
    return false;
}

function checkData(data)
{
    var obj = $.parseJSON(data);
    if (0 != obj["err_num"])
    {
        console.log(obj["err_msg"]);
        //var t = setTimeout("history.go(-1);", 500);
        if (8002 == obj["err_num"])
        {
            logOut();
            return false;
        }
        return false;
    }
    else if (obj["results"]["pager"])
    {
        pageMax = obj["results"]["pager"]["total_pages"];
        var datas = obj["results"]["records"];
        if(1 > datas.length)
        {
            console.log("没有数据");
            return false;
        }
    }
    else
    {
        var datas = obj["results"];
        if(1 > datas.length)
        {
            console.log("没有数据");
            return false;
        }
    }
    return datas;
}

function lazyImg(src, id, div)
{
    /*$("#"+id).css("width", "10%");
    $("#"+id).css("position", "absolute");
    if ("" != div)
    {
        $("#"+id).css("top", "40%");
    }
    else
    {
        $("#"+id).css("margin-top", "20%");
    }
    $("#"+id).css("left", "45%");*/
    //return false;
    var img = new Image();
    img.src = src;
    img.onload = function()
    {
        $("#"+id).attr("src", src);
        /*$("#"+id).css("width", "");
        $("#"+id).css("position", "");
        if ("" != div)
        {
            $("#"+id).css("top", "");
        }
        else
        {
            $("#"+id).css("margin-top", "");
        }
        $("#"+id).css("left", "");*/
        if ("" != div)
        {
            if (0 == div.indexOf("#"))
            {
                $(div).css("height", "");
            }
            else if (0 == div.indexOf("."))
            {
                cName = div;
                var t = setTimeout('$(cName).css("height", "");', 1500);
            }
        }
    };
}

function isCollected(id)
{
    var event_id = id;
    var flag = false;
    $.ajax(
    {
        type:"POST",
        url:"iscollectedapi",
        data:{event_id: event_id},
        async:false,
        success:function(data)
        {
            var obj = $.parseJSON(data);
            if (0 == obj["err_num"])
            {
                flag = true;
            }
            else
            {
                if (8002 == obj["err_num"])
                {
                    logOut();
                    return false;
                }
                flag = false;
            }
        }
    });
    return flag;
}

function collect(event_id, i)
{
    if (!isLogined())
    {
        window.location.href="login";
        return false;
    }
    if (isCollected(event_id))
    {
        $.post("cancelcollectapi", {event_id: event_id}, 
        function(data)
        {
            var obj = $.parseJSON(data);
            if (0 != obj["err_num"])
            {
                if (8002 == obj["err_num"])
                {
                    logOut();
                    return false;
                }
                console.log(obj["err_msg"]);
            }
            else
            {
                $("#collectImg"+i).attr("src", "application/views/inc/img/heart.png");
                $("#collectionNumber"+i).text(Number($("#collectionNumber"+i).text())-1);
                console.log("取消收藏成功");
            }
        });
    }
    else
    {
        $.post("collectapi", {event_id: event_id}, 
        function(data)
        {
            var obj = $.parseJSON(data);
            if (0 != obj["err_num"])
            {
                if (8002 == obj["err_num"])
                {
                    logOut();
                    return false;
                }
                console.log(obj["err_msg"]);
            }
            else
            {
                $("#collectImg"+i).attr("src", "application/views/inc/img/heart_collected.png");
                $("#collectionNumber"+i).text(Number($("#collectionNumber"+i).text())+1);
                console.log("收藏成功");
            }
        });
    }
}

function setData(acts, tag)
{
    var loginFlag = isLogined();
    
    for (var i in acts)
    {
        var j = (pageNow-1)*pageSize+Number(i)+1;
        if (tag)
        {
            if(tag[0])
            {
                $("body").append('<div class="act-mall"><a href="event?event='+acts[i]["event_id"]+'" class="act-a"><img class="img-responsive act-img" src="application/views/inc/img/loading_event.jpg" id="actImg'+j+'"/></a><a href="district?district='+acts[i]["store_info"]["district_id"]+'" class="district-a"><div class="clearfix mall-name"><img src="application/views/inc/img/tag_for_mall.png" class="pull-left"/><div class="center mall-name-text">'+acts[i]["store_info"]["district_name"]+'</div></div></a></div>');
            }
            else
            {
                $("body").append('<div class="act-mall"><a href="event?event='+acts[i]["event_id"]+'" class="act-a"><img class="img-responsive act-img" src="application/views/inc/img/loading_event.jpg" id="actImg'+j+'"/></a><a href="mall?mall='+acts[i]["store_info"]["mall_id"]+'" class="district-a"><div class="clearfix mall-name"><img src="application/views/inc/img/tag_for_mall.png" class="pull-left"/><div class="center mall-name-text">'+acts[i]["store_info"]["mall_name"]+'</div></div></a></div>');
            }
        }
        else
        {
            $("body").append('<div class="act-mall"><a href="event?event='+acts[i]["event_id"]+'" class="act-a"><img class="img-responsive act-img" src="application/views/inc/img/loading_event.jpg" id="actImg'+j+'"/></a></div>');
        }
        lazyImg(acts[i]["event_photo"][0] ? acts[i]["event_photo"][0] : "application/views/inc/img/1.jpg", "actImg"+j, "");
        $("body").append('<div class="store"><img class="img-responsive store-image" src="'+acts[i]["store_info"]["brand_logo"]+'"/><img class="img-responsive logo-frame" src="application/views/inc/img/logo_frame.png"/></div>');
        $("body").append('<div class="detail"><div class="content"><div class="act-name" title="'+acts[i]["event_name"]+'">'+acts[i]["event_name"]+'</div><div class="end-time">'+(1<acts[i]["event_left_day"] ? ('剩余'+acts[i]["event_left_day"]+'天') : '最后一天')+'</div><div class="store-name">'+acts[i]["store_info"]["store_name"]+'</div></div><button type="button" class="pull-right collection" onclick="collect('+acts[i]["event_id"]+', '+j+')"><img class="img-responsive collection-image" src="application/views/inc/img/heart.png" id="collectImg'+j+'"/><div class="center collection-number" id="collectionNumber'+j+'">'+acts[i]["event_like_num"]+'</div></button><div class="clearfix"></div></div><br class="split"/>');
        if (loginFlag && isCollected(acts[i]["event_id"]))
        {
            $("#collectImg"+j).attr("src", "application/views/inc/img/heart_collected.png");
        }
        if (pageMax<=pageNow && i==acts.length-1)
        {
            $("body").append('<h1 class="center over">已到达最后一页</h1>');
        }
    }
}

function setCarousel(imgs, ahref)
{
    if (ahref)
    {
        for (var i in imgs)
        {
            var j = Number(i)+1;
            if("0" == i)
            {
                $("#indicators").append('<li data-target="#carousel" data-slide-to="0" class="active" id="slide0" onclick="slideNow=0;"></li>');
                $("#inner").append('<div class="item active"><a href="'+imgs[i]["ad_link"]+'" class="item-a"><img src="application/views/inc/img/loading.gif" id="carouselImg1"/></a></div>');
            }
            else
            {
                $("#indicators").append('<li data-target="#carousel" data-slide-to="'+i+'" id="slide'+i+'" onclick="slideNow='+i+';"></li>');
                $("#inner").append('<div class="item"><a href="'+imgs[i]["ad_link"]+'" class="item-a"><img src="application/views/inc/img/loading.gif" id="carouselImg'+j+'"/></a></div>');
            }
            lazyImg(imgs[i]["ad_photo"], "carouselImg"+j, ".item");
        }
    }
    else
    {
        for (var i in imgs)
        {
            var j = Number(i)+1;
            if("0" == i)
            {
                $("#indicators").append('<li data-target="#carousel" data-slide-to="0" class="active" id="slide0" onclick="slideNow=0;"></li>');
                $("#inner").append('<div class="item active"><img src="application/views/inc/img/loading.gif" id="carouselImg1"/></div>');
            }
            else
            {
                $("#indicators").append('<li data-target="#carousel" data-slide-to="'+i+'" id="slide'+i+'" onclick="slideNow='+i+';"></li>');
                $("#inner").append('<div class="item"><img src="application/views/inc/img/loading.gif" id="carouselImg'+j+'"/></div>');
            }
            lazyImg(imgs[i], "carouselImg"+j, ".item");
        }
    }
    slideTotal = imgs.length;
}

function getGeolocation(GeolocationResult)
{
    if ("" == cookieGet("geo"))
    {
        var geoLo = GeolocationResult.position.getLng()+","+GeolocationResult.position.getLat();
        cookieSet("geo="+geoLo);
        location.reload();
        return false;
    }
    var geoLo = GeolocationResult.position.getLng()+","+GeolocationResult.position.getLat();
    cookieSet("geo="+geoLo);
}

function geoError(GeolocationError)
{
    console.log(GeolocationError.info);
    cookieSet("geo=''");
}

function setGeolocation()
{
    mapObj = new AMap.Map('iCenter');
    mapObj.plugin('AMap.Geolocation', function () {
        geolocation = new AMap.Geolocation({
            enableHighAccuracy: true,//是否使用高精度定位，默认:true
            timeout: 100,          //超过0.1秒后停止定位，默认：无穷大
            maximumAge: 0,           //定位结果缓存0毫秒，默认：0
            convert: true,           //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
            showButton: false,        //显示定位按钮，默认：true
            buttonPosition: 'LB',    //定位按钮停靠位置，默认：'LB'，左下角
            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            showMarker: false,        //定位成功后在定位到的位置显示点标记，默认：true
            showCircle: false,        //定位成功后用圆圈表示定位精度范围，默认：true
            panToLocation: false,     //定位成功后将定位到的位置作为地图中心点，默认：true
            zoomToAccuracy: false     //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
        });
        mapObj.addControl(geolocation);
        AMap.event.addListener(geolocation, 'complete', getGeolocation);//返回定位信息
        AMap.event.addListener(geolocation, 'error', geoError);      //返回定位出错信息
    });
    var t = setTimeout('geolocation.getCurrentPosition();', 200);
    //console.log(geolocation.watchPosition());
}


































