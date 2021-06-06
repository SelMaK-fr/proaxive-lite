/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-nl.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     Mickeybyte - (https://github.com/mickeybyte)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/issues/15
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
    datetime.strings.register("nl", {
        months: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"],
        days:   ["Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag"],
        shorts: ["ZO", "MA", "DI", "WO", "DO", "VR", "ZA"],
        time:   ["Uur", "Minuten", "Seconden"],
        header: ["Kies een Maand", "Kies een Jaar", "Kies een Decennium", "Kies een Tijdstip"]
    });
    return datetime;
}));
