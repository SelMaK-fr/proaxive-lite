<?php


namespace App\Controller;


use App;
use src\Auth\Auth;
use src\MyClass\Session;

class UserController extends AppController
{

    /**
     * @var Session
     */
    private Session $session;

    public function __construct(){
        // Chargements des tables SQL
        parent::__construct();
        $this->session = Session::getSessionInstance();
        // Restriction
        App::getAuth()->isAdminOnly();
    }

    /**
     * Permet de détruire la session et d'être redirigé vers l'accueil du site
     *
     */
    public function logout()
    {
        $viewJsonFile = file_get_contents(ROOT. '/config/setting.json');
        $viewJson = json_decode($viewJsonFile, false);

        $this->session->delete('auth');
        $this->session->setFlash('success', "Vous êtes maintenant déconnecté");
        $this->redirect($viewJson->app_login_url);
    }
}