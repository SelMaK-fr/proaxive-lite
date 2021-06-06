<?php

namespace App\Controller\Dashboard;
use App;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Form\SpectreForm;
use src\MyClass\Session;

/**
 * Description of StatusController
 *
 * @author SelMaK
 */
class AdminStatusController extends AppController{

    private $current_menu;

    /**
     * @var session
     */
    private $session;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;

    public function __construct(){
        $this->current_menu = 'home';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = new Breadcrumbs();
		parent::__construct();
        // Charge les tables de la base de données
        $this->loadModel('Status');
	    }

    /**
     * Permet de lister et d'ajouter un statut
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
        public function home(){
            if(!empty($_POST)) {
                if(!empty($_POST['title']) && !empty($_POST['bgcolor']))
                {
                    // On vérifie si le statut existe ou non
                    $nameStatus = $this->Status->scanTitle($_POST['title']);
                    if($nameStatus) {
                        $this->session->setFlash('danger', "Ce statut existe déjà");
                    } else {

                        $result = $this->Status->create([
                            'title' => $_POST['title'],
                            'bgcolor' => $_POST['bgcolor'],
                            'not_delete' => false,
                        ]);

                        if($result){
                            $this->session->setFlash('success', 'Le statut a bien été ajouté !');
                        }
                    }
                } else {
                    $this->session->setFlash('danger', 'Tous les champs ne sont pas remplis');
                }
            }

            $status = $this->Status->last();
            //Breadcrumb
            $this->breadcrumbs->addCrumb('Accueil', '/admin')
                ->addCrumb('Status', '');
            $this->breadcrumbs->render();

            $form = new SpectreForm($_POST);
            $this->render('dashboard/status/home.twig', [
                'form' => $form,
                'status' => $status,
                'current_menu' => $this->current_menu,
                'breadcrumbs' => $this->breadcrumbs
            ]);


        }

    /**
     * Permet d'éditer un statut
     *
     * @render
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
        
        public function edit(int $id){
            
            if(!empty($_POST['title'])){
                    $result = $this->Status->update(
                        'id', $id,
                        [
                        'title' => $_POST['title'],
                        'bgcolor' => $_POST['bgcolor']
                    ]);
                    if($result){
                        $this->session->setFlash('success', 'Les données ont bien été modifiées');
                    }
                }

            $status = $this->Status->find('id', $id);

            //Breadcrumb
            $this->breadcrumbs->addCrumb('Accueil', '/admin')
                ->addCrumb('Status', '/admin/status')
                ->addCrumb($status->title, '');
            $this->breadcrumbs->render();

            $form = new SpectreForm($status);
            $this->render('dashboard/status/edit.twig', [
                'status' => $status,
                'form' => $form,
                'current_menu' => $this->current_menu,
                'breadcrumbs' => $this->breadcrumbs
            ]);
        }


    /**
     * Permet de supprimer un statut
     *
     * @return void
     */
        public function delete(){
        if(!empty($_POST)){
            $this->Status->delete('id', $_POST['id']);
            $this->session->setFlash('success', 'Le statut a été supprimé de la base de données');
            return $this->redirect('/admin/status');
        }

        }
}