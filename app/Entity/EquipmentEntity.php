<?php


namespace App\Entity;


use src\Entity\Entity;

class EquipmentEntity extends Entity
{

    public function geturlAdmin() {
        $url = '/admin/edit-equipment/' .$this->eid;
        return $url;
    }

    public function getEtat()
    {
        if ($this->status == 1) {
            return '<span class="label label-success">Fonctionnel</span>';
        } else {
            return '<span class="label label-danger">Hors-Service</span>';
        }
    }

    public function getworkshop()
    {
        if ($this->inworkshop == 1) {
            return '<span class="label label-info">En atelier</span>';
        } else {
            return '<span class="label label-success">Sortie</span>';
        }
    }

}