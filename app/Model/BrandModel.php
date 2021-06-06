<?php


namespace App\Model;

use src\Model\Model;

class BrandModel extends Model
{
    protected $model = 'pl15x_brands'; // Générer un nom de table différent

    /**
     * Permet de vérifier si un nom/titre existe déjà dans la table
     *
     * @param $name
     * @return mixed
     */
    public function scanTitle($name){

        return $this->queryscan("SELECT id FROM " . $this->model . " WHERE b_title = ?", [$name]);

    }
}