<?php


namespace App\Controller;
use src\Controller\Controller;
use \App;

class AppController extends Controller
{
    public function loadModel($model_name){
        $this->$model_name = App::getInstance()->getModel($model_name);
    }

}