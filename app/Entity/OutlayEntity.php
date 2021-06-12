<?php


namespace App\Entity;

use src\Entity\Entity;

class OutlayEntity extends Entity
{
    public function getsign()
    {
        if ($this->signature == 1) {
            return '<span class="label label-info">Signé</span>';
        } else {
            return '<span class="label label-danger">A signer</span>';
        }
    }

    public function getLabelRefund()
    {
        if ($this->refund == null) {
            return '<span class="label label-warning">En attente</span>';
        } else {
            return '<span class="label label-success">Ok le '.date($this->refund).'</span>';
        }
    }
}