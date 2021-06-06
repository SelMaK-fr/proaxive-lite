<?php


namespace App\Controller\Dashboard;
use App;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Entity\Entity;
use src\Form\SpectreForm;
use src\MyClass\Session;

class AdminDepartmentController extends AppController
{
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
        $this->loadModel('Department');
        }
        
    /**
     * Permet de lister et d'ajouter un département
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home(){
        if(!empty($_POST)) {
            if(!empty($_POST['name']) && !empty($_POST['code']))
            {
                // On vérifie si le statut existe ou non
                $nameScan = $this->Department->scanName($_POST['name']);
                $slug = Entity::cleanText($_POST['name']);
                if($nameScan) {
                    $this->session->setFlash('danger', "Ce département existe déjà");
                } else {

                    $result = $this->Department->create([
                        'code' => $_POST['code'],
                        'name' => $_POST['name'],
                        'slug' => $slug,
                        'soundex' => $_POST['soundex']
                    ]);

                    if($result){
                        $this->session->setFlash('success', 'Le département a bien été ajouté !');
                    }
                }
            } else {
                $this->session->setFlash('danger', 'Tous les champs ne sont pas remplis');
            }
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Départements', '');
        $this->breadcrumbs->render();

        $departments = $this->Department->all();
        $form = new SpectreForm($_POST);
        $this->render('dashboard/department/home.twig', [
            'form' => $form,
            'departments' => $departments,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);


    }

/**
 * Permet d'éditer un département
 *
 * @render
 * @param int $id
 * @return void
 * @throws \Twig\Error\LoaderError
 * @throws \Twig\Error\RuntimeError
 * @throws \Twig\Error\SyntaxError
 */
    
    public function edit(int $id){
        
        if(!empty($_POST)){
            $slug = Entity::cleanText($_POST['name']);
                $result = $this->Department->update(
                    'id', $id,
                    [
                        'code' => $_POST['code'],
                        'name' => $_POST['name'],
                        'slug' => $slug,
                        'soundex' => $_POST['soundex']
                ]);
                if($result){
                    $this->session->setFlash('success', 'Les données ont bien été modifiées');
                }
            }

        $department = $this->Department->find('id', $id);

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Départements', '/admin/departments')
            ->addCrumb($department->name, '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($department);
        $this->render('dashboard/department/edit.twig', [
            'department' => $department,
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
    if(!empty($_POST)){
        $this->Department->delete('id', $_POST['id']);
        $this->session->setFlash('success', 'Le département a été supprimé de la base de données');
        return $this->home();
    }

    }
}