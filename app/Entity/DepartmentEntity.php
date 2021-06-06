<?php

namespace App\Entity;

use src\Entity\Entity;

/**
 * Description of DepartmentEntity
 *
 * @author SelMaK
 */
class DepartmentEntity extends Entity {


    /**
     * Genere une URL de l'item Post
     */

    public function geturlAdmin(){

        $url = '/admin/edit-department/'. $this->id;
        return $url;

    }
}
