<?php

namespace src\Auth;

use src\MyClass\SendMail;
use src\MyClass\Session;

class Auth
{

    /**
     * @var session
     */
    private Session $session;
    /**
     * @var array
     */
    private $option = [
        'restriction_msg' => 'Permission refusée'
    ];

    public function __construct($session, $option = [])
    {

        $this->session = $session;
        $this->option = $option;
    }


    /**
     * Récupère l'ID de l'utilisateur connecté
     *
     * @return mixed
     */
    public function getUserID() {
        if($this->logged()) {
            //return $this->session['auth']->id;
            //return $_SESSION['auth']->id;
            return $this->session->read('auth')->id;
        }
    }

    /**
     * Récupère le rôle id de l' utilisateur
     *
     * @return bool
     */
    public function getUserRid(){

        if($this->logged()){

            //return $_SESSION['auth']->rid;
            $this->session->read('auth')->rid;
        }

        return false;
    }

    /**
     * Permet d'écrire la connexion en session
     *
     * @param $user
     */
    public function connect($user){
        $this->session->write('auth', $user);
    }

    /**
     * Permet de se connecter
     *
     * @param $db
     * @param $pseudo
     * @param $password
     * @param bool $remember
     * @return bool
     */
    public function login($db, $pseudo, $password, $remember = false){
        $user = $db->prepare('SELECT * FROM pl15x_ausers LEFT JOIN pl15x_roles as r ON pl15x_ausers.roles_id = r.id WHERE pseudo = ?', [$pseudo], null, true);
        if($user AND password_verify($password, $user->password)){
            if($user->key_totp != ''){
                $this->session->write('user_id', $user->id);
                header('Location: /login-Totp');
            } else {
                return $user;
            }
        }else{
            return false;
        }
    }

    /**
     * Permet de vérifier si l'utilisateur est bien connecté
     *
     * @return bool
     */
    public function logged(){
        if(!$this->session->read('auth')){
            return false;
        }
        return $this->session->read('auth');
    }


    /**
     * Permet de créer un cookie de connexion
     *
     * @param $db
     */
    public function connectFromCookie($db){
        if(isset($_COOKIE['proaxive_remember']) && !$this->logged()){
            $remember_token = $_COOKIE['proaxive_remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user_id = $db->prepare('SELECT * FROM pl15x_ausers WHERE id = ?', [$user_id], null, true);
            if($user_id){
                $expected = $user_id . '==' . $user_id->remember_token . sha1($user_id . 'proaxive');
                if($expected == $remember_token){
                    $this->connect($user_id);
                    setcookie('proaxive_remember', $remember_token, time() + 60 * 60 * 24 * 7);
                }else{
                    setcookie('proaxive_remember', null, -1);
                }
            }else{
                setcookie('proaxive_remember', null, -1);
            }
        }
    }

    /**
     * Permet d'envoyer un mail de réinitialisation de mot de passe
     *
     * @param $db
     * @param $user_mail
     * @param $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function resetPassword($db, $user_mail, $id){
        if(isset($user_mail)){
            $token = sha1(uniqid(rand())); // Initialise un nouveau token
            $db->prepare('UPDATE pl15x_ausers SET token = ?, reset_at = NOW() WHERE id = ?', [$token, $id], null, true);
            // Envoie du mail
            $user_mail = htmlspecialchars(addslashes($user_mail));
            $token = htmlspecialchars(addslashes($token));
            $sendMail = new SendMail();
            if (getenv('MAIL_SERVICE') == 'mailjet'){
                $sendMail->sendDataMailJet('Réinitialisation du mot de passe', $user_mail, 'Proaxive Lite', [
                    'token' => $token,
                    'user_mail' => $user_mail,
                    'id' => $id
                ], '/templates/mail_initpassword.twig');

            } elseif (getenv('MAIL_SERVICE') == 'swiftmailer') {
                $sendMail->sendDataSwiftMailer('Réinitialisation du mot de passe', $user_mail, $user_mail, 'Proaxive Lite', [
                    'token' => $token,
                    'user_mail' => $user_mail,
                    'id' => $id
                ], '/templates/mail_initpassword.twig');
            }

        }
    }

    /**
     * Permet de réinitialiser le mot de passe
     *
     * @param $db
     * @param $uid
     * @param $password
     */
    public function initPwdAuth($db, $id, $password){
        $db->prepare('UPDATE pl15x_ausers SET password = ?, reset_at = NULL, token = NULL WHERE id = ?', [$password, $id], null, true);
    }

    /*****************************************************************
     * RESTRICTION UTILISATEUR
     * Ces methodes permettent de gérer la restriction utilisation
     *****************************************************************/

    /**
     * Permet de vérifier si l'utilisateur est connecté. Redirige vers login/signin sinon
     */
    public function restrict(){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            header('Location: /');
            exit();
        }
    }

    /**
     * Permet d'accorder l'accès uniquement aux administrateurs
     */
    public function isAdminOnly(){
        if(!$this->session->read('auth') || !$this->session->read('rid') > 1){
            $this->session->setFlash('danger', $this->option['restriction_msg']);
            header('Location: /');
            exit();
        }
    }
}