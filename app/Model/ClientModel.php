<?php

namespace App\Model;

use src\Model\Model;

/**
* Class ClientModel
*
*/


class ClientModel extends Model {

    protected $model = 'pl15x_clients';
    
    /**
     * Récupère toutes les infos d'un utilisateur en cours
     * @param type $id
     * @param type $idParent
     * @return type
     */

	public function findWithdepartments($id, $idParent = false){

		return $this->query("SELECT 
            c.id as c_id, lastname, firstname, civility, mail, fullname, phone, mobile, adress, zipcode, city, department_id, validated, activated,
            d.id as d_id, code, name, soundex
            FROM " . $this->model . " as c
            LEFT JOIN pl15x_departments d on c.department_id = d.id
            WHERE c.id = ?", [$id], true);

	}

    /**
     * Récupère toutes les infos d'un utilisateur en cours
     * @param type $id
     * @param bool $idParent
     * @param int $value
     * @return type
     */

    public function selectWithdepartmentsBySleeping(int $value){

        return $this->query("SELECT 
            c.id as c_id, lastname, firstname, civility, sleeping, mail, fullname, phone, mobile, adress, zipcode, city, department_id, validated, activated,
            d.id as d_id, code, name, soundex
            FROM " . $this->model . " as c
            LEFT JOIN pl15x_departments d on c.department_id = d.id
            WHERE c.sleeping = $value ORDER BY lastname DESC");

    }
        

    /**
     * Récupère tous les utilisateurs sauf le role GOD
     * @return type
     */    

    public function allWithDepartments(){

        return $this->query("SELECT 
            c.id as c_id, fullname, sleeping, city, mail, updated_at, created_at,zipcode,phone,mobile,
            d.id as d_id, name, code
            FROM " . $this->model . " c
            LEFT JOIN pl15x_departments d ON c.department_id = d.id
            ORDER BY created_at DESC");

    }

    /**
     * Récupère tous les utilisateurs sauf le role GOD
     * @return type
     */

    public function selectWithDepartmentsLimit(int $limit){

        return $this->query("SELECT 
            c.id as c_id, fullname, city, mail, updated_at, created_at,zipcode,phone,mobile,
            d.id as d_id, name, code
            FROM " . $this->model . " c
            LEFT JOIN pl15x_departments d ON c.department_id = d.id
            ORDER BY created_at DESC LIMIT 0, ".$limit);

    }

    /**
     * Permet de récupérer tous les équipements
     *
     * @return mixed
     */
    public function exportClients(){

        return $this->queryAssoc("
            SELECT 
            *
            FROM ".$this->model." as c
            ORDER BY c.firstname DESC", false);
    }

    /**
     * Scan le champ user_mail de la table users
     * @param type $name
     * @return type
     */
    
    public function scanMail($name){

      return $this->query("SELECT id FROM " . $this->model . " WHERE mail = ? AND activated IS NOT NULL", [$name], true);

    }

    /**
     * 
     * @param type $name
     * @return type
     */
    
    public function scanName($name){

      return $this->queryscan("SELECT id FROM " . $this->model . " WHERE fullname = ?", [$name]);

    }

}