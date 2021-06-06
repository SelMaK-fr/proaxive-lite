<?php


namespace App\Controller;

use App;
use Knp\Snappy\Pdf;
use src\MyClass\Session;


class InterventionController extends AppController
{
    /**
     * @var string
     */
    private $current_menu;

    /**
     * @var session
     */
    private $session;


    public function __construct(){
        $this->current_menu = 'intervention';
        $this->session = Session::getSessionInstance();
        // Chargements des tables SQL
        parent::__construct();
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
     * Permet d'afficher une intervention
     *
     * @param $numberlink
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show($numberlink)
    {
        // Récupère les données de l'entreprise
        $company = $this->Company->isDefault(1);
        // Récupère les données de l'intervention
        $intervention = $this->Intervention->findByKeyAndValue('number_link', $numberlink);

        // Si la variable intervention répond null, on informe l'utilisateur et on le redirige vers l'accueil
        if($intervention == null){
            $this->session->setFlash('danger', "<strong>Erreur :</strong> numéro d'intervention invalide !");
            return $this->redirect('/');
        }
        
        // Récupère toutes les autres données liées à cette intervention
        $client = $this->Client->find('id', $intervention->client_id);
        $user = $this->User->find('id', $intervention->auser_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        $status = $this->Status->find('id', $intervention->status_id);

        // Récupère l'équipement lié à l'intervention
        $equipment = $this->Equipment->findByIntervention($intervention->equipment_id);

        $this->render('intervention/show.twig', [
            'intervention' => $intervention,
            'company' => $company,
            'client' => $client,
            'user' => $user,
            'equipment' => $equipment,
            'brand' => $brand,
            'operatingSystem' => $operatingSystem,
            'categoryEquipment' => $categoryEquipment,
            'status' => $status,
            'current_menu' => $this->current_menu
        ]);
    }

    /**
     * @param $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function printIntervention($number)
    {
        // Récupère les données de l'entreprise
        $company = $this->Company->isDefault(1);
        // Récupère les données de l'intervention
        $intervention = $this->Intervention->findByKeyAndValue('number', $number);
        // Récupère toutes les autres données liées à cette intervention
        $client = $this->Client->find('id', $intervention->client_id);
        $user = $this->User->find('id', $intervention->auser_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);
        $status = $this->Status->find('id', $intervention->status_id);

        $this->render('intervention/print.twig', [
            'intervention' => $intervention,
            'company' => $company,
            'client' => $client,
            'user' => $user,
            'equipment' => $equipment,
            'brand' => $brand,
            'operatingSystem' => $operatingSystem,
            'categoryEquipment' => $categoryEquipment,
            'status' => $status,
            'current_menu' => $this->current_menu
        ]);
    }

    /**
     * Permet de générer le PDF d'une intervention
     * @param string $number
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function snappyPDF(string $number){

        $company = $this->Company->isDefault();
        $intervention = $this->Intervention->findByNumber($number);
        $client = $this->Client->find('id', $intervention->client_id);
        $user = $this->User->find('id', $intervention->auser_id);
        $equipment = $this->Equipment->find('id', $intervention->equipment_id);
        $brand = $this->Brand->find('id', $equipment->brand_id);
        $operatingSystem = $this->OperatingSystem->find('id', $equipment->operating_systems_id);
        $categoryEquipment = $this->CategoryEquipment->find('id', $equipment->category_equipment_id);

        $html = $this->twig->render('intervention/pdf_user.twig', [
            'intervention' => $intervention,
            'company' => $company,
            'client' => $client,
            'user' => $user,
            'equipment' => $equipment,
            'brand' => $brand,
            'operatingSystem' => $operatingSystem,
            'categoryEquipment' => $categoryEquipment
        ]);

        $snappy = new Pdf();
        if(getenv('PDF_WKHTMLTOPDF_WIN') == true){
            $snappy->setBinary(getenv('PDF_WKHTMLTOPDF_PATH'));
        } elseif (getenv('PDF_WKHTMLTOPDF_WIN') == false){
            $snappy->setBinary(ROOT . getenv('PDF_WKHTMLTOPDF_PATH'));
        }
        header('Content-Type: application/pdf');
        echo $snappy->getOutputFromHtml($html);

    }
}