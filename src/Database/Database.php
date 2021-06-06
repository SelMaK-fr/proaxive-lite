<?php

namespace src\Database;

use src\MyClass\Session;

class Database extends Session
{

    /**
     *
     *
     * @param $statement
     * @param null $class_name
     * @param bool $one
     * @return mixed
     */
    public function queryscan($statement, $class_name = null, $one = false){
        $req = $this->getPDO()->query($statement);
        return $req;
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
     * @param bool $one
     * @return mixed
     */
    public function querygroup($statement, $class_name = null, $one = false){
        $req = $this->getPDO()->query($statement);
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_OBJ | PDO::FETCH_GROUP);
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
}