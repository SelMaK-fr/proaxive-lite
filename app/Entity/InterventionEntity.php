<?php

namespace App\Entity;
use src\Entity\Entity;

/**
 * Description of InterventionEntity
 *
 * @author SelMaK
 */
class InterventionEntity extends Entity{


    /**
     * Retourne le lien d'édition d'une intervention
     * Dashboard
     * @return string
     */
    public function getUrlAdmin()
    {
        return '/admin/edit-intervention/' . $this->idi;

    }

    /**
     * Retourne le lien de la vue d'intervention
     * Public
     * @return string
     */
    public function getUrl()
    {
        return '/i/'.$this->number_link;
    }
    
    /**
     * Genere le statut
     * @return
     */
    public function getStatus()
    {
        if ($this->closed == 1) {
            return '<span class="label label-success">Cloturé le '.$this->close_date.'</span>';
        } else {
            return '<span class="label" style="background-color:#'.$this->bgcolor.'">'.$this->tstatus.'</span>';
        }
    }

    /**
     * Génère l'état de l'intervention  sans texte (circle) (cloture)
     * @return string
     */
    public function getEtat()
    {
        if ($this->closed == 1) {
            return '<span class="label label-success label-circle"></span>';
        } else {
            return '<span class="label label-danger label-circle"></span>';
        }
    }

    /**
     * Génère l'état de l'intervention avec texte (cloture)
     * @return string
     */
    public function getEtatTxt()
    {
        if ($this->closed == 1) {
            return '<span class="label label-success">Cloturée</span>';
        } else {
            return '<span class="label label-danger">Non cloturée</span>';
        }
    }
}