<?php

namespace src\Entity;

class Entity{

    public function __get($key){
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;

    }

    /**
     * Retourne un champ d'une ligne si non renvoi false
     *
     * @param $data
     * @param $text
     * @return mixed
     */
    public function getData($data, $text){
        if(empty($data)){
            return $data;
        }else{
            return $text;
        }
    }


    /**
     * Transformer un texte en URL
     * @return
     */
    public static function cleanText($item){
        // remplacer ces caractères ...
        $charSpec = array( 'à','â','ä','È','É','é','è','ê','ë','î','ï','ô','ù','û','ç' );
        // ... par ceux-ci
        $CharClean = array( 'a','a','a','E','E','e','e','e','e','i','i','o','u','u','c' );
        // Supprime de $titre les accents, trémas et cédilles
        $firstName = str_replace($charSpec, $CharClean, $item);
        // Convertit en minuscules
        $firstName = strtolower($firstName);
        // Remplace les caractères non-alphanumériques par des tirets
        $firstName = preg_replace("/[^A-Za-z0-9]/", '-', $firstName );
        // Remplace les tirets multiples par un tiret unique
        $firstName = preg_replace("/\-+/", '-', $firstName );
        // Supprime le dernier caractère si c'est un tiret
        $firstName = rtrim($firstName, '-');
        return $firstName;
    }

}