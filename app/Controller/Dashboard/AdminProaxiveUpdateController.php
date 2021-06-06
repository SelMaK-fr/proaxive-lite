<?php


namespace App\Controller\Dashboard;


use Creitive\Breadcrumbs\Breadcrumbs;
use src\Form\SpectreForm;
use src\MyClass\Paginator;
use src\MyClass\Session;

class AdminProaxiveUpdateController extends AppController
{
    private $current_menu;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;

    public function __construct(){

        parent::__construct();
        $this->current_menu = 'home';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = new Breadcrumbs();
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

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Proaxive Update', '/admin/updates')
            ->addCrumb('Mise à jour BDD', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($_POST);
        $this->render('dashboard/update/model.twig', [
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }
}