<?php


namespace App\Controller;


use src\MyClass\Session;

class ErrorController extends AppController
{
    private $current_menu;

    /**
     * @var Session
     */
    private $session;

    public function __construct(){

        parent::__construct();
        $this->current_menu = 'home';
        $this->session = Session::getSessionInstance();
        // Charge les différentes tables de la base de données

    }

    /**
     * Permet d'afficher la liste des interventions
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home(){
        $this->render('dashboard/home/home.twig');
    }
}