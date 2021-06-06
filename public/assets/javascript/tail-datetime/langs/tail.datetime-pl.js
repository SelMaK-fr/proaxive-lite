/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-pt_BR.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     Jacob273 - (https://github.com/Jacob273)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/pull/32
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
    datetime.strings.register("pl", {
        months: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"],
        days:   ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"],
        shorts: ["ND", "PN", "WT", "ŚR", "CZW", "PT", "SOB"],
        time:   ["Godzina", "Minuta", "Sekunda"],
        header: ["Wybierz miesiąc", "Wybierz rok", "Wybierz dekadę", "Wybierz czas"]
    });
    return datetime;
}));
