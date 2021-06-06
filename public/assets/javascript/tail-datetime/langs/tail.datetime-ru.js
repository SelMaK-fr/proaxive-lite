/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-ru.js
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
    datetime.strings.register("ru", {
        months: ["январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь"],
        days:   ["воскресенье", "понедельник", "вторник", "среда","четверг","пятница","суббота",],
        shorts: ["вс", "пн", "вт", "ср", "чт", "пт", "сб"],
        time:   ["часов", "минут", "секунд"],
        header: ["Выберите месяц", "Выберите год", "Выберите Десятилетие", "Выберите время"]
    });
    return datetime;
}));
