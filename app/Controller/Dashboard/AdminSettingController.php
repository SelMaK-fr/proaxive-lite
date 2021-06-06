<?php

namespace App\Controller\Dashboard;

use Creitive\Breadcrumbs\Breadcrumbs;
use src\Entity\Entity;
use src\Form\SpectreForm;
use src\MyClass\Session;

class AdminSettingController extends AppController{


    private string $current_menu;

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var Breadcrumbs
     */
    private Breadcrumbs $breadcrumbs;

    public function __construct()
    {
        parent::__construct();
        $this->current_menu = 'config';
        $this->session = Session::getSessionInstance();
        $this->breadcrumbs = new Breadcrumbs();
    }

    /**
     * Permet de lister les utilisateurs/clients
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home(){
        $folderInstall = ROOT . '/install';
        if(!empty($_POST)){
            // Sauvegarde des nouveaux parametres
            if(isset($_POST['saveParameters'])){
                // Supprime le dernier / si présent de l'URL
                $appurl = rtrim($_POST['app_url'], '/');
                $writeJson = array(
                    'php_error' => $_POST['php_error'],
                    'full_error' => $_POST['full_error'],
                    'view_version' => $_POST['view_version'],
                    'style_selector' => $_POST['style_selector'],
                    'society_days' => $_POST['society_days'],
                    'society_hours' => $_POST['society_hours'],
                    'notify_fixed' => $_POST['notify_fixed'],
                    'app_url' => $appurl,
                    'app_login_url' => $_POST['app_login_url']
                );
                if($writeJson){
                    file_put_contents(ROOT. '/config/setting.json', json_encode($writeJson));
                    $this->session->setFlash('success', "Les nouveaux paramètres ont été appliqués !");
                } else {
                    $this->session->setFlash('danger', "Un problème est survenu !");
                }
            }
            // Renomme le dossier d'installation
            if(isset($_POST['renameFolder'])){
               $renameFolder = rename(ROOT . "/install", ROOT. "/install" . rand(8, 99999));
               if($renameFolder){
                   $this->session->setFlash('success', "Le dossier <strong>install</strong> a bien été renommé !");
               }
            }


        }
        // Lecture du fichier de configuration json
        $varRoot = ROOT;
        $viewJsonFile = file_get_contents(ROOT. '/config/setting.json');
        $viewJson = json_decode($viewJsonFile, true);

        // Vérifie si le dossier d'installation Proaxive existe
        $checkFolderInstall = file_exists($folderInstall);

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Paramètres', '/admin/setting')
            ->addCrumb('Paramètres globaux', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($viewJson);
        $this->render('dashboard/settings/home.twig', [
            'form' => $form,
            'varRoot' => $varRoot,
            'checkFolderInstall' => $checkFolderInstall,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * Permet de lister les utilisateurs/clients
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function courriel(){
        if(!empty($_POST)){
            // Sauvegarde des nouveaux parametres
            if(isset($_POST['saveParameters'])){
                $writeJson = array(
                    'mail_title_from' => $_POST['mail_title_from'],
                    'mail_service' => $_POST['mail_service'],
                    'mail_address' => $_POST['mail_address'],
                    'mail_host' => $_POST['mail_host'],
                    'mail_port' => $_POST['mail_port'],
                    'mail_username' => $_POST['mail_username'],
                    'mail_password' => $_POST['mail_password'],
                    'mail_encryption' => $_POST['mail_encryption'],
                    'mailjet_publickey' => $_POST['mailjet_publickey'],
                    'mailjet_privatekey' => $_POST['mailjet_privatekey'],
                    'mailjet_username' => $_POST['mailjet_username'],
                    'mailjet_password' => $_POST['mailjet_password'],
                );
                if($writeJson){
                    file_put_contents(ROOT. '/config/mail.json', json_encode($writeJson));
                    $this->session->setFlash('success', "Les nouveaux paramètres ont été appliqués !");
                } else {
                    $this->session->setFlash('danger', "Un problème est survenu !");
                }
            }
        }
        $viewJsonFile = file_get_contents(ROOT. '/config/mail.json');
        $viewJson = json_decode($viewJsonFile, true);

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Paramètres', '/admin/setting')
            ->addCrumb('Services Courriel', '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($viewJson);
        $this->render('dashboard/settings/courriel.twig', [
            'form' => $form,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);

    }

    /**
     * Permet d'affiche les themes CSS d'un template
     * @param $theme
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function homeTheme(){

        $dir = ROOT. 'public/assets/styles';
        $folders = array_diff(scandir($dir), array('..', '.', 'default-css'));

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Paramètres', '/admin/setting')
            ->addCrumb('Thème CSS', '');
        $this->breadcrumbs->render();

        $this->render('dashboard/settings/themes/home.twig', [
            'folders' => $folders,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'affiche les themes CSS d'un template
     * @param $theme
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function viewCSS($theme){

        $theme = Entity::cleanText($theme);
        $dir = ROOT. 'public/assets/styles/' . $theme . '/stylesheets';
        if (file_exists($dir)){
            $files = array_diff(scandir($dir), array('..', '.'));
        } else {
            $this->session->setFlash('danger', "Impossible d'ouvrir le dossier <strong>$theme</strong>");
            return $this->homeTheme();
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Paramètres', '/admin/setting')
            ->addCrumb('Thème CSS', '/admin/setting/css')
            ->addCrumb($theme, '');
        $this->breadcrumbs->render();

        $this->render('dashboard/settings/themes/folders.twig', [
            'files' => $files,
            'theme' => $theme,
            'current_menu' => $this->current_menu,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Permet d'affiche les themes CSS d'un template
     * @param $theme
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function editCSS($theme, $css){

        $theme = Entity::cleanText($theme);
        $dir = ROOT. 'public/assets/styles/' . $theme . '/stylesheets/';
        $file = $dir . $css .'.css';
        if (file_exists($file)){
            $handle = $this->openFile($dir . $css.'.css', 'r');
        } else {
            $this->session->setFlash('danger', "Impossible d'ouvrir le fichier <strong>$css.css</strong>");
            return $this->homeTheme();
        }

        if(!empty($_POST)){
            if(isset($_POST['stylesheets'])){
                $stylesheets = $_POST['stylesheets'];
                // Vérifie si le fichier peut être écrit.
                if (is_writable($file)) {
                    if (!$handle = fopen($file, 'w+')) {
                        $this->session->setFlash('danger', "Impossible d'ouvrir le fichier ($file)");
                        exit;
                    }

                    if (fwrite($handle, $stylesheets) === FALSE) {
                        echo "Impossible d'écrire dans le fichier ($file)";
                        exit;
                    }

                    $this->session->setFlash('success', "<strong>[Rafraîchissement dans 3s]</strong> L'écriture dans le fichier CSS ($css) a réussi");
                    fclose($handle);
                    header("Refresh: 3;url=/admin/setting/css/$theme/$css");


                } else {
                    $this->session->setFlash('danger', "Le fichier $file n'est pas accessible en écriture.");

                }
            }
        }

        //Breadcrumb
        $this->breadcrumbs->addCrumb('Accueil', '/admin')
            ->addCrumb('Paramètres', '/admin/setting')
            ->addCrumb('Thème CSS', '/admin/setting/css')
            ->addCrumb($theme, '/admin/setting/css/'.$theme)
            ->addCrumb($css, '');
        $this->breadcrumbs->render();

        $form = new SpectreForm($_POST);
        $this->render('dashboard/settings/themes/edit.twig', [
            'css' => $handle,
            'cssName' => $css,
            'form' => $form,
            'theme' => $theme,
            'current_menu' => $this->current_menu,
            'breadcrumbs' =>$this->breadcrumbs
        ]);
    }

}
