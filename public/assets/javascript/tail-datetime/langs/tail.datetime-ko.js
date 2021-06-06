/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-ko.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     huhushow - (https://github.com/huhushow)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/issues/49
 */
;(function(factory){
    if(typeof(define) == "function" && define.amd){
        define(function(){
            return function(datetime){ factory(datetime); };
        });
    } else {
        if(typeof(window.tail) != "undefined" && window.tail.DateTime){
            factory(window.tail.DateTime);
        }
    }
}(function(datetime){
    datetime.strings.register("ko", {
        months: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
        days:   ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"],
        shorts: ["일", "월", "화", "수", "목", "금", "토"],
        time:   ["시", "분", "초"], 
        header: ["월 선택", "연도 선택", "연대 선택", "시간 선택"]
    });
    return datetime;
}));
 
