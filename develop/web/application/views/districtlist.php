<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=0.35, maximum-scale=0.35, user-scalable=0"/>
<title>商圈列表</title>
<link rel="stylesheet" href="application/views/inc/css/bootstrap.min.css"/>
<script src="application/views/inc/js/jquery-2.1.4.min.js"></script>
<script src="application/views/inc/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="application/views/inc/css/head.css"/>
<link rel="stylesheet" href="application/views/inc/css/districtlist.css"/>
<script src="application/views/inc/js/func.js"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f980595559486bdd3480b919b24a2905"></script>
<script>
function setHeight()
{
    var screenWidth = document.body.clientWidth;
    var areaHeight = screenWidth*0.5122979620520028;
    $(".area").css("height", areaHeight + "px");
}

function getCityId()
{
    $.post("userinfoapi", "", 
    function(data)
    {
        var datas = "";
        if(datas = checkData(data))
        {
            cityId = datas["city"];
        }
    });
}

function getCityName()
{
    $.post("", {cityId: cityId}, 
    function(data)
    {
        //$("#title").text(..“北京”..);
    });
}

function getData()
{
    var lng = "";
    var lat = "";
    if ("" != geoLo)
    {
        var geo_arr = geoLo.split(",");
        lng = geo_arr[0];
        lat = geo_arr[1];
    }
    $.post("districtlistapi", {city_id:cityId, page_now:pageNow, page_size:pageSize, lng:lng, lat:lat}, 
    function(data)
    {
        var datas = "";
        if(datas = checkData(data))
        {
            for (var i in datas)
            {
                //console.log(datas);
                var j = Number(i)+(pageNow-1)*pageSize;
                if (1 == datas[i]["is_developed"])
                {
                    var distance = datas[i]["distance"];
                    //console.log(distance);
                    if ("number" == typeof(distance))
                    {
                        if (1000 > distance)
                        {
                            distance += "m";
                        }
                        else
                        {
                            distance = distance/1000+"km";
                        }
                    }
                    $("body").append('<div class="area" id="area-'+j+'"><a href="district?district='+datas[i]["id"]+'"><img src="application/views/inc/img/loading_districtlist.jpg" class="img-responsive area-img" id="districtImg'+j+'"/></a><div class="area-name"><div class="area-name-detail"><a href="district?district='+datas[i]["id"]+'">'+datas[i]["name"]+'<br/><img src="application/views/inc/img/pointer.png"/>'+distance+'</a></div></div></div>');
                }
                else
                {
                    $("body").append('<div class="area" id="area-'+j+'"><img src="application/views/inc/img/loading_districtlist.jpg" class="img-responsive area-img" id="districtImg'+j+'"/><div class="area-un">'+datas[i]["name"]+'(coming soon)</div></div>');
                }
                setHeight();
                lazyImg(datas[i]["photo"] ? datas[i]["photo"] : "application/views/inc/img/1.jpg", "districtImg"+j, "#area-"+j);
                if (pageMax<=pageNow && i==datas.length-1)
                {
                    $("body").append('<div class="center togo"><div class="togo-title">还想去哪里逛？</div><br/><div><input type="text" class="form-control togo-input" placeholder="写下想逛的地方 如：望京购物中心" id="togoInput"/><button type="button" class="btn btn-default togo-sub" data-toggle="modal" data-target="#reminderModal" data-backdrop="static">提交</button></div></div>');
                }
            }
        }
    });
}

$(document).ready(function()
{
    //getCityId();
    cityId = 1;
    pageNow = 1;
    pageSize = 10;
    pageMax = 0;
    geoLo = cookieGet("geo");
    setGeolocation();
    getData();
    hOld = $(window).scrollTop();
    time = new Date();
    start = time.getTime();
    $("#reminderModal").on("show.bs.modal", function()
    {
        if ("" == $("#togoInput").val())
        {
            $("#reminderContent").text("还没有填写内容呢");
        }
        else
        {
            $.post("districtcommentapi", {comment: $("#togoInput").val()}, 
            function(data)
            {
                var obj = $.parseJSON(data);
                if (0 != obj["err_num"])
                {
                    console.log(obj["err_msg"]);
                    $("#reminderContent").text("网络不给力 再试一试");
                }
                else
                {
                    $("#reminderContent").text("提交成功");
                    $("#togoInput").val("");
                }
            });
        }
    });
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
</script>
</head>
<body>
<div class="head" id="head">
  <a class="pull-left icon-left-a" href="index"><img class="img-responsive icon-left" src="application/views/inc/img/logo.png"/></a>
  <a class="pull-right icon-right-a" href="user"><img class="img-responsive icon-right" src="application/views/inc/img/user.png"/></a>
  <div class="center"><a href="index" class="title"><span>活动</span></a>&nbsp;&nbsp;&nbsp;<a href="districtlist" class="title title-selected title-right"><span>商圈</span></a></div>
</div>
<div class="head-blank" id="headBlank"></div>
<!--<div class="area">
  <a href=""><img src="inc/img/1.jpg" class="area-img"/></a>
  <div class="area-name">中关村购物中心</div>
</div>-->
<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-title" id="shareModalLabel"></div>
      </div>-->
      <div class="modal-body">
        <div class="center" id="reminderContent"></div>
      </div>
      <div class="modal-footer">
        <div class="center">
          <button class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>