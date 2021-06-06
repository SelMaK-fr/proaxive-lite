/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-it.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     Fabio Di Stasio - (https://github.com/Fabio286)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/issues/10
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
    datetime.strings.register("it", {
        months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        days:   ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
        shorts: ["DOM", "LUN", "MAR", "MER", "GIO", "VEN", "SAB"],
        time:   ["Ore", "Minuti", "Secondi"],
        header: ["Seleziona un mese", "Seleziona un anno", "Seleziona un decennio", "Seleziona un orario"]
    });
    return datetime;
}));
