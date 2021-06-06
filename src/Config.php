<?php

namespace src;

use Symfony\Component\Dotenv\Dotenv;

class Config
{
    private $settings = [];
    private static $_instance;
    private static $envLoaded = false;

    /**
     *
     */
    private static function loadEnv()
    {
        if(self::$envLoaded) {
            return;
        }
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__) . '/.env');
        self::$envLoaded = true;
    }

    public static function getInstance(){

        if(is_null(self::$_instance)){
            self::$_instance = new Config();
        }

        return new self::$_instance;

    }

    public function __construct(){
        self::loadEnv();
    }


    /**
     *
     */

    public function get($key){

        if(!isset($this->settings[$key])){

            return null;
        }

        return $this->settings[$key];
    }
}