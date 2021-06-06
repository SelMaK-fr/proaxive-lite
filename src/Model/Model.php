<?php


namespace src\Model;

use src\Database\Database;

/**
 * Class Model
 */

class Model{


    protected $model;
    protected $db;


    public function __construct(Database $db){
        $this->db = $db;
        if(is_null($this->model)){
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->model = strtolower(str_replace('Model', '', $class_name));
        }
    }


    /**
     * Permet de lister tous les item d'une table SQL
     *
     * @return mixed
     */
    public function all(){
        return $this->query('SELECT * FROM ' . $this->model . '');
    }

    /**
     * Permet de lister tous les item d'une table SQL
     *
     * @param string $value
     * @return mixed
     */
    public function allByAlpha(string $value){
        return $this->query('SELECT * FROM ' . $this->model . ' ORDER BY ' . $value);
    }

    /**
     * Permet de lister tous les items par son ID
     *
     * @param $idParent
     * @param $id
     * @return mixed
     */
    public function allById($idParent, $id){
        return $this->query("
        	SELECT * 
            FROM {$this->model}
            WHERE ".$idParent." = ?",
            [$id]);
    }



    /**
     * Permet de compter le nombre de ligne d'une table SQL
     *
     * @return mixed
     */
    public function countLines(){
        return $this->query('SELECT COUNT(*) AS nb FROM ' . $this->model);
    }

    /**
     * @return mixed
     */
    public function countItems(){
        return $this->query('SELECT COUNT(id) AS nb FROM ' . $this->model);
    }

    /**
     * @return int
     */
    public function countRow(){
        $rows = $this->query('SELECT id FROM ' . $this->model);
        $total = count($rows);
        return $total;
    }


    /**
     *
     *
     * @param $id
     * @return mixed
     */
    public function countExist($id){
        return $this->query("SELECT COUNT(*) FROM  $this->model WHERE user_mail = '.$id.'");
    }


    /**
     * Permet de lister une ligne défini par son ID
     *
     * @param $idParent
     * @param $id
     * @return mixed
     */
    public function find($idParent, $id){
        return $this->query("
        	SELECT * 
            FROM {$this->model}
            WHERE ".$idParent." = ?",
            [$id], true);
    }

    /**
     * Extrait les champs d'une table dans un tableau (pour balise <select> par exemple)
     *
     * @param $key
     * @param $value
     * @return array
     */
    public function extract($key, $value){
        $records = $this->all();
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }

    /**
     * Extrait les champs d'une table dans un tableau (pour balise <select> par exemple)
     *
     * @param $id
     * @param $key
     * @param $value
     * @return array
     */
    public function extractById($id, $key, $value){
        $records = $this->allById($id, $value);
        $return = [];
        foreach ($records as $v) {
            $return[$v->id] = $v->$key;
        }
        return $return;
    }


    /**
     * Extrait les champs d'une table dans un tableau (pour balise <select> par exemple) par ordre alphabetique
     *
     * @param $key
     * @param $value
     * @return array
     */
    public function extractByAlpha($key, $value){
        $records = $this->allByAlpha($value);
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }


    /**
     * Permet de supprimer une ligne d'une table SQL
     *
     * @param $idParent
     * @param $idget
     * @return mixed
     */
    public function delete($idParent, $idget){
        return $this->query("DELETE FROM {$this->model} WHERE $idParent = ?", [$idget], true);

    }


    /**
     * Permet de mettre à jour une ligne d'une table SQL
     *
     * @param $idParent
     * @param $idget
     * @param $fields
     * @return mixed
     */
    public function update($idParent, $idget, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;

        }
        $attributes[] = $idget;
        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE {$this->model} SET $sql_part WHERE $idParent = ?", $attributes, true);

    }

    /***
     *
     *
     * @param $idParent
     * @param $sql_part
     * @param $getId
     * @return mixed
     */
    public function updateCount($idParent, $sql_part, $getId){
        $attributes = true;
        return $this->query("UPDATE {$this->model} SET $sql_part = $sql_part +1 WHERE $idParent = $getId");

    }

    /**
     * Permet de créer une ligne dans une table SQL
     *
     * @param $fields
     * @return mixed
     */
    public function create($fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;

        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO {$this->model} SET $sql_part", $attributes, true);
    }

    /**
     * Permet de créer des colonnes supplémentaire
     *
     * @param $fields
     * @return mixed
     */
    public function createFields($fields){
        $sql_parts = [];
        foreach($fields as $k){
            $sql_parts[] = $k;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("ALTER TABLE {$this->model} ADD ($sql_part)", '', true);
    }

        /**
     * Permet de modifier des colonnes (type)
     *
     * @param $fields
     * @return mixed
     */
    public function updateFields($fields){
        $sql_parts = [];
        foreach($fields as $k){
            $sql_parts[] = 'MODIFY ' . $k;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("ALTER TABLE {$this->model} $sql_part", '', true);
    }

    /**
     * Permet de générer une requête SQL (query)
     *
     * @param $statement
     * @param null $attributes
     * @param bool $one
     * @return mixed
     */
    public function query($statement, $attributes = null, $one = false){
        if($attributes){
            return $this->db->prepare(
                $statement,
                $attributes,
                str_replace('Model', 'Entity', get_class($this)),
                $one);
        } else {
            return $this->db->query(
                $statement,
                str_replace('Model', 'Entity', get_class($this)),
                $one);
        }
    }

    /**
     * Permet de générer une requête SQL (query)
     *
     * @param $statement
     * @param null $attributes
     * @return mixed
     */
    public function queryAssoc($statement, $attributes = null){
        if($attributes){
            return $this->db->prepareAssoc(
                $statement,
                str_replace('Model', 'Entity', get_class($this)));
        } else {
            return $this->db->queryAssoc(
                $statement,
                str_replace('Model', 'Entity', get_class($this)));
        }
    }


    /**
     * Permet de scanner une ligne d'une table SQL
     *
     * @param $statement
     * @param null $attributes
     * @param bool $one
     * @return mixed
     */
    public function queryscan($statement, $attributes = null, $one = false){
        if($attributes){
            return $this->db->prepare(
                $statement,
                $attributes,
                str_replace('Model', 'Entity', get_class($this)),
                $one);
        } else {
            return $this->db->query(
                $statement,
                str_replace('Model', 'Entity', get_class($this)),
                $one);
        }
    }

    /**
     * Permet de récupérer le dernier ID inséré
     */
    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

    /**
     * Ferme le curseur, permettant à la requête d'être de nouveau exécutée
     *
     * @return mixed
     */
    public function closeCursor(){
        return $this->db->closeCursor();
    }

    /**
     * Permet de vérifier si une valeur existe déjà dans la table
     *
     * @param $name
     * @return mixed
     */
    public function scanField($key, $value){

        return $this->queryscan("SELECT id FROM " . $this->model . " WHERE $key = ?", [$value]);

    }


    /**
     * Permet de vérifier si une ligne est unique
     *
     * @param $id
     * @param $field
     * @param $db
     * @param $table
     * @param $errorMsg
     */
    public function isUniq($id, $field, $db, $table, $errorMsg){
        $record = $this->queryscan("SELECT $id FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();
        if($record){
            $this->errors[$field] = $errorMsg;
        }
    }

}