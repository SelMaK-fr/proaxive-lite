<?php


namespace App\Controller\Dashboard;


use App;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Entity\Entity;
use src\Form\SpectreForm;
use src\MyClass\Session;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminBrandController extends AppController
{
    private $current_menu;

    /**
     * @var session
     */
    private Session $session;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;

    public function __construct(){
        $this->current_menu = 'equipments';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = new Breadcrumbs();
        parent::__construct();
        // Charge les tables de la base de données
        $this->loadModel('Brand');
    }

    /**
     * Permet de lister et d'ajouter un statut
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function home(){
        if(!empty($_POST) && !empty($_POST['b_title'])) {

            // On vérifie si le statut existe ou non
            $nameCategory = $this->Brand->scanTitle($_POST['b_title']);
            // On créer le slug
            $slug = Entity::cleanText($_POST['b_title']);
            if($nameCategory) {
                $this->session->setFlash('danger', "Cette marque existe déjà");
            }else {
                $result = $this->Brand->create([
                    'b_title' => $_POST['b_title'],
                    'b_slug' => $slug,
                    'b_logo' => $_POST['b_logo'],
                ]);
                if($result) {
                    $this->session->setFlash('success', "La marque a bien été ajoutée");
                }
            } // Fin de la condition $nameCategory

        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Equipements', '/admin/equipments')
            ->addCrumb('Marques', '/admin/brands');
        $this->breadcrumbs->render();

        $brands = $this->Brand->All();
        $form = new SpectreForm($_POST);
        $this->render('equipments/admin/brands/home.twig', [
            'form' => $form,
            'brands' => $brands,
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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */

    public function edit(int $id){
        if(!empty($_POST)){
            // On créer le slug
            $slug = Entity::cleanText($_POST['b_title']);
            $result = $this->Brand->update(
                'id', $id,
                [
                    'b_title' => $_POST['b_title'],
                    'b_slug' => $slug,
                    'b_logo' => $_POST['b_logo'],
                ]);
            if($result){
                $this->session->setFlash('success', 'Les données ont bien été modifiées');
            }
        }
        $brand = $this->Brand->find('id', $id);
        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Equipements', '/admin/equipments')
            ->addCrumb('Marques', '/admin/brands')
            ->addCrumb($brand->b_title, '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($brand);
        $this->render('equipments/admin/brands/edit.twig', [
            'brand' => $brand,
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }


    /**
     * Permet de supprimer un statut
     *
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function delete(){
        if(!empty($_POST)){
            $this->Brand->delete('id', $_POST['id']);
            $this->session->setFlash('success', 'La marque a été supprimée de la base de données');
            $this->redirect('/admin/equipments/brands');
        }

    }
}