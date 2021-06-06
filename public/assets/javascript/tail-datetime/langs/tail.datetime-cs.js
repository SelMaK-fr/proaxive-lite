/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-cs.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     Milan Kyncl - (https://github.com/milankyncl)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/pull/39
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
    datetime.strings.register("cs", {
        months: ["Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec"],
        days:   ["Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota"],
        shorts: ["NE", "PO", "ÚT", "ST", "ČT", "PÁ", "SO"],
        time:   ["Hodiny", "Minuty", "Sekundy"],
        header: ["Vyberte měsíc", "Vyberte rok", "Vyberte desetiletí", "Vyberte čas"]
    });
    return datetime;
}));
