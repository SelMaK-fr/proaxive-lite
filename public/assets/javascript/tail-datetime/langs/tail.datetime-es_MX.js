/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-es_MX.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     elPesecillo - (https://github.com/elPesecillo)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/issues/34
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
    datetime.strings.register("es_MX", {
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        days:   ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        shorts: ["DO", "LU", "MA", "MI", "JU", "VI", "SÁ"],
        time:   ["Horas", "Minutos", "Segundos"],
        header: ["Selecciona un Mes", "Selecciona un Año", "Selecciona una Decada", "Selecciona la Hora"]
    });
    return datetime;
}));
