<?php


namespace src\MyClass;


use Mailjet\Client;
use Mailjet\Resources;
use src\Controller\Controller;

class SendMail extends Controller
{

    protected $mailer;

    /**
     * @var mixed
     */
    private $viewJson;

    public function __construct()
    {
        parent::__construct();
        // Lecture du fichier de configuration json
        $viewJsonFile = file_get_contents(ROOT. '/config/mail.json');
        $this->viewJson = json_decode($viewJsonFile, false);

        $transport = (new \Swift_SmtpTransport($this->viewJson->mail_host, $this->viewJson->mail_port))
            ->setUsername($this->viewJson->mail_username)
            ->setPassword($this->viewJson->mail_password)
            ->setEncryption($this->viewJson->mail_encryption); // For Gmail
        $this->mailer = new \Swift_Mailer($transport);
    }


    /**
     * Permet d'envoyer un email simple
     * TEST LOCAL / DEV
     * @param string $subject
     * @param string $view
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendSwiftMailerLocal(string $subject, string $view)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['yann@synexo.fr', 'yann@synexo.fr' => 'Proaxive - Votre suivi en ligne'])
            ->setBody($this->twig->render($view),'text/html');

        $this->mailer->send($message);
    }

    /**
     * Permet d'envoyer un email avec variables dans une vue twig
     * LOCAL
     * @param string $subject
     * @param array $data
     * @param string $view
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendDataSwiftMailerLocal(string $subject, array $data, string $view)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['noreply@synexo.fr' => 'Proaxive Support'])
            ->setBody($this->twig->render($view, $data),'text/html');
        $this->mailer->send($message);
    }


    public function sendDataMailer(){
        if (getenv('MAIL_SERVICE') == 'mailjet'){

        } elseif (getenv('MAIL_SERVICE') == 'swiftmailer'){

        }
    }

    /**
     * Envoi un email de suivi d'intervention au client
     * Peut également être utiilisé avec d'autres vues
     * PROD
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $name
     * @param array $data
     * @param string $view
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendDataSwiftMailer(string $subject, string $from, string $to = null, string $name, array $data, string $view)
    {
        $subject = $this->viewJson->mail_title_from;
        $message = (new \Swift_Message($subject))
            ->setFrom([$to => $this->viewJson->mail_title_from])
            ->setTo([$from => $name])
            ->setBody($this->twig->render($view, $data),'text/html');
        $this->mailer->send($message);
    }

    /**
     * Envoi d'email via les serveurs de Mailjet (configuration par défaut)
     * Un compte gratuit permet d'envoyer 6000 mails par mois / 200 mails par jour
     * Configurez vos clé via le fichier de configuration (.env) à la racine de l'application
     * Pour créer compte gratuit Mailjet : mailjet.com
     * @param string $subject
     * @param string $mail
     * @param string $fullname
     * @param array $data
     * @param string $view
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendDataMailJet(string $subject, string $mail, string $fullname, array $data, string $view){

        $mj = new Client($this->viewJson->mailjet_publickey, $this->viewJson->mailjet_privatekey,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->viewJson->mailjet_username,
                        'Name' => $this->viewJson->mail_title_from
                    ],
                    'To' => [
                        [
                            'Email' => "$mail",
                            'Name' => "$fullname"
                        ]
                    ],
                    'Subject' => "$subject",
                    'TextPart' => "Greetings from Mailjet!",
                    'HTMLPart' => $this->twig->render($view, $data)
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

}
