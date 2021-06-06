<?php


namespace App\Model;

use src\Model\Model;

class EquipmentModel extends Model
{
    protected $model = 'pl15x_equipments'; // Générer un nom de table différent

    /**
     * Permet de récupérer tous les équipements
     *
     * @return mixed
     */
    public function allWithClientCategoryBrandsOS(){

        return $this->query("
            SELECT 
            e.id as eid, e.name as ename, inworkshop, content,status,
            c.id as cid, fullname,
            ce.id as ceid, ce.title,
            b.b_title,
            os_name, os_release, os_architecture
            FROM ".$this->model." as e
            LEFT JOIN pl15x_clients as c ON c.id = e.client_id
            LEFT JOIN pl15x_category_equipments as ce ON e.category_equipment_id = ce.id
            LEFT JOIN pl15x_brands as b ON e.brand_id = b.id
            LEFT JOIN pl15x_operating_systems as os ON e.operating_systems_id = os.id
            ORDER BY e.created_at DESC");
    }



    public function findByClient($foreign)
    {
        return $this->query("SELECT 
        e.id as eid, name, updated_at, title, client_id, content, serialnumber, numberproduct, year, inworkshop,status,
        ce.id as ceid, title,
        b.id as bid, b_title
        FROM ".$this->model." as e
        LEFT JOIN pl15x_category_equipments as ce ON e.category_equipment_id = ce.id
        LEFT JOIN pl15x_brands as b ON e.brand_id = b.id
        WHERE e.id = ?", [$foreign], true);
    }

    /**
     * Permet de récupérer tous les équipements d'un client
     *
     * @param $foreign
     * @return mixed
     */
    public function byclient($foreign)
    {
        return $this->query("SELECT 
        e.id as eid, name, updated_at, title, client_id, content,status,
        ce.id as ceid, title, icon,
        b.id as bid, b_title
        FROM ".$this->model." as e
        LEFT JOIN pl15x_category_equipments as ce ON e.category_equipment_id = ce.id
        LEFT JOIN pl15x_brands as b ON e.brand_id = b.id
        WHERE client_id = ?", [$foreign]);
    }

    /**
     * Permet de récupérer un ordinateur affilié à une intervention
     *
     * @param $foreign
     * @return mixed
     */
    public function findByIntervention($foreign)
    {
        return $this->query("SELECT 
        *
        FROM ".$this->model." as e
        LEFT JOIN pl15x_interventions as i ON e.id = i.equipment_id
        LEFT JOIN pl15x_brands as b ON e.brand_id = b.id
        LEFT JOIN pl15x_operating_systems as os ON e.operating_systems_id = os.id
        WHERE i.equipment_id = ?", [$foreign], true);
    }

    /**
     * Permet de récupérer les équipements en atelier
     *
     * @param $limit
     * @return mixed
     */
    public function allWithCategoryAndBrandInWork() {
        return $this->query("
            SELECT 
            e.id as eid, e.name as ename, inworkshop, content, e.created_at as edate, e.updated_at as eupdate,status,
            c.id as cid, fullname,
            ce.id as ceid, ce.title as ce_title, icon,
            b.b_title
            FROM ".$this->model." as e
            LEFT JOIN pl15x_clients as c ON c.id = e.client_id
            LEFT JOIN pl15x_category_equipments as ce ON e.category_equipment_id = ce.id
            LEFT JOIN pl15x_brands as b ON e.brand_id = b.id
            WHERE inworkshop = 1
            ORDER BY e.created_at DESC");
    }

    /**
     * Permet de récupérer les équipements en atelier
     *
     * @param $limit
     * @return mixed
     */
    public function selectWithCategoryInWork($limit) {
        return $this->query("
            SELECT 
            e.id as eid, e.name as ename, inworkshop, content, e.created_at as edate, e.updated_at as eupdate,status,
            c.id as cid, fullname,
            ce.id as ceid, ce.title as ce_title, icon
            FROM ".$this->model." as e
            LEFT JOIN pl15x_clients as c ON c.id = e.client_id
            LEFT JOIN pl15x_category_equipments as ce ON e.category_equipment_id = ce.id
            WHERE inworkshop = 1
            ORDER BY e.created_at DESC LIMIT ".$limit);
    }

    /**
     * Permet de récupérer tous les équipements
     *
     * @return mixed
     */
    public function exportWithClientCategoryBrandsOS(){

        return $this->queryAssoc("
            SELECT 
            e.id as ID, e.name as Nom, content as Caracteristique,
            fullname as Client,
            ce.title as Categorie,
            b.b_title as Marque,
            os_name as OS, os_release as Version, os_architecture as Architecture
            FROM ".$this->model." as e
            LEFT JOIN pl15x_clients as c ON c.id = e.client_id
            LEFT JOIN pl15x_category_equipments as ce ON e.category_equipment_id = ce.id
            LEFT JOIN pl15x_brands as b ON e.brand_id = b.id
            LEFT JOIN pl15x_operating_systems as os ON e.operating_systems_id = os.id
            ORDER BY e.id DESC", false);
    }

}