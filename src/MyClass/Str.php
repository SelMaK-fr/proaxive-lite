<?php

namespace src\MyClass;

class Str{


	static function random($length){
        $string = "";
        $chaine = "0123456789abcdefghijklmnpqrstuvwxy";
        srand((double)microtime()*1000000);
        for($i = 0; $i < $length; $i++) {
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
	}
}

