<?php

namespace App\Controller;

use src\Form\SpectreForm;
use src\MyClass\Session;

class HomeController extends AppController
{

    /**
     * @var string
     */
    private $current_menu;

    /**
     * @var session
     */
    private $session;

    public function __construct(){
        // Chargements des tables SQL
        parent::__construct();
        $this->current_menu = 'home';
        $this->session = Session::getSessionInstance();
        $this->loadModel('Intervention');
        $this->loadModel('Equipment');
        $this->loadModel('Company');
    }

    /**
     * Permet d'affiche le formulaire de recherche d'intervention (est aussi la page d'accueil utilisateur)
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home(){
        // Initialisation de la variable intervention
        $intervention = false;
        // Vérifie si le champ est correct et renseigné
        if(!empty($_POST)) {
            $word = htmlspecialchars($_POST['search_intervention']);
            $whitelist = '/^[a-zA-Z0-9 ,\.\\n;:\-]+$/';
            $valid = preg_match($whitelist, $word);
            if($valid == false){
                $this->session->setFlash('danger', "<strong>Erreur XSS :</strong> merci de renseigner un numéro d'intervention");
                $this->redirect('/');
            }
            $scanInput = filter_input(INPUT_POST, 'search_intervention', FILTER_SANITIZE_SPECIAL_CHARS);
            if(!empty($scanInput['search_intervention'])){
                $this->session->setFlash('danger', "<strong>Erreur :</strong> merci de renseigner un numéro d'intervention");
                return false;
            }
            // Va rechercher le numéro d'intervention
            if ($scanInput) {
                $intervention = $this->Intervention->search($word, 'search_intervention');
                if (!empty($intervention))
                {
                    // Redirige vers l'intervention
                    $this->redirect('/i/' . $intervention->number_link);
                } else {
                    $this->session->setFlash('danger', "<strong>Erreur :</strong> aucun résultat pour ce numéro.");
                }
            } else {
                $this->session->setFlash('danger', "<strong>Erreur :</strong> ce n'est pas un numéro d'intervention valide");
            }
        }

        $company = $this->Company->isDefault(1);
        $form = new SpectreForm($_GET);
        $this ->render('home/home.twig', [
            'form' => $form,
            'intervention' => $intervention,
            'company' => $company,
            'current_menu' => $this->current_menu
        ]);
    }
}