<?php
namespace App\Entity;

use src\Entity\Entity;
/**
* Class CatuserEntity
*/


class RoleauserEntity extends Entity{

    /**
    * Genere une URL de l'item Post
    */
    
    public function geturlAdmin(){

        $url = '/admin/ausers/role/'. $this->id;
        return $url;
        
    }
    

	}
