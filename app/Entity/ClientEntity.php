<?php

namespace App\Entity;

use src\Entity\Entity;

/**
* Class UserEntity
*/

class ClientEntity extends Entity{

    /**
     * Permet de générer le lien d'édition du client
     *
     * @return string
     */
    public function getUrlAdmin()
    {
        return '/admin/client/'.$this->c_id;
    }

    /**
     * Permet de générer un lien vers la fiche cliente
     *
     * @return string
     */
    public function getUrl()
    {
        return '/admin/client/'. $this->c_id;
    }

}
