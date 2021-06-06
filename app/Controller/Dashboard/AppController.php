<?php

namespace App\Controller\Dashboard;

use App;

class AppController extends App\Controller\AppController
{

    public function __construct()
    {
        parent::__construct();
        // Accès autorisé uniquement aux administrateurs
        App::getAuth()->isAdminOnly();
    }
}