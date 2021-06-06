<?php


namespace App\Entity;


use src\Entity\Entity;

class BrandEntity extends Entity
{
    /**
     * Permet de générer le lien d'édition du client
     *
     * @return string
     */
    public function getUrlAdmin()
    {
        return '/admin/equipments/edit-brand/'.$this->id;
    }
}