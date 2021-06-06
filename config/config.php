<?php

use Symfony\Component\Dotenv\Dotenv;

class Config
{

    private static $envLoaded = false;

    /**
     * Charge le fichier de configuration
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

    /**
     * Initialise PDO
     * @return PDO
     */
    public static function getPDO()
    {
        self::loadEnv();
        $pdo = new PDO("mysql:dbname=" . getenv('DB_DATABASE') . ";host=" . getenv('DB_HOST'), getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        return $pdo;
    }
}
