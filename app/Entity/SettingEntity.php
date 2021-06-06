<?php


namespace App\Entity;


use src\Entity\Entity;

class SettingEntity extends Entity
{

    public function getUrl(){

        return '/admin/setting/css/' . $this->theme . '/' . $this->file;
    }
}