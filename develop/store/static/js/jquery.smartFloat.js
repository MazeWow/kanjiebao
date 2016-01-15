/**
 * scrollElement 参数为滚动的对象，默认为window
 */
var elements = [];
$.fn.smartFloat = function(options,scrollElement) {
    var position = function(element) {
        var length = elements.length++;
        elements[length] = {};
        elements[length].element = element;
        elements[length].pos = element.css("position");
        elements[length].table = element.parent().find("table");
        elements[length].top = elements[length].table.offset().top;
        elements[length].rows = elements[length].table.find("tr").length;
        if(!scrollElement) scrollElement = $(window);
        if(!options) {options = {}; options.top = 0;}
        elements[length].selement = scrollElement;
        scrollElement.scroll(function() {
            var scrolls = $(this).scrollTop();
            // console.debug('window: scrolls='+scrolls + ",top=" + elements[length].top);
            if (scrolls > elements[length].top - options.top - element.height()) {
                if (window.XMLHttpRequest) {
                    element.css({position: "fixed",top: options.top?options.top:0});
                } else {
                    element.css({top: scrolls});
                }
            }else {
                element.css({position: elements[length].pos,top: elements[length].top});
            }
        });
    };
    return $(this).each(function() {
        position($(this));
    });
};

function checkTop(){
    var isChanged = false;
    for(var i=0; i<elements.length; i++){
        if(elements[i].rows != elements[i].table.find("tr").length){
            isChanged = true;
        }
    }
    if(isChanged){
        for(var i=0; i<elements.length; i++){
            if(elements[i].selement[0] == window){
                //fancybox弹出窗口时，使用window对象监控
                elements[i].top = elements[i].table.offset().top;
            }
            else{
                elements[i].top = elements[i].table.offset().top + elements[i].selement.scrollTop();
            }
            elements[i].rows = elements[i].table.find("tr").length;
        }
    }
}
window.setInterval(checkTop,1000);