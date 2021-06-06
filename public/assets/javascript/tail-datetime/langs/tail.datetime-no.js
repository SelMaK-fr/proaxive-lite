/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-no.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     Lars Athle Larsen - (https://github.com/larsathle)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/pull/31
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
    datetime.strings.register("no", {
        months: ["Januar", "Februar", "Mars", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Desember"],
        days:   ["Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag"],
        shorts: ["SØN", "MAN", "TIR", "ONS", "TOR", "FRE", "LØR"],
        time:   ["Timer", "Minutter", "Sekunder"],
        header: ["Velg måned", "Velg år", "Velg tiår", "Velg klokkeslett"]
    });
    return datetime;
}));
