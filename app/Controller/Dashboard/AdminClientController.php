<?php

namespace App\Controller\Dashboard;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Auth\Auth;
use src\Form\SpectreForm;
use src\MyClass\CSV;
use src\MyClass\Session;
use \App; // Permet de récupérer l'instance de la base de données (App::getInstance()

class AdminClientController extends AppController{


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
        $this->current_menu = 'clients';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = $breadcrumbs = new Breadcrumbs();
        // Charge les tables de la base de données
		$this->loadModel('Client');
        $this->loadModel('Equipment');
        $this->loadModel('Intervention');
        $this->loadModel('Company');
        $this->loadModel('Department');
	}

    /**
     * Permet de lister les utilisateurs/clients
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
	public function home(){
		$clients = $this->Client->allWithDepartments();

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Admin', '/admin')
            ->addCrumb('Client', "clients");
        $this->breadcrumbs->render();

		$form = new SpectreForm($_POST);
		$this->render('clients/admin/home.twig', [
		    'clients' => $clients,
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbs,
            'current_menu' => $this->current_menu
        ]);

	}

    /**
     * Permet d'afficher un utilisateur
     *
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
	public function view(int $id)
    {
        $client = $this->Client->find('id', $id);

        // Vérifie si l'utilisateur/client existe dans la base de données
        if(empty($client)){
            $this->session->setFlash('danger', "Le client n'existe pas.");
            return $this->home();
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Admin', '/admin')
            ->addCrumb('Clients', '/admin/clients')
            ->addCrumb($client->fullname, "");
        $this->breadcrumbs->render();

        $equipments = $this->Equipment->byclient($id);
        $interventions = $this->Intervention->byclient($id);
        $company = $this->Company->find(1, 'id');
        $form = new SpectreForm($_POST);
        // Twig
        $this->render('clients/admin/show.twig', [
           'client' => $client,
           'equipments' => $equipments,
           'interventions' => $interventions,
           'current_menu' => $this->current_menu,
            'form' => $form,
            'company' => $company,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'ajouter un utilisateur/client
     * @return type
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

	public function add(){
		$date = date('Y-m-d H:i:s');
		if(!empty($_POST)){
		    if(!empty($_POST['lastname'])){
                $fullname = $_POST['lastname'] .' '. $_POST['firstname'];
                $scanFullName = $this->Client->scanField('fullname', $fullname);
                if($scanFullName){
                    $this->session->setFlash('danger', "Ce client existe déjà");
                } else {
                    $result = $this->Client->create([
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'mail' => $_POST['mail'],
                        'phone' => $_POST['phone'],
                        'mobile' => $_POST['mobile'],
                        'adress' => $_POST['adress'],
                        'zipcode' => $_POST['zipcode'],
                        'validated' => 1,
                        'activated' => 1,
                        'sleeping' => $_POST['sleeping'],
                        'city' => $_POST['city'],
                        'department_id' => $_POST['department_id'],
                        'fullname' => $fullname,
                        'created_at' => $date,
                        'updated_at' => $date
                    ]);
                    $lastinsertid = $this->Client->lastInsertId();
                    if($result){
                        return $this->view($lastinsertid);
                    }
                    else {
                        $this->session->setFlash('danger', "<strong>Aie ! il y a un souci</strong> Error data");
                    }
                }
            } else {
                $this->session->setFlash('danger', "Veuillez remplir au moins le champ <strong>Nom</strong>");
            }
			}

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Admin', '/admin')
            ->addCrumb('Clients', '/admin/clients')
            ->addCrumb('Nouveau', "");
        $this->breadcrumbs->render();

		$company = $this->Company->isDefault();
        $departments = $this->Department->extract('id', 'name');
		$form = new SpectreForm($_POST);
		$this->render('clients/admin/add.twig', [
            'departments' => $departments,
            'form' => $form,
            'company' => $company,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
	}


    /**
     * Permet d'éditer un utilisateur
     *
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
	public function edit(int $id){

	if(!empty($_POST)){
        $fullname = $_POST['lastname'] .' '. $_POST['firstname'];
        $date = date('Y-m-d H:i:s');
        $result = $this->Client->update(
            'id', (int) $id,
            [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'mail' => $_POST['mail'],
                'phone' => $_POST['phone'],
                'mobile' => $_POST['mobile'],
                'adress' => $_POST['adress'],
                'zipcode' => $_POST['zipcode'],
                'city' => $_POST['city'],
                'sleeping' => $_POST['sleeping'],
                'department_id' => $_POST['department_id'],
                'fullname' => $fullname,
                'updated_at' => $date
        ]);
        if($result){
        $this->session->setFlash('success', "La modification du client a été appliquée.");
            return $this->home();
        }
	}

	$client = $this->Client->find('id', (int) $id);

	// Vérifie si l'utilisateur/client existe dans la base de données
    if(empty($client)){
    $this->session->setFlash('danger', "Le client n'existe pas.");
    return $this->home();
	}

    //Breadcrumb
    $this->breadcrumbs->addCrumb('Admin', '/admin')
        ->addCrumb('Clients', '/admin/clients')
        ->addCrumb($client->fullname, "/admin/client/".$client->id)
        ->addCrumb('Modification', '');
    $this->breadcrumbs->render();

    $departments = $this->Department->extract('id', 'name');
	$form = new SpectreForm($client);
	$this->render('clients/admin/edit.twig', [
        'client' => $client,
        'departments' => $departments,
        'form' => $form,
        'current_menu' => $this->current_menu,
        'breadcrumbs' => $this->breadcrumbs
    ]);

	}

    /**
     * Permet d'exporter les données au format CSV
     */
    public function exportClient(){
        $clients = $this->Client->exportClients();
        if(!empty($_POST)){
            $exportData = new CSV();
            $exportData->export_thead($clients, 'Export-Clients');
        }
    }


    /**
     * Permet de supprimer un utilisateur
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
	public function delete(){
        if(!empty($_POST)){
        $this->Client->delete('id', $_POST['id']);
        $this->session->setFlash('success', "Toutes les données du client ont été supprimées.");
        return $this->home();
        }
	}

	}
