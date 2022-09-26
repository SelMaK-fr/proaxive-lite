<?php

namespace App\Controller\Dashboard;

use Creitive\Breadcrumbs\Breadcrumbs;
use src\MyClass\Session;

class AdminHomeController extends AppController
{

    /**
     * @var string
     */
    private $current_menu;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;

    public function __construct()
    {
        parent::__construct();
        $this->current_menu = 'home';
        $this->breadcrumbs = new Breadcrumbs();
        // Load Model
        $this->loadModel('Client');
        $this->loadModel('Equipment');
        $this->loadModel('Intervention');
        $this->loadModel('Brand');
        $this->loadModel('Company');
        $this->loadModel('Status');
        $this->loadModel('User');
    }

    /**
     * Chargement de l'index
     */

    public function index(){

        $countEquipment = $this->Equipment->countRow();
        $interInProgress = $this->Intervention->selectWithClientInProgress(4);
        $interInClose = $this->Intervention->selectWithClientInClose(4);
        $countIntervention = $this->Intervention->countRow();
        $countClient = $this->Client->countRow();
        $clients = $this->Client->selectWithDepartmentsLimit(4);
        $countBrand = $this->Brand->countRow();
        $countCompany = $this->Company->CountRow();
        $countStatus = $this->Status->CountRow();
        $equipmentInWork = $this->Equipment->selectWithCategoryInWork(4);
        $phpversion = phpversion();
        $version = str_replace('.', '', $this->app_version()->number);
        $lastversion = $this->app_lastversion();
        $lastversionNum = str_replace('.', '', $lastversion->num);
        $auser = $this->User->find('id', 1);

        $this->breadcrumbs->addCrumb('Panel Proaxive', '/admin')
            ->addCrumb('Accueil', '');
        $this->breadcrumbs->render();

        $folderInstall = ROOT . '/install';
        $checkFolderInstall = file_exists($folderInstall);

        $this->render('dashboard/home/home.twig', [
            'countEquipment' => $countEquipment,
            'countIntervention' => $countIntervention,
            'countClient' => $countClient,
            'clients' => $clients,
            'interInProgress' => $interInProgress,
            'interInClose' => $interInClose,
            'equipmentInWork' => $equipmentInWork,
            'countBrand' => $countBrand,
            'countCompany' => $countCompany,
            'countStatus' => $countStatus,
            'phpversion' => $phpversion,
            'version' => $version,
            'lastversion' => $lastversion,
            'lastversionNum' => $lastversionNum,
            'checkFolderInstall' => $checkFolderInstall,
            'auser' => $auser,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * API Last version
     */
    private function app_lastversion(){
        $viewJsonFile = file_get_contents('https://proaxive.fr/version.json');
        return $app_last = json_decode($viewJsonFile, false);
    }

}