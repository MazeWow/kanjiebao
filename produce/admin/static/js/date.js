Date.prototype.addDays = function(d)
{
    this.setDate(this.getDate() + d);
};

Date.prototype.addWeeks = function(w)
{
    this.addDays(w * 7);
};

Date.prototype.addMonths= function(m)
{
    var d = this.getDate();
    this.setMonth(this.getMonth() + m);
    if (this.getDate() < d)
        this.setDate(0);
};

Date.prototype.addYears = function(y)
{
    var m = this.getMonth();
    this.setFullYear(this.getFullYear() + y);
    if (m < this.getMonth())
     {
        this.setDate(0);
     }
};
Date.prototype.isLeapYear = function()    
{    
    return (0==this.getYear()%4&&((this.getYear()%100!=0)||(this.getYear()%400==0)));    
}

Date.prototype.format = function(fmt)
{
    var o =
     {
        "M+" : this.getMonth() + 1, //月份
        "d+" : this.getDate(), //日
        "h+" : this.getHours(), //小时
        "m+" : this.getMinutes(), //分
        "s+" : this.getSeconds(), //秒
        "q+" : Math.floor((this.getMonth() + 3) / 3), //季度
        "S" : this.getMilliseconds() //毫秒
     };
    if (/(y+)/.test(fmt))
         fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt))
             fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
    /** 
     * 根据给定的格式对给定的字符串日期时间进行解析， 
     * @params strDate 要解析的日期的字符串表示,此参数只能是字符串形式的日期，否则返回当前系统日期 
     * @params strFormat 解析给定日期的顺序, 如果输入的strDate的格式为{Date.parse()}方法支持的格式，<br> 
     *         则可以不传入，否则一定要传入与strDate对应的格式, 若不传入格式则返回当期系统日期。 
     * @return 返回解析后的Date类型的时间<br> 
     *        若不能解析则返回当前日期<br> 
     *        若给定为时间格式 则返回的日期为 1970年1月1日的日期 
     * 
     * bug: 此方法目前只能实现类似'yyyy-MM-dd'格式的日期的转换，<br> 
     *       而'yyyyMMdd'形式的日期，则不能实现 
     */  
Date.prototype.parseDate = function(strDate, strFormat){  
   if(typeof strDate != "string"){  
        return new Date();  
   }  
  var longTime = Date.parse(strDate);  
  if(isNaN(longTime)){  
      if(typeof strFormat === 'undefined'){             
         return new Date();  
      }  
      var tmpDate = new Date();  
      var regFormat = /(\w{4})|(\w{2})|(\w{1})/g;  
      var regDate = /(\d{4})|(\d{2})|(\d{1})/g;  
      var formats = strFormat.match(regFormat);  
      var dates = strDate.match(regDate);  
      if(typeof formats !== 'undefined' && typeof dates !== 'undefined' && formats.length == dates.length){  
        for(var i = 0; i < formats.length; i++){  
          var format = formats[i];  
          if(format === "yyyy"){  
            tmpDate.setFullYear(parseInt(dates[i], 10));  
          }else if(format == "yy"){  
            var prefix = (tmpDate.getFullYear() + "").substring(0, 2);  
            var year = (parseInt(dates[i], 10) + "").length == 4? parseInt(dates[i], 10): prefix + (parseInt(dates[i], 10) + "00").substring(0, 2);  
            var tmpYear = parseInt(year, 10);  
            tmpDate.setFullYear(tmpYear);  
          }else if(format == "MM" || format == "M"){  
            tmpDate.setMonth(parseInt(dates[i], 10) - 1);  
          }else if(format == "dd" || format == "d"){  
            tmpDate.setDate(parseInt(dates[i], 10));  
          }else if(format == "HH" || format == "H"){  
            tmpDate.setHours(parseInt(dates[i], 10));  
          }else if(format == "mm" || format == "m"){  
            tmpDate.setMinutes(parseInt(dates[i], 10));  
          }else if(format == "ss" || format == "s"){  
            tmpDate.setSeconds(parseInt(dates[i], 10));  
          }  
        }  
       return tmpDate;  
     }  
      return tmpDate;  
    }else{  
      return new Date(longTime);  
    }  
}
 /** 
     * 比较两个日期的差距 
     * @param date1 Date类型的时间 
     * @param date2 Dete 类型的时间 
     * @param isFormat boolean 是否对得出的时间进行格式化,<br>  
     *       false:返回毫秒数，true：返回格式化后的数据 
     * @return 返回两个日期之间的毫秒数 或者是格式化后的结果 
     */  
Date.prototype.daysBetween = function(date1, date2, isFormat){  
  try{  
        var len = arguments.length;  
        var tmpdate1 = new Date();  
        var tmpdate2 = new Date();  
        if(len == 1){  
           tmpdate1 = date1;  
        }else if(len >= 2){  
          tmpdate1 = date1;  
          tmpdate2 = date2;  
        }  
    if(!(tmpdate1 instanceof Date) || !(tmpdate2 instanceof Date)){  
       //alert("请输入正确的参数！");  
       return 0;  
    }else{  
        var time1 = tmpdate1.getTime();   
        var time2 = tmpdate2.getTime();  
        var time = Math.max(time1, time2) - Math.min(time1, time2);  
        if(!isNaN(time) && time > 0){  
           if(isFormat){  
              var date = new Date(time);  
              var result = {};  
              /*result += (date.getFullYear() - 1970) > 0? (date.getFullYear() - 1970) + "年":""; 
              result += (date.getMonth() - 1) > 0? (date.getMonth() - 1) + "月": ""; 
              result += (date.getHours() - 8) > 0? (date.getHours() - 1) + "小时": ""; 
              result += date.getMinutes() > 0? date.getMinutes() + "分钟": ""; 
              result += date.getSeconds() > 0? date.getSeconds() + "秒": "";*/  
              result['year']   = (date.getFullYear() - 1970) > 0? (date.getFullYear() - 1970): "0";  
              result['month']  = (date.getMonth() - 1) > 0? (date.getMonth() - 1): "0";  
              result['day']    = (date.getDate() - 1) > 0? (date.getDate() - 1): "0";  
              result['hour']   = (date.getHours() - 8) > 0? (date.getHours() - 1): "0";  
              result['minute'] = date.getMinutes() > 0? date.getMinutes(): "0";  
              result['second'] = date.getSeconds() > 0? date.getSeconds(): "0";  
              return result;  
            }else {  
             return time;  
            }  
        }else{  
          return 0;  
        }  
    }  
  }catch(e){  
    //alert(e.message);  
  }  
}