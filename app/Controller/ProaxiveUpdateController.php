<?php


namespace App\Controller;


use src\Form\SpectreForm;
use src\MyClass\Paginator;
use src\MyClass\Session;

class ProaxiveUpdateController extends AppController
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
        $this->loadModel('ProaxiveUpdate');
        $this->loadModel('User');

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

    /**
     * 
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updateDatabase(){

        if(!empty($_POST['number_version'])){
            $result = $this->User->createFields([
                'key_totp VARCHAR(100) NULL'
            ]);
            /*$update = $this->Intervention->updateFields([
                'received datetime NULL'
            ]);*/
            if($result){
                $this->session->setFlash('success', 'La base de données a été mise à jour !');
            }
        }
        $form = new SpectreForm($_POST);
        $this->render('dashboard/update/model.twig', [
            'form' => $form,
            'current_menu' => $this->current_menu
        ]);

    }
}