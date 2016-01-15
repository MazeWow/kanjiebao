;
/**      
 * 对Date的扩展，将 Date 转化为指定格式的String      
 * 月(M)、日(d)、12小时(h)、24小时(H)、分(m)、秒(s)、周(E)、季度(q) 可以用 1-2 个占位符      
 * 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)      
 * eg:      
 * (new Date()).pattern("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423      
 * (new Date()).pattern("yyyy-MM-dd E HH:mm:ss") ==> 2009-03-10 二 20:09:04      
 * (new Date()).pattern("yyyy-MM-dd EE hh:mm:ss") ==> 2009-03-10 周二 08:09:04      
 * (new Date()).pattern("yyyy-MM-dd EEE hh:mm:ss") ==> 2009-03-10 星期二 08:09:04      
 * (new Date()).pattern("yyyy-M-d h:m:s.S") ==> 2006-7-2 8:9:4.18      
 */        
Date.prototype.pattern=function(fmt) {         
    var o = {         
    "M+" : this.getMonth()+1, //月份         
    "d+" : this.getDate(), //日         
    "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时         
    "H+" : this.getHours(), //小时         
    "m+" : this.getMinutes(), //分         
    "s+" : this.getSeconds(), //秒         
    "q+" : Math.floor((this.getMonth()+3)/3), //季度         
    "S" : this.getMilliseconds() //毫秒         
    };         
    var week = {         
    "0" : "/u65e5",         
    "1" : "/u4e00",         
    "2" : "/u4e8c",         
    "3" : "/u4e09",         
    "4" : "/u56db",         
    "5" : "/u4e94",         
    "6" : "/u516d"        
    };         
    if(/(y+)/.test(fmt)){         
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));         
    }         
    if(/(E+)/.test(fmt)){         
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "/u661f/u671f" : "/u5468") : "")+week[this.getDay()+""]);         
    }         
    for(var k in o){         
        if(new RegExp("("+ k +")").test(fmt)){         
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));         
        }         
    }         
    return fmt;         
}       


var HotM = {};
//让热点区加入可拖动、缩放事件
HotM.inithotAreaDrag = function(moduleid){
    var moduleImage = $("#imageEditLayer").find('.moduleImage');
    $('.hotArea')
        .drag("start",function( ev, dd ){
            dd.limit = moduleImage.position();
            dd.limit.top =  dd.limit.top - 40;
            dd.limit.bottom = dd.limit.top + moduleImage.outerHeight() - $(this).outerHeight();
            dd.limit.right = dd.limit.left + moduleImage.outerWidth() - $(this).outerWidth();

            dd.attr = $( ev.target ).prop("className");
            dd.width = $( this ).width();
            dd.height = $( this ).height();
        })
        .drag(function( ev, dd ){
           var props = {};
            if ( dd.attr.indexOf("E") > -1 ){
                props.width = Math.max( 32, dd.width + dd.deltaX );
            }
            if ( dd.attr.indexOf("S") > -1 ){
                props.height = Math.max( 32, dd.height + dd.deltaY );
            }
            if ( dd.attr.indexOf("W") > -1 ){
                props.width = Math.max( 32, dd.width - dd.deltaX );
                props.left = dd.originalX + dd.width - props.width;
            }
            if ( dd.attr.indexOf("N") > -1 ){
                props.height = Math.max( 32, dd.height - dd.deltaY );
                props.top = dd.originalY + dd.height - props.height;
            }

            if ( dd.attr.indexOf("hotArea-bg") > -1 ){
                props.top = Math.min( dd.limit.bottom, Math.max( dd.limit.top, dd.offsetY ));
                props.left = Math.min( dd.limit.right, Math.max( dd.limit.left, dd.offsetX ) )
            }
            $( this ).css( props );
        },{ relative:true});
}

HotM.inithotAreaData = function(moduleData){
    $(".mapBox").attr("moduleId", moduleData.id);
    $("#imageEditLayer").find(".moduleId").val(moduleData.id);
    $("#imageEditLayer").find(".moduleName").val(moduleData.name);
    $("#imageEditLayer").find(".moduleRemark").val(moduleData.remark);
    $("#imageEditLayer").find(".moduleImage").attr("src", moduleData.image);
    $(".mapBox .map_position").html("");
    $(".hotUrlArea ul").html("");
    var $areaDom = $(".mapBox .map_position");
    for(var i=0; i<moduleData.anchorList.length; i++){
        var anchor = moduleData.anchorList[i];
        HotM.addHotArea(moduleData.id,anchor.ref,anchor.coords);
        HotM.addHotInput(moduleData.id,anchor.ref,anchor.type,anchor.href,moduleData.moduleList);
    }
};
HotM.addHotInput = function (moduleid,index,type,href,moduleList){   
    var addData = {};
    addData.index = index;
    addData.anchorList = moduleList;
    var $mapBox = $(".mapBox[moduleId='"+moduleid+"']");
    var $link_url = $mapBox.find('.hotUrlArea ul');
    $("#webHotTmpl").tmpl(addData).appendTo($link_url);
    $maplink = $(".map-link[ref='"+index+"']");
    $maplink.find(".hotTypeSelect").val(type);
    if(type == "anchor"){
         $(".map-link[ref='"+index+"']").find(".select_anchor").val(href.replace("#",""));    
    }
    else{
        $(".map-link[ref='"+index+"']").find(".linkHref").val(href);
    }    
    $maplink.find(".cli").hide();
    $maplink.find(".cli[type='"+type+"']").show();
}
HotM.getModuleList = function(moduleid){   
    var moduleList=[];
    $(".module").each(function(){
        var anchorInfo ={};
        anchorInfo.id = $(this).attr("moduleId");
        if(anchorInfo.id == moduleid) return true;
        anchorInfo.name=$(this).attr("moduleName");
        moduleList.push(anchorInfo);
    });
    return moduleList;
}
HotM.clearHotMapData = function(moduleId){
    var $module= $(".module[moduleId='"+moduleId+"']");
    var $hotMap = $module.find("map");
    $hotMap.html("");
}
HotM.addHotMapData = function(moduleData){
    var $module= $(".module[moduleId='"+moduleData.id+"']");
    var $hotMap = $module.find("map");
    for(var i=0; i<moduleData.anchorList.length; i++){
        var anchor = moduleData.anchorList[i];
        var target = "_blank";
        var href = anchor.href;
        if(anchor.type == "anchor"){ 
            target = "_self";
            href = "#" + anchor.href;
        }
        var prestr = '<area shape="rect" ref="${ref}" target="${target}" coords="${coords}" type="${type}" href="${url}" >';
        var mapH = prestr.replace("${ref}", anchor.ref).replace("${target}", target)
                     .replace("${coords}",anchor.coords).replace("${type}",anchor.type).replace("${url}",href);
        $hotMap.append(mapH);
    }
};
HotM.addHotArea = function (moduleid,index,coords){
    if(!coords) return false;
    var $areaDom = $(".mapBox[moduleId='"+moduleid+"'] .map_position");
    var a = coords.split(",");
    var tData={};
    tData.index=index;
    tData.left=a[0];tData.top=a[1];tData.width=parseInt(a[2])-parseInt(a[0]);
    tData.height=parseInt(a[3])-parseInt(a[1]);
    $("#webHotmapAreaTmpl").tmpl(tData).appendTo($areaDom);
};
HotM.resetHotArea = function(moduleid){
    var $module = $(".mapBox[moduleId='"+moduleid+"']");
    var $hotArea = $module.find(".map_position .hotArea");
    var $linkArea = $module.find(".hotUrlArea .map-link");
    var $mapArea = $module.find("map area");
    $hotArea.each(function(i,dom){
        var _this = $(dom),index=i+1;
        _this.attr("ref",index).find(".name").html("热点"+index);
    });
    $linkArea.each(function(i){
        var _this = $(this),index = i+1;
        _this.attr("ref",index).find(".link-number-text").html("热点"+index);
        _this.find("input[type=text],input[type=hidden],input[type=radio]").attr("name",function(){
            var name=$(this).attr("name");
            return name.replace(/_\d+/,"_"+index);
        });
    });
    $mapArea.each(function(i){
        $(this).attr("ref",i+1)
    })
};
HotM.addModuleInstance = function(tmplName,moduleData){
    var tData = {};
    if(moduleData != null){ 
        tData = moduleData;
    }
    else{
        tData.moduleid = new Date().pattern("yyyyMMddHHmmssS")
        tData.moduleName = "模块" +  tData.moduleid;
        tData.moduleRemark = "";
    }
    $("#"+tmplName).tmpl(tData).appendTo($("#moduleContent"));
    return tData;
};
