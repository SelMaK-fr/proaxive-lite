<?php


namespace App\Model;
use src\Model\Model;


class CompanyModel extends Model
{
    protected $model = 'pl15x_company'; // Générer un nom de table différent


    /**
     * Permet de lister les entreprises avec les départements
     *
     * @return mixed
     */
    public function all(){

        return $this->query("
            SELECT 
            c.id as cid, cname, c.type, director, isdefault, city,logo,created_at,
            d.id as did, d.name as dname
             FROM ".$this->model." as c
            LEFT JOIN pl15x_departments as d ON c.department_id = d.id
            ORDER BY c.created_at DESC");
    }

    public function isDefault() {

        return $this->query("
            SELECT 
            c.id as cid, cname, c.type, director, adress, phone_indicatif, isdefault, phone, mobile,ape, siret, mail, website, about, name, zipcode, city,logo,aprm,rm, facebook,instagram,twitter,linkedin,
            d.id as did, d.name as dname
            FROM ".$this->model." as c
            LEFT JOIN pl15x_departments as d ON c.department_id = d.id
            WHERE isdefault = 1", '', true);
    }

    /**
     * Récupère les items lié à l'utilisateur
     * @param $id and $idParent
     * @param bool $idParent
     * @return array
     */

    public function find($id, $idParent = false){

        return $this->query("
            SELECT c.id as cid, cname, c.type, director, adress, phone_indicatif, country, zipcode, rm, rcs, rc_pro, phone, mobile, fax, website, mail, siret, tva, ape, isdefault, department_id, about, city,logo,facebook,instagram,twitter,linkedin,
            d.id as did, d.name
            FROM ".$this->model." as c
            LEFT JOIN pl15x_departments as d ON d.id = c.department_id
            WHERE c.id = ?", [$id], true);

    }
}