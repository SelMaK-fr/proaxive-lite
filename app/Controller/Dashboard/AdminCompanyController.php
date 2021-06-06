<?php

namespace App\Controller\Dashboard;


use App;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Form\SpectreForm;
use src\MyClass\Session;
use Verot\Upload\Upload;

class AdminCompanyController extends AppController
{

    /**
     * @var string
     */
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

        parent::__construct();
        $this->current_menu = 'home';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = new Breadcrumbs();
        // Charge les tables de la base de données
        $this->loadModel('Company');
        $this->loadModel('Department');
    }

    /**
     * Permet de lister les entreprises
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home()
    {
        $companies = $this->Company->all();

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Entreprises', '');
        $this->breadcrumbs->render();

        $this->render('company/admin/home.twig', [
            'companies' => $companies,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'ajouter une entreprise
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        $date = date('Y-m-d H:i:s');

        $companies = $this->Company->all();

        if(!empty($companies)){
            $this->session->setFlash('danger', "Cette version ne permet pas d'ajouter plusieurs entreprises");
            return $this->home();
        }

        if(!empty($_POST) && !empty($_POST['cname']) && !empty($_POST['type'])){

            $result = $this->Company->create([
                'cname' => $_POST['cname'],
                'about' => $_POST['about'],
                'type' => $_POST['type'],
                'adress' => $_POST['adress'],
                'country' => $_POST['country'],
                'city' => $_POST['city'],
                'zipcode' => $_POST['zipcode'],
                'facebook' => $_POST['facebook'],
                'twitter' => $_POST['twitter'],
                'instagram' => $_POST['instagram'],
                'linkedin' => $_POST['linkedin'],
                'phone' => $_POST['phone'],
                'mobile' => $_POST['mobile'],
                'phone_indicatif' => $_POST['phone_indicatif'],
                'department_id' => $_POST['department_id'],
                'fax' => $_POST['fax'],
                'director' => $_POST['director'],
                'website' => $_POST['website'],
                'mail' => $_POST['mail'],
                'siret' => $_POST['siret'],
                'rm' => $_POST['rm'],
                'aprm' => '0',
                'ape' => $_POST['ape'],
                'rcs' => $_POST['rcs'],
                'rc_pro' => $_POST['rc_pro'],
                'tva' => $_POST['tva'],
                'isdefault' => 1,
                'created_at' => $date,
                'updated_at' => $date
            ]);
            $lastinserid = $this->Company->lastInsertId();
            if($result){
                $this->importLogo($lastinserid);
                $this->session->setFlash('success', "La nouvelle entreprise a été ajoutée");
                return $this->home();
            }
            else {
                $this->session->setFlash('danger', "Il y a eu un problème avec la base de données");
            }
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Entreprises', '')
            ->addCrumb('Nouvelle entreprise', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($_POST);
        $departments = $this->Department->extract('id', 'name');
        $this->render('company/admin/add.twig', [
            'form' => $form,
            'departments' => $departments,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'éditer une entreprise
     *
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id){
        $date = date('Y-m-d H:i:s');
        $companies = $this->Company->all();
        if(empty($companies)){
            $this->session->setFlash('warning', "Votre entreprise n'existe pas. Veuillez la créer !");
            return $this->add();
        }
        if(!empty($_POST)) {

            if(isset($_POST['saveData'])){
                $result = $this->Company->update(
                    'id', (int) $id,
                    [
                        'cname' => $_POST['cname'],
                        'about' => $_POST['about'],
                        'type' => $_POST['type'],
                        'adress' => $_POST['adress'],
                        'country' => $_POST['country'],
                        'city' => $_POST['city'],
                        'zipcode' => $_POST['zipcode'],
                        'facebook' => $_POST['facebook'],
                        'twitter' => $_POST['twitter'],
                        'instagram' => $_POST['instagram'],
                        'linkedin' => $_POST['linkedin'],
                        'phone' => $_POST['phone'],
                        'mobile' => $_POST['mobile'],
                        'phone_indicatif' => $_POST['phone_indicatif'],
                        'department_id' => $_POST['department_id'],
                        'fax' => $_POST['fax'],
                        'director' => $_POST['director'],
                        'website' => $_POST['website'],
                        'mail' => $_POST['mail'],
                        'siret' => $_POST['siret'],
                        'ape' => $_POST['ape'],
                        'rm' => $_POST['rm'],
                        'aprm' => '0',
                        'rcs' => $_POST['rcs'],
                        'rc_pro' => $_POST['rc_pro'],
                        'tva' => $_POST['tva'],
                        'isdefault' => 1,
                        'updated_at' => $date
                    ]);
                if($result){
                    $this->session->setFlash('success', 'Les données ont bien été modifiées');
                    return $this->home();
                }
            }

            if (isset($_POST['saveLogo'])){
                $this->importLogo($id);
            }
        }

        $company = $this->Company->find((int) $id, 'id');

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Mon entreprise', '/admin')
            ->addCrumb($company->cname, '');
        $this->breadcrumbs->render();

        $departments = $this->Department->extract('id', 'name');
        $form = new SpectreForm($company);
        $this->render('company/admin/edit.twig', [
            'company' => $company,
            'departments' => $departments,
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    private function importLogo($id){
        $handle = new Upload($_FILES['logo'], 'fr_FR');
        if($handle->uploaded){
            $handle->allowed = array('image/*');
            $handle->process(ROOT . 'public/uploads/company/');
            if($handle->processed){
                $updateLogo = $this->Company->update(
                    'id', (int) $id,
                    [
                        'logo' => $handle->file_src_name
                    ]
                );
                if($updateLogo){
                    $this->session->setFlash('success', 'Le nouveau logo a bien été chargé');
                }
            } else {
                $this->session->setFlash('danger', 'Un problème est survenu -> ' . $handle->error);
            }
        } else {
            $this->session->setFlash('danger', 'Un problème est survenu -> ' . $handle->error);
        }
    }

}