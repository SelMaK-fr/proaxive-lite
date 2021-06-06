<?php


namespace App\Controller\Dashboard;


use App;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Form\SpectreForm;
use src\MyClass\Session;

class AdminCategoriesEquipmentController extends AppController
{
    private $current_menu;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;

    public function __construct(){
        $this->current_menu = 'equipments';
        $this->breadcrumbs = new Breadcrumbs();
        parent::__construct();
        // Charge les tables de la base de données
        $this->loadModel('CategoryEquipment');
    }

    /**
     * Permet de lister et d'ajouter un statut
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home(){
        $session = Session::getSessionInstance();

        if(!empty($_POST['title']) && !empty($_POST['color']))
        {
            $result = $this->CategoryEquipment->create([
                'title' => $_POST['title'],
                'color' => $_POST['color'],
                'slug' => $_POST['slug'],
                'icon' => $_POST['icon']
            ]);

            if($result){
                $session->setFlash('success', 'Le statut a bien été ajouté !');
            }
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Equipements', '/admin/equipments')
            ->addCrumb('Catégories', '');
        $this->breadcrumbs->render();

        $categories = $this->CategoryEquipment->all();
        $form = new SpectreForm($_POST);
        $this->render('equipments/admin/categories/home.twig', [
            'form' => $form,
            'categories' => $categories,
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
        $session = Session::getSessionInstance();


        if(!empty($_POST)){
            $result = $this->CategoryEquipment->update(
                'id', $id,
                [
                    'title' => $_POST['title'],
                    'color' => $_POST['color'],
                    'slug' => $_POST['slug'],
                    'icon' => $_POST['icon']
                ]);
            if($result){
                $session->setFlash('success', 'Les données ont bien été modifiées');
            }
        }

        $category = $this->CategoryEquipment->find('id', $id);

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Equipements', '/admin/equipments')
            ->addCrumb('Catégories', '/admin/equipments/categories')
            ->addCrumb($category->title, '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($category);
        $this->render('equipments/admin/categories/edit.twig', [
            'category' => $category,
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }


    /**
     * Permet de supprimer un statut
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function delete(){
        $session = Session::getSessionInstance();

        if(!empty($_POST)){
            $this->CategoryEquipment->delete('id', $_POST['id']);

            $session->setFlash('success', 'La catégorie a été supprimée de la base de données');
            return $this->redirect('admin/equipments/categories');
        }

    }
}