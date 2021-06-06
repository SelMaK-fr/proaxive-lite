/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./langs/tail.datetime-in.js
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
/*
 |  Translator:     thenewzhugeliang - (https://github.com/thenewzhugeliang)
 |  GitHub:         https://github.com/pytesNET/tail.DateTime/issues/53
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
    datetime.strings.register("id", {
        months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        days:   ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
        shorts: ["MIN", "SEN", "SEL", "RAB", "KAM", "JUM", "SAB"],
        time:   ["Jam", "Menit", "Detik"],
        header: ["Pilih Bulan", "Pilih Tahun", "Pilih Dekade", "Pilih Jam"]
    });
    return datetime;
}));
