<?php declare(strict_types=1);
use src\Config;
use src\Database\MysqlDatabase;
use src\MyClass\Session;
use src\Auth\Auth;

class App{

    private $db_instance;
    private static $_instance;

    /**
     * @return mixed
     */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new App();
        }
        return new self::$_instance;
    }


    /**
     * @return Auth
     */
    public static function getAuth(){
        return new Auth(Session::getSessionInstance(), ['restriction_msg' => 'Permission refusée']);
    }


    public static function load(){
        //session_start();
        // Chargement Autoloader.php (App)
        require ROOT . '/app/Autoloader.php';
        App\Autoloader::register();
        // Chargement Autoloader.php (src)
        require ROOT . '/src/Autoloader.php';
        src\Autoloader::register();

    }

    /**
     * Vérifie si le dossier vendor existe
     */
    public static function scanFolder(){
        $vendorFolder = ROOT. '/vendor';
        if (!file_exists($vendorFolder)) {
            echo "Le dossier <strong>vendor</strong> n'existe pas. Les packages doivent être installés via Composer (accès SSH requis).";
        }
    }

    /**
     * Charge le fichier de configuration pour toute l'application
     * @return mixed
     */
    public static function getEnv()
    {
        return Config::getInstance(ROOT . '/config/config.php');
    }

    /**
     * Charge le fichier de configuration pour toute l'application
     * @return mixed
     */
    public static function getJson()
    {
        $viewJsonFile = file_get_contents(ROOT. '/config/setting.json');
        return json_decode($viewJsonFile, false);

    }


    /**
     * Permet de générer les Model
     *
     * @param $name
     * @return mixed
     */
    public function getModel($name){
        $class_name = '\\App\\Model\\' . ucfirst($name) . 'Model'; // Récupère le nom de la Table (fichier Table en gros)
        return new $class_name($this->getDb()); // Retourne la varibable $class_name modifiée
    }


    /**
     * @return MysqlDatabase
     */
    public function getDb(){
        $config = Config::getInstance(ROOT . '/config/config.php');
        if(is_null($this->db_instance)){
            $this->db_instance = new MysqlDatabase(
                $config->get('db_name'),
                $config->get('db_user'),
                $config->get('db_pass'),
                $config->get('db_host'));
        }
        return $this->db_instance;
    }

    /**
     * Récupère le dernier ID
     */
    public function lastInsertId(){
        return $this->getPDO()->lastInsertId();
    }

}