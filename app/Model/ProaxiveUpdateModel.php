<?php


namespace App\Model;


use src\Model\Model;

class ProaxiveUpdateModel extends Model
{

    /**
     * Permet de mettre à jour la table Interventions
     * Ajout du champ note_tech
     * @return mixed
     */
    public function addFieldNoteTechFromIntervention(){
        return $this->query("
            ALTER TABLE pl15x_interventions
            ADD note_tech LONGTEXT NULL");
    }
}