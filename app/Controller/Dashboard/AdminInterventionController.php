<?php

namespace App\Controller\Dashboard;

use \App;
use Creitive\Breadcrumbs\Breadcrumbs;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use src\Entity\Entity;
use src\MyClass\Paginator;
use src\MyClass\Str;
use src\Auth\Auth;
use src\Form\SpectreForm;
use src\MyClass\SendMail;
use src\MyClass\Session;
use Verot\Upload\Upload;

/**
 * Description of WorkshopController
 *
 * @author SelMaK
 */
class AdminInterventionController extends AppController{


    private $current_menu;

    /**
     * @var Session
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
        $this->current_menu = 'interventions';
        $this->session = Session::getSessionInstance();
        $this->newDate = date('Y-m-d H:i:s');
        $this->breadcrumbs = new Breadcrumbs();
        // Charge les différentes tables de la base de données
        $this->loadModel('User');
        $this->loadModel('Client');
        $this->loadModel('Status');
        $this->loadModel('Brand');
        $this->loadModel('OperatingSystem');
        $this->loadModel('Equipment');
        $this->loadModel('CategoryEquipment');
        $this->loadModel('Company');
        $this->loadModel('Intervention');

    }

    /**
     * Permet d'afficher la liste des interventions
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home(){

        $paginator = new Paginator('15', 'p');
        $paginator->set_total($this->Intervention->countIntervention());
        $interventions = $this->Intervention->allWithPaginator($paginator->get_limit());
        $dataPaginator = $paginator->page_links();

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Interventions', '');
        $this->breadcrumbs->render();

        $this->render('intervention/admin/home.twig', [
            'interventions' => $interventions,
            'dataPaginator' => $dataPaginator,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * Permet d'afficher le rapport BAO + Client
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function bao(int $id){
        $intervention = $this->Intervention->find('id', $id);
        $client = $this->Client->find('id', $intervention->client_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $clientFullName = Entity::cleanText($client->fullname);
        if(!$intervention->rapport_bao){
            $this->session->setFlash('danger', "Il n'y a aucun rapport BAO pour cette intervention !");
            return $this->home();
        }
        $file = ROOT . "documents/clients/$clientFullName/bao/" .$intervention->rapport_bao;
        $rapport = $this->openFile($file, 'r');
        if(!empty($_POST)){
            if(isset($_POST['rapport'])){
                $rapportBao = $_POST['rapport_bao'];
                // Vérifie si le fichier peut être écrit.
                if (is_writable($file)) {
                    if (!$handle = fopen($file, 'w+')) {
                        $this->session->setFlash('danger', "Impossible d'ouvrir le fichier ($file)");
                        exit;
                    }

                    if (fwrite($handle, $rapportBao) === FALSE) {
                        echo "Impossible d'écrire dans le fichier ($file)";
                        exit;
                    }

                    $this->session->setFlash('success', "<strong>[Rafraîchissement dans 3s]</strong> L'écriture du rapport <strong>$intervention->rapport_bao</strong> dans le fichier ($file) a réussi");
                    fclose($handle);
                    header("Refresh: 3;url=/admin/intervention/$intervention->id/rapport/bao");


                } else {
                    $this->session->setFlash('danger', "Le fichier $file n'est pas accessible en écriture.");

                }
            }

            if(isset($_POST['delete_file'])){
                $this->deleteFile($file);
                $this->Intervention->update(
                    'id', (int) $id,
                    [
                        'rapport_bao' => '',
                    ]
                );
                $this->session->setFlash('success', "Le fichier <strong>$intervention->rapport_bao</strong> a été supprimé.");
                return $this->home();
            }

        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Interventions', '/admin/interventions')
            ->addCrumb($client->fullname, '/admin/client/'.$client->id)
            ->addCrumb($equipment->name,'/admin/edit-equipment/'.$equipment->id)
            ->addCrumb($intervention->title, '/admin/intervention/'.$intervention->id)
            ->addCrumb('Rapport BAO', '');
        $this->breadcrumbs->render();

        $this->render('intervention/admin/bao.twig', [
            'intervention' => $intervention,
            'rapport' => $rapport,
            'client' => $client,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * Permet d'ajouter une intervention
     * @return type
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function add(){

        $auth = new Auth(app::getInstance()->getDB());
        $generate = new Str();
        if(!empty($_POST)){
            $client = $this->Client->find('id', $_POST['client_id']);
            if($client->sleeping == 1){
                $this->session->setFlash('danger', "Le client est en sommeil, veuillez le réveiller avant d'effectuer cette action.");
                return $this->redirect('/admin/edit-client/' .$client->id);
            }
            if(!empty($_POST['equipment_id'])){
                $number = $_POST['number'];
                $received = $_POST['received'];
                $scanNumber = $this->Intervention->scanNumber($number);
                // Vérifie si le numéro de l'intervention existe ou non
                if ($scanNumber) {
                    $this->session->setFlash('danger', 'Ce numéro existe déjà !');

                } else {
                    // Si un numéro n'est pas rentré, on en génère un
                    if(empty($number)){
                        $number = rand(8, 9999999);
                    }
                    // Vérifie si le champ "received est renseigné
                    if(empty($received)){
                        $received = NULL;
                    }
                    // Si tout est OK, on envoi la requete
                    $result = $this->Intervention->create([
                        'status_id' => $_POST['status_id'],
                        'received' => $received,
                        'details' => $_POST['details'],
                        'description' => $_POST['description'],
                        'report' => null,
                        'observation' => $_POST['observation'],
                        'note_tech' => $_POST['note_tech'],
                        'title' => $_POST['title'],
                        'steps' => $_POST['steps'],
                        'number' => $number,
                        'price' => 0,
                        'number_link' => $generate->random(10),
                        'client_id' => $_POST['client_id'],
                        'closed' => null,
                        'pmad' => $_POST['pmad'],
                        'equipment_id' => $_POST['equipment_id'],
                        'auser_id' => $auth->getUserId(),
                        'created_at' => $this->newDate,
                        'updated_at' => $this->newDate
                    ]);
                    $lastInserId = $this->Intervention->lastInsertId();
                    $intervention = $this->Intervention->find('id', $lastInserId);
                    if($_POST['steps'] == 2){
                        $this->Equipment->update(
                            'id', (int) $intervention->equipment_id,
                            [
                                'inworkshop' => 1
                            ]);
                    }
                    if($result){
                        $this->session->setFlash('success', 'La nouvelle intervention a bien été créée !');
                        return $this->home();
                    }
                }
            } else {
                $this->session->setFlash('danger', 'Vous devez choisir un équipement et/ou renseigner une date de dépôt !');
            }
        } // Fin du IF $_POST

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Interventions', '/admin/interventions')
            ->addCrumb('Création', false);
        $this->breadcrumbs->render();

        $client = $this->Client->extractByAlpha('id', 'fullname');
        $computer = $this->Equipment->extract('id', 'name');
        $status = $this->Status->extract('id', 'title');
        $countEquipment = $this->Equipment->countRow();
        $form = new SpectreForm($_POST);
        $this->render('intervention/admin/add.twig', [
            'client' => $client,
            'computer' => $computer,
            'status' => $status,
            'countEquipment' => $countEquipment,
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);


    }

    /**
     * Permet d'ajouter une intervention avec client selectionné
     * @return type
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function addWithClient(int $id){
        $auth = new Auth(app::getInstance()->getDB());
        $generate = new Str();
        $client = $this->Client->find('id', (int) $id);
        $computer = $this->Equipment->extractById('client_id', 'name', (int) $id);

        if(empty($computer)){
            $this->session->setFlash('danger', 'Ce client n\'a aucun équipement !');
            return $this->home();
        }

        if(!empty($_POST)){
            if(!empty($_POST['title'])){
                $number = $_POST['number'];
                $received = $_POST['received'];
                $scanNumber = $this->Intervention->scanNumber($number);
                // Vérifie si le numéro de l'intervention existe ou non
                if ($scanNumber) {
                    $this->session->setFlash('danger', 'Ce numéro existe déjà !');

                } else {
                    // Si un numéro n'est pas rentré, on en génère un
                    if(empty($number)){
                        $number = rand(8, 9999999);
                    }
                    // Vérifie si le champ "received est renseigné
                    if(empty($received)){
                        $received = NULL;
                    }
                    // Si tout est OK, on envoi la requete
                    $result = $this->Intervention->create([
                        'status_id' => $_POST['status_id'],
                        'received' => $_POST['received'],
                        'details' => $_POST['details'],
                        'description' => $_POST['description'],
                        'report' => null,
                        'observation' => $_POST['observation'],
                        'note_tech' => $_POST['note_tech'],
                        'title' => $_POST['title'],
                        'steps' => $_POST['steps'],
                        'number' => $number,
                        'price' => 0,
                        'number_link' => $generate->random(10),
                        'client_id' => (int) $id,
                        'closed' => null,
                        'pmad' => $_POST['pmad'],
                        'equipment_id' => $_POST['equipment_id'],
                        'auser_id' => $auth->getUserId(),
                        'created_at' => $this->newDate,
                        'updated_at' => $this->newDate
                    ]);
                    if($result){
                        $this->session->setFlash('success', 'La nouvelle intervention pour <strong>' . $client->fullname . '</strong> a bien été créée !');
                        return $this->home();
                    }
                }
            } else {
                $this->session->setFlash('danger', 'Vous devez entrer un titre pour votre intervention et renseigner une date de dépôt !');
            }
        } // Fin du IF $_POST

        if($client->sleeping == 1){
            $this->session->setFlash('danger', "Le client est en sommeil, veuillez le réveiller avant d'effectuer cette action.");
            return $this->redirect('/admin/edit-client/' .$client->id);
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Interventions', '/admin/interventions')
            ->addCrumb($client->fullname, '/admin/client/'.$client->id)
            ->addCrumb('Création', '');
        $this->breadcrumbs->render();

        $computer = $this->Equipment->extractById('client_id', 'name', (int) $id);
        $status = $this->Status->extract('id', 'title');
        $countEquipment = $this->Equipment->countRow();
        $form = new SpectreForm($_POST);
        $this->render('intervention/admin/addWithClient.twig', [
            'client' => $client,
            'computer' => $computer,
            'status' => $status,
            'countEquipment' => $countEquipment,
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);


    }

    /**
     * Permet d'ajouter une intervention avec client selectionné
     * @param int $id
     * @param int $equipment_id
     * @return type
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function addWithClientAndEquipment(int $client_id, int $equipment_id){
        $auth = new Auth(app::getInstance()->getDB());
        $generate = new Str();
        $client = $this->Client->find('id', (int) $client_id);
        $equipment = $this->Equipment->find('id', (int) $equipment_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        if(!empty($_POST)){
            if(!empty($_POST['title'])){
                $number = $_POST['number'];
                $received = $_POST['received'];
                $scanNumber = $this->Intervention->scanNumber($number);
                // Vérifie si le numéro de l'intervention existe ou non
                if ($scanNumber) {
                    $this->session->setFlash('danger', 'Ce numéro existe déjà !');

                } else {
                    // Si un numéro n'est pas rentré, on en génère un
                    if(empty($number)){
                        $number = rand(8, 9999999);
                    }
                    // Vérifie si le champ "received est renseigné
                    if(empty($received)){
                        $received = NULL;
                    }
                    // Si tout est OK, on envoi la requete
                    $result = $this->Intervention->create([
                        'status_id' => $_POST['status_id'],
                        'received' => $_POST['received'],
                        'details' => $_POST['details'],
                        'description' => $_POST['description'],
                        'report' => null,
                        'observation' => $_POST['observation'],
                        'note_tech' => $_POST['note_tech'],
                        'title' => $_POST['title'],
                        'steps' => $_POST['steps'],
                        'number' => $number,
                        'price' => 0,
                        'number_link' => $generate->random(10),
                        'client_id' => (int) $client_id,
                        'closed' => null,
                        'pmad' => $_POST['pmad'],
                        'equipment_id' => (int) $equipment_id,
                        'auser_id' => $auth->getUserId(),
                        'created_at' => $this->newDate,
                        'updated_at' => $this->newDate
                    ]);
                    // Récupère le dernier ID de l'interventio ajoutée
                    $lastInserId = $this->Intervention->lastInsertId();
                    $intervention = $this->Intervention->find('id', $lastInserId);
                    // Si l'équipement est selectionné en "En atelier" on le met à jour.
                    if($_POST['steps'] == 2){
                        $this->Equipment->update(
                            'id', (int) $intervention->equipment_id,
                            [
                                'inworkshop' => 1
                            ]);
                    }
                    if($result){
                        $this->session->setFlash('success', 'La nouvelle intervention pour <strong>' . $client->fullname . '</strong> a bien été créée !');
                        return $this->home();
                    }
                }
            } else {
                $this->session->setFlash('danger', 'Vous devez entrer un titre pour votre intervention et renseigner une date de dépôt !');
            }
        } // Fin du IF $_POST

        if($client->sleeping == 1){
            $this->session->setFlash('danger', "Le client est en sommeil, veuillez le réveiller avant d'effectuer cette action.");
            return $this->redirect('/admin/edit-client/' .$client->id);
        }

        $status = $this->Status->extract('id', 'title');
        $countEquipment = $this->Equipment->countRow();

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Interventions', '/admin/interventions')
            ->addCrumb($client->fullname, '/admin/client/'.$client->id)
            ->addCrumb($equipment->name,'/admin/edit-equipment/'.$equipment->id)
            ->addCrumb('Création', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($_POST);
        $this->render('intervention/admin/addWithClientAndEquipement.twig', [
            'client' => $client,
            'equipment' => $equipment,
            'categoryEquipment' => $categoryEquipment,
            'brand' => $brand,
            'status' => $status,
            'form' => $form,
            'countEquipment' => $countEquipment,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);


    }

    /**
     * Permet d'éditer et de fermer une intervention
     * @param int $id
     * @return type
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function edit(int $id){
        $intervention = $this->Intervention->find('id', (int) $id);
        $client = $this->Client->find('id', $intervention->client_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        $clientFullName = Entity::cleanText($client->fullname);
        if (!empty($_POST)) {
            // Met à jours les informations principales
            if(isset($_POST['update'])){
                $result = $this->Intervention->update(
                    'id', (int) $id,
                    [
                        'title' => $_POST['title'],
                        'status_id' => $_POST['status_id'],
                        'details' => $_POST['details'],
                        'steps' => $_POST['steps'],
                        'description' => $_POST['description'],
                        'note_tech' => $_POST['note_tech'],
                        'observation' => $_POST['observation']
                    ]);
                if($_POST['steps'] == 2){
                    $this->Equipment->update(
                        'id', (int) $intervention->equipment_id,
                        [
                           'inworkshop' => 1
                        ]);
                }
                if($result){
                    $this->session->setFlash('success', "Les données ont bien été modifiées !");
                    return $this->home();
                }
            }

            // Ferme l'intervention + ajoute la date de cloture
            if (isset($_POST['cloture'])) {
                $result = $this->Intervention->update(
                    'id', (int) $id,
                    [
                        'report' => $_POST['report'],
                        'closed' => 1,
                        'status_id' => 8,
                        'steps' => 4,
                        'close_date' => $this->newDate
                    ]);
                if($result){
                    $this->session->setFlash('success', "L'intervention a bien été cloturée !");
                    return $this->home();
                }
            }

            if (isset($_POST['send_file'])) {
                $baoFiles = str_replace(' ', '-', $_FILES['baofiles']);
                $handle = new Upload($baoFiles, 'fr_FR');

                if($handle->uploaded){
                    $handle->mime_check = true;
                    $handle->allowed = array('text/*');
                    $handle->file_max_size = '60024';
                    $handle->process(ROOT . 'documents/clients/'.$clientFullName.'/bao');
                    if($handle->processed){
                        $updateRapport = $this->Intervention->update(
                            'id', (int) $id,
                            [
                                'rapport_bao' => $handle->file_dst_name
                            ]
                        );
                        if($updateRapport){
                            $this->session->setFlash('success', 'Le rapport BAO a bien été chargé');
                            return $this->home();
                        }
                    } else {
                        $this->session->setFlash('danger', 'Un problème est survenu -> ' . $handle->error);
                    }
                } else {
                    $this->session->setFlash('danger', 'Un problème est survenu -> ' . $handle->error);
                }
            }

            // permet d'envoyer un mail au destinataire
            // Ne pas utiliser pour le moment
            if (isset($_POST['sendmail'])) {
                $this->sendMailUpdate($intervention->id);
                $this->session->setFlash('success', "Le courriel a été envoyé à " . $client->mail);
                return $this->home();
            }

            // Permet d'ajouter la date de dépôt (remise du matériel au client)
            if (isset($_POST['backhome'])) {
                $result = $this->Intervention->update(
                    'id', (int) $id,
                    [
                        'back_home' => $this->newDate
                    ]);
                // Met à jour le champs "inworkshop" de l'équipement
                $updateEquipment = $this->Equipment->update(
                    'id', (int) $intervention->equipment_id,
                    [
                        'inworkshop' => 0
                    ]);
                if($result AND $updateEquipment){
                    $this->session->setFlash('success', "Confirmation que l'équipement a été remis au client !");
                    return $this->home();
                }
            }

            // Inscrit la date de début d'intervention
            if (isset($_POST['start_inter'])) {
                $result = $this->Intervention->update(
                    'id', (int) $id,
                    [
                        'start' => $this->newDate
                    ]);
                if($result){
                    $this->session->setFlash('success', "Confirmation que l'intervention vient de débuter !");
                    return $this->home();
                }
            }

            // Met à jour la date de l'intervention
            if (isset($_POST['update_inter'])) {
                $result = $this->Intervention->update(
                    'id', (int) $id,
                    [
                        'updated_at' => $this->newDate
                    ]);
                if($result){
                    $this->session->setFlash('success', "La date a correctement été mise à jour !");
                    return $this->home();
                }
            }
        }

        $file = ROOT . "documents/clients/$clientFullName/bao/" .$intervention->rapport_bao;
        // Vérifie sur le fichier existe bien
        if(is_file($file)){
            $rapport = $this->openFile($file, 'r');
        } else {
            $rapport = false;
        }
        $status = $this->Status->extract('id', 'title');

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Interventions', '/admin/interventions')
            ->addCrumb($client->fullname, '/admin/client/'.$client->id)
            ->addCrumb($equipment->name,'/admin/edit-equipment/'.$equipment->id)
            ->addCrumb($intervention->title, '/admin/intervention/'.$intervention->id);
        $this->breadcrumbs->render();

        $form = new SpectreForm($intervention);

        $this->render('intervention/admin/edit.twig', [
            'current_menu' => $this->current_menu,
            'intervention' => $intervention,
            'client' => $client,
            'equipment' => $equipment,
            'brand' => $brand,
            'operatingSystem' => $operatingSystem,
            'categoryEquipment' => $categoryEquipment,
            'status' => $status,
            'form' => $form,
            'rapport' => $rapport,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * Permet d'afficher la vue HTML d'une intervention
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function showHtml(int $id)
    {
        $intervention = $this->Intervention->findByKeyAndValue('id', (int) $id);
        $client = $this->Client->find('id', $intervention->client_id);
        $user = $this->User->find('id', $intervention->auser_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        $company = $this->Company->isDefault();

        $this->render('intervention/admin/html.twig', [
            'current_menu' => $this->current_menu,
            'intervention' => $intervention,
            'client' => $client,
            'user' => $user,
            'company' => $company,
            'equipment' => $equipment,
            'brand' => $brand,
            'operatingSystem' => $operatingSystem,
            'categoryEquipment' => $categoryEquipment

        ]);
    }


    /**
     * Permet d'alerter le client par mail, d'une nouvelle mise à jour de l'intervention
     * Utilise l'API de Mailjet (compte Mailjet obligatoire)
     * Ou utilise SwiftMailer (configuration manuelle)
     * A configurer via le fichier de configuration .env (Proaxive Net Install)
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function sendMailUpdate(int $id)
    {
        // Récupère les données de l'intervention
        $intervention = $this->Intervention->findByKeyAndValue('id', (int) $id);
        $client = $this->Client->find('id', $intervention->client_id);
        $user = $this->User->find('id', $intervention->auser_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        $status = $this->Status->find('id', $intervention->status_id);
        $company = $this->Company->isDefault();
        // Lecture du fichier de configuration json (Mail)
        $viewJsonFile = file_get_contents(ROOT. '/config/mail.json');
        $viewJson = json_decode($viewJsonFile, false);
        // Lecture du fichier de configuration json (Setting)
        $viewJsonFile = file_get_contents(ROOT. '/config/setting.json');
        $viewJsonSetting = json_decode($viewJsonFile, false);
        // Charge la class SendMail
        $sendMail = new SendMail();
        // Vérifie le choix d'envoi de mail (fichier .env)
        if ($viewJson->mail_service == 'mailjet'){
            // Envoi le mail avec le service externe Mailjet
            $sendMail->sendDataMailJet('Votre suivi intervention', $client->mail, $client->fullname, [
                'intervention' => $intervention,
                'client' => $client,
                'user' => $user,
                'company' => $company,
                'equipment' => $equipment,
                'brand' => $brand,
                'status' => $status,
                'operatingSystem' => $operatingSystem,
                'categoryEquipment' => $categoryEquipment,
                'viewJsonSetting' => $viewJsonSetting
            ], 'templates/mail_updateintervention.twig');
        } elseif ($viewJson->mail_service == 'swiftmailer'){
            // Envoi le mail avec Swiftmailer
            $sendMail->sendDataSwiftMailer('Votre suivi intervention', $client->mail, $company->mail, $company->cname, [
                'intervention' => $intervention,
                'client' => $client,
                'user' => $user,
                'company' => $company,
                'equipment' => $equipment,
                'brand' => $brand,
                'status' => $status,
                'operatingSystem' => $operatingSystem,
                'categoryEquipment' => $categoryEquipment,
                'viewJsonSetting' => $viewJsonSetting
            ], 'templates/mail_updateintervention.twig');
        }
    }


    /**
     * Permet de générer le PDF d'une intervention
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function snappyPDF(int $id){
        // Récupère les données de l'intervention
        $company = $this->Company->isDefault();
        $intervention = $this->Intervention->find('id', (int) $id);
        $client = $this->Client->find('id', $intervention->client_id);
        $user = $this->User->find('id', $intervention->auser_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        // Génère la vue HTML pour le format PDF
        $html = $this->twig->render('intervention/admin/pdf.twig', [
            'intervention' => $intervention,
            'company' => $company,
            'client' => $client,
            'user' => $user,
            'equipment' => $equipment,
            'brand' => $brand,
            'operatingSystem' => $operatingSystem,
            'categoryEquipment' => $categoryEquipment
        ]);
        // Charge la class PDF
        $snappy = new Pdf();
        // Charge l'extension WKHTMLTOPDF
        if(getenv('PDF_WKHTMLTOPDF_WIN') == true){
            $snappy->setBinary(getenv('PDF_WKHTMLTOPDF_PATH'));
        } elseif (getenv('PDF_WKHTMLTOPDF_WIN') == false){
            $snappy->setBinary(ROOT . getenv('PDF_WKHTMLTOPDF_PATH'));
        }
        // Force le header (PDF)
        header('Content-Type: application/pdf');
        // Affiche le PDF via la method getOutputFromHtml de Snappy
        echo $snappy->getOutputFromHtml($html);
    }

    /**
     * Permet de supprimer une intervention
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function delete(){
        if(!empty($_POST)){
            if (isset($_POST)) {
                $this->Intervention->delete('id', (int) $_POST['id']);
                $this->session->setFlash('success', "L'intervention a été supprimée.");
                return $this->home();
            } else {
                $this->session->setFlash('danger', "L'intervention'n'a pas pu être supprimée.");
                return $this->home();
            }
        }
    }

}
