<?php


namespace App\Controller\Dashboard;

use App;
use Creitive\Breadcrumbs\Breadcrumbs;
use src\Form\SpectreForm;
use src\MyClass\CSV;
use src\MyClass\Session;


class AdminEquipmentController extends AppController
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
     * @var false|string
     */
    private $newDate;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;


    public function __construct(){

        parent::__construct();
        $this->current_menu = 'equipments';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = new Breadcrumbs();
        $this->newDate = date('Y-m-d H:i:s');
        // Charge les tables de la base de données
        $this->loadModel('Equipment');
        $this->loadModel('CategoryEquipment');
        $this->loadModel('Brand');
        $this->loadModel('Client');
        $this->loadModel('Intervention');
        $this->loadModel('OperatingSystem');
    }

    /**
     * Permet de lister les équipements
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home()
    {
        $equipments = $this->Equipment->allWithClientCategoryBrandsOS();

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('équipements', '');
        $this->breadcrumbs->render();

        $this->render('equipments/admin/home.twig', [
            'equipments' => $equipments,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'ajouter un équipement
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if(!empty($_POST)){
            $client = $this->Client->find('id', $_POST['client_id']);
            if($client->sleeping == 1){
                $this->session->setFlash('danger', "Le client est en sommeil, veuillez le réveiller avant d'effectuer cette action.");
                return $this->redirect('/admin/edit-client/' .$client->id);
            }
            if(!empty($_POST['name']) && !empty($_POST['content'])){
                $result = $this->Equipment->create([
                    'name' => $_POST['name'],
                    'content' => $_POST['content'],
                    'inworkshop' => $_POST['inworkshop'],
                    'serialnumber' => $_POST['serialnumber'],
                    'numberproduct' => $_POST['numberproduct'],
                    'licence_os' => $_POST['licence_os'],
                    'status' => $_POST['status'],
                    'year' => $_POST['year'],
                    'client_id' => $_POST['client_id'],
                    'brand_id' => $_POST['brand_id'],
                    'category_equipment_id' => $_POST['category_equipment_id'],
                    'operating_systems_id' => $_POST['operating_systems_id'],
                    'created_at' => $this->newDate,
                    'updated_at' => $this->newDate,
                ]);
                if($result){
                    $this->session->setFlash('success', "L'équipement a bien été ajouté");
                    return $this->home();
                }
                else {
                    $this->session->setFlash('danger', "Il y a eu un problème avec la base de données");
                }
            } else {
                $this->session->setFlash('danger', "Les champs <strong>Nom de l'équipement</strong> et <strong>Détails de l'équipement</strong> sont obligatoires");
            }
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('équipements', '/admin/equipments')
            ->addCrumb('création', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($_POST);
        $categories = $this->CategoryEquipment->extract('id', 'title');
        $brands = $this->Brand->extractByAlpha('id', 'b_title');
        $client = $this->Client->extractByAlpha('id', 'fullname');
        $operating = $this->OperatingSystem->extract('id', 'os_full');
        $this->render('equipments/admin/add.twig', [
            'form' => $form,
            'categories' => $categories,
            'brands' => $brands,
            'client' => $client,
            'operating' => $operating,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'ajouter un équipement
     *
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addWithClient(int $id)
    {
        $client = $this->Client->find('id', (int) $id);

        if(!empty($_POST)){
            if(!empty($_POST) && !empty($_POST['name']) && !empty($_POST['content'])){
                $result = $this->Equipment->create([
                    'name' => $_POST['name'],
                    'content' => $_POST['content'],
                    'inworkshop' => $_POST['inworkshop'],
                    'serialnumber' => $_POST['serialnumber'],
                    'numberproduct' => $_POST['numberproduct'],
                    'licence_os' => $_POST['licence_os'],
                    'status' => $_POST['status'],
                    'year' => $_POST['year'],
                    'client_id' => $client->id,
                    'brand_id' => $_POST['brand_id'],
                    'category_equipment_id' => $_POST['category_equipment_id'],
                    'operating_systems_id' => $_POST['operating_systems_id'],
                    'created_at' => $this->newDate,
                    'updated_at' => $this->newDate,
                ]);
                if($result){
                    $this->session->setFlash('success', "L'équipement pour <strong>$client->fullname</strong> a bien été ajouté");
                    return $this->home();
                }
                else {
                    $this->session->setFlash('danger', "Il y a eu un problème avec la base de données");
                }
            } else {
                $this->session->setFlash('danger', "Les champs <strong>Nom de l'équipement</strong> et <strong>Détails de l'équipement</strong> sont obligatoires");
            }
        }

        if($client->sleeping == 1){
            $this->session->setFlash('danger', "Le client est en sommeil, veuillez le réveiller avant d'effectuer cette action.");
            return $this->redirect('/admin/edit-client/' .$client->id);
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('équipements', '/admin/equipments')
            ->addCrumb($client->fullname, '/admin/client/'.$client->id)
            ->addCrumb('création', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($_POST);
        $categories = $this->CategoryEquipment->extract('id', 'title');
        $brands = $this->Brand->extractByAlpha('id', 'b_title');
        $operating = $this->OperatingSystem->extract('id', 'os_full');
        $this->render('equipments/admin/addwithclient.twig', [
            'form' => $form,
            'categories' => $categories,
            'brands' => $brands,
            'client' => $client,
            'operating' => $operating,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'éditer un ordinateur client
     *
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id){
        if(!empty($_POST)){
            $result = $this->Equipment->update(
                'id', (int) $id,
                [
                    'name' => $_POST['name'],
                    'content' => $_POST['content'],
                    'inworkshop' => $_POST['inworkshop'],
                    'serialnumber' => $_POST['serialnumber'],
                    'numberproduct' => $_POST['numberproduct'],
                    'licence_os' => $_POST['licence_os'],
                    'status' => $_POST['status'],
                    'year' => $_POST['year'],
                    'client_id' => $_POST['client_id'],
                    'brand_id' => $_POST['brand_id'],
                    'category_equipment_id' => $_POST['category_equipment_id'],
                    'operating_systems_id' => $_POST['operating_systems_id'],
                    'updated_at' => $this->newDate
                ]);
            if($result){
                $this->session->setFlash('success', 'Les données ont bien été modifiées');
                return $this->home();
            }
        }

        $equipment = $this->Equipment->find('id', (int) $id);
        $searchClient = $this->Client->find('id', $equipment->client_id);

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('équipements', '/admin/equipments')
            ->addCrumb($searchClient->fullname, '/admin/client/'.$searchClient->id)
            ->addCrumb($equipment->name, '');
        $this->breadcrumbs->render();

        $categories = $this->CategoryEquipment->extract('id', 'title');
        $operating = $this->OperatingSystem->extract('id', 'os_full');
        $brands = $this->Brand->extract('id', 'b_title');
        $client = $this->Client->extract('id', 'fullname');
        $client_id = $searchClient->id;
        $interventions = $this->Intervention->allById('equipment_id', (int) $id);
        $form = new SpectreForm($equipment);
        $this->render('equipments/admin/edit.twig', [
            'equipment' => $equipment,
            'categories' => $categories,
            'brands' => $brands,
            'client' => $client,
            'operating' => $operating,
            'form' => $form,
            'interventions' => $interventions,
            'client_id' => $client_id,
            'searchClient' => $searchClient,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * Permet de d'afficher les équipements d'un client
     * SELECT FORM
     * @param int $id
     */
    public function byclient(int $id)
    {
        $equipments = $this->Equipment->byclient($id);
        header('Content-Type: application/json');
        echo json_encode(array_map(function ($equipment){
            return [
                'label' => $equipment->name . ' - ' . $equipment->title,
                'value' => $equipment->eid
            ];
        }, $equipments));
    }

    /**
     * Permet d'exporter les données au format CSV
     */
    public function exportEquipment(){
        $equipments = $this->Equipment->exportWithClientCategoryBrandsOS();
        if(!empty($_POST)){
            $exportData = new CSV();
            $exportData->export_thead($equipments, 'Export-Equipments');
        }
    }

    /**
     * Permet de supprimer un équipement
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function delete(){
        if(!empty($_POST)){
            if (isset($_POST)) {
                $equipment = $this->Equipment->delete('id', (int) $_POST['id']);
                $this->session->setFlash('success', "L'équipement a été supprimé.");
                return $this->home();
            } else {
                $this->session->setFlash('danger', "L'équipement'n'a pas pu être supprimé.");

            }
        }
    }
}