<?php

namespace src\Database;

use \PDO;
use PDOException;

class MysqlDatabase extends Database
{
    private $pdo;
    /**
     * Retourne PDO avec le fichier de configuration .env
     *
     * @return PDO
     */
    public function getPDO(){
        if ($this->pdo === null)
        {
            try {
                $pdo = new PDO("mysql:dbname=" . getenv('DB_DATABASE') . ";host=" . getenv('DB_HOST'), getenv('DB_USERNAME'),
                    getenv('DB_PASSWORD'), [
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]);
                $this->pdo = $pdo;
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }
        return $this->pdo;
    }


    /**
     *
     *
     * @param $query
     * @param bool|array $params
     * @return PDOStatement
     */
    public function querylow($query, $params = false){
        if($params){
            $req = $this->getPDO()->prepare($query);
            $req->execute($params);
        }else{
            $req = $this->getPDO()->query($query);
        }
        return $req;
    }
    /**
     *
     *
     * @param $statement
     * @param null $class_name
     * @param bool $one
     * @return array|false|mixed|\PDOStatement
     */
    public function query($statement, $class_name = null, $one = false){

        $req = $this->getPDO()->query($statement);
        if(
            strrpos($statement, 'UPDATE') === 0 ||
            strrpos($statement, 'INSERT') === 0 ||
            strrpos($statement, 'ALTER TABLE') === 0 ||
            strrpos($statement, 'DELETE') === 0
        ){
            return $req;
        }
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if($one){
            $data = $req->fetch();
        }   else {
            $data = $req->fetchAll();
        }
        return $data;
    }

    /**
     *
     *
     * @param $statement
     * @param null $class_name
     * @return array|false|mixed|\PDOStatement
     */
    public function queryAssoc($statement, $class_name = null){
        $req = $this->getPDO()->query($statement);
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_ASSOC);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     *
     * true = 1 seul résultat
     *
     * @param $statement
     * @param $attribute
     * @param null $class_name
     * @param bool $one
     * @return array|bool|mixed
     */
    public function prepare($statement, $attribute, $class_name = null, $one = false){
        $req = $this->getPDO()->prepare($statement);
        $res = $req->execute($attribute);
        if(
            strrpos($statement, 'UPDATE') === 0 ||
            strrpos($statement, 'INSERT') === 0 ||
            strrpos($statement, 'DELETE') === 0
        ){
            return $res;
        }
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if($one){
            $data = $req->fetch();
        }   else {
            $data = $req->fetchAll();
        }
        return $data;
    }

    /**
     *
     *
     * @param $statement
     * @param null $class_name
     * @return array|false|mixed|\PDOStatement
     */
    public function prepareAssoc($statement, $class_name = null){
        $req = $this->getPDO()->prepare($statement);
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_ASSOC);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Permet de récupérer le dernier ID inséré lors de la dernière requête SQL
     *
     * @return string
     */
    public function lastInsertId(){
        return $this->getPDO()->lastInsertId();
    }

    /**
     * Permet de fermer le cursor SQL
     *
     * @return mixed
     */
    public function closeCursor(){
        return $this->getPDO()->closeCursor();
    }

}