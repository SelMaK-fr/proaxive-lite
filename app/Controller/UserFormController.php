<?php

namespace App\Controller;

use App;
use Otp\Otp;
use ParagonIE\ConstantTime\Encoding;
use src\Auth\Auth;
use src\Form\MaterializeForm;
use src\Form\SpectreForm;
use src\MyClass\Session;
use src\MyClass\Str;

class UserFormController extends AppController
{

    /**
     * @var session
     */
    private $session;

    public function __construct(){
        // Chargements des tables SQL
        $this->session = Session::getSessionInstance();
        parent::__construct();
        $this->loadModel('User');
    }

    /**
     * Permet de se connecter à l'espace utilisateur
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        $auth = App::getAuth();
        $db = App::getInstance()->getDB();
        $auth->connectFromCookie($db);
        if($auth->logged()){$this->redirect('/admin');}
        if(!empty($_POST)){
            $this->session->setFlash('danger', "Veuillez rentrez votre nom utilisateur et mot de passe");
        }
        if(!empty($_POST) && !empty($_POST['pseudo']) && !empty($_POST['password'])){
            //
            $user = $auth->login($db, $_POST['pseudo'], $_POST['password'], isset($_POST['proaxive_remember']));
            if($user){
                $auth = new Auth(app::getInstance()->getDB());
                $auth->connect($user);
                $this->redirect('/admin');
            }else{
                $this->session->setFlash('danger', "Désolé, cette combinaison est introuvable ou le compte utilisateur n'est pas activé.");
            }
        }
        $form = new SpectreForm($_POST);
        $this->render('login/home.twig', [
            'form' => $form
        ]);
    }


    /**
     * Permet de se connecter avec l'authentification à double facteurs
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function loginTotp(){

        if(!$this->session->read('user_id')){
            return $this->login();
        }

        $user = $this->User->find('id', $this->session->read('user_id'));
        $otp = new Otp();
        if(!empty($_POST)){
            if($otp->checkTotp(Encoding::base32DecodeUpper($user->key_totp), $_POST['code'])){
                $auth = new Auth(app::getInstance()->getDB());
                $auth->connect($user);
                //$this->session->setFlash('success', "Vous êtes connecté !");
                $this->redirect('/admin');
            } else {
                $this->session->setFlash('danger', 'Ce code ne correspond pas !');
            }
        }

        $form = new SpectreForm($_POST);
        $this->render('login/logintotp.twig', [
            'form' => $form
        ]);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function reset(){
        $auth = App::getAuth();
        $db = App::getInstance()->getDB();
        # Vérifie si l'utilisateur est connecté
        if($auth->logged()){$this->redirect('/admin');}
        # Vérifie le formulaire et envoi le lien de réinitialisation
        if(!empty($_POST) && !empty($_POST['email'])){
            # Vérifie si c'est bien une adresse email
            $scanMail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            # Scan la base de donnée afin de recherche l'adresse email
            $verifyEmail = $this->User->scanMail($scanMail);
            if($verifyEmail){
                $auth->resetPassword($db, $scanMail, $verifyEmail->id);
                $this->session->setFlash('success', "<strong>Succès</strong> Les instructions du rappel de mot de passe vous ont été envoyées par courriel.");
            } else {
                $this->session->setFlash('danger', "<strong>Erreur</strong> Aucun profil ne corresponde à cette adresse.");
            }

        }
        $form = new SpectreForm($_POST);
        $this->render('login/lostpassword.twig', [
            'form' => $form
        ]);
    }

    /**
     * @param $getToken
     * @param int $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function init($token, int $id)
    {
        $auth = App::getAuth();
        $db = App::getInstance()->getDB();

        $user = $this->User->scanToken($id, $token);

        if($user){
            if(!empty($_POST)){
                $password = htmlspecialchars($_POST['password']);
                $password_confirm = htmlspecialchars($_POST['password_confirm']);
                if(isset($password) && $password_confirm){
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);
                    $auth->initPwdAuth($db, $id, $password_hash);
                    $this->session->setFlash('success', "<strong>Réinitialisé</strong> Votre mot de passe a été changé, vous pouvez maintenant vous connecter.");
                    return $this->redirect(getenv('APP_LOGIN_URL'));
                } else {
                    $this->session->setFlash('danger', "<strong>Erreur</strong> Un compte sans mot de passe ? Voyons, restons sérieux !");
                }
            }
        } else {
            $this->session->setFlash('danger', "<strong>Erreur</strong> Ce token n'est pas valide.");
            return $this->reset();
        }

        $form = new SpectreForm($_POST);
        $this->render('login/init.twig', [
            'form' => $form
        ]);
    }

}