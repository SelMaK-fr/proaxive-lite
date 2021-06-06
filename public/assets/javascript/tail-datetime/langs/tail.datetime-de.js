/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-de.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     SamBrishes - (https://www.pytes.net)
 |  GitHub:         <internal>
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
    datetime.strings.register("de", {
        months: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
        days:   ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
        shorts: ["SO", "MO", "DI", "MI", "DO", "FR", "SA"],
        time:   ["Stunden", "Minuten", "Sekunden"],
        header: ["Wähle einen Monat", "Wähle ein Jahr", "Wähle ein Jahrzehnt", "Wähle eine Uhrzeit"]
    });
    return datetime;
}));
