# PROAXIVE LITE (1.5.x)
### version 1.5.3 (pour développeur)

[![Minimum PHP Version](https://img.shields.io/badge/PHP->=7.4-%23786fa6)](https://php.net/)
[![Minimum MySQL Version](https://img.shields.io/badge/MySQL-5.x-%23f0932b)](https://www.mysql.com/fr/)
[![Require Composer](https://img.shields.io/badge/Composer-2.0.8-green)](https://www.mysql.com/fr/)

Proaxive Micro-Entrepreneur Edition est une application web dédiée aux techniciens informatique
Elle permet de gérer les interventions informatique en ligne. L'application web Proaxive a pour but de simplifier le suivi en atelier. Vos clients peuvent suivre ce qu'il se passe sur leur PC en temps réel.

![ScreenShot](https://proaxive.fr/uploads/img/proaxive_lite.jpg)

#### Requis
- PHP >7.4
- MySQL 5.x
- Apache or Nginx
- Composer (SSH)

#### Licence

Proaxive Lite est distribué sous les termes de la licence GNU General Public License v3+ ou supérieure.

## Installation
01. Décompressez l'archive et envoyez le **contenu** du dossier *public_html* sur votre hébergement/serveur.
    
*(Vous pouvez également effectuer les modifications ci-dessous avant de déployer Proaxive)*
02. Via votre terminal, éditez le fichier de configuration .env.sample (à la racine de l'application) de Proaxive et renseignez les informations de votre base de données et renommez le **.env**.
    
```shell
mv .env.exemple .env
```
03. Via votre terminal, éditez le fichier phinx.yml (à la racine de l'application) de Proaxive et renseignez les informations de votre base de données (section "development").
04. Depuis la racine de Proaxive, lancez l'installation des package via Composer.

```shell
composer install --ignore-platform-reqs
```

*Avant de lancer la migration, créez la base de données qui sera utilisée par Proaxive*   

Pour créer les tables lancez la commande

```shell
vendor/bin/phinx migrate
```

Afin d'ajouter le compte administrateur et les données par défaut, lancez le seeding

```shell
vendor/bin/phinx seed:run
```

Par défaut, Proaxive utilise un fichier .htaccess afin de rediriger vers *public*   
Vous pouvez très bien créer un virtualhost à la place (n'oubliez pas de renommer ou supprimer le .htaccess de la racine)

Rendez-vous sur https://mondomaine.fr/login-dash

Le compte administrateur par défaut est   
Utilisateur : **admin**   
Mot de passe : **admin**  

**Important :** Ne pas oublier de modifier le mot de passe et pseudo du compte via le panel

## Fichier de configuration Proaxive
Le fichier de configuration de l'application **.env** se trouve à la racine de cette dernière

```
APP_NAME=ProaxiveLite
APP_ENV=local
APP_URL=http://localhost:8000
APP_AUTHOR=SynexoLabs
APP_ADMIN_THEME=/public/assets/styles/admin-default
APP_ROOT_PUBLIC=/public
APP_DEBUG=true
APP_DEBUG_PHP=true
APP_ROUTER_LOCAL=false
```
APP_NAME = Nom de l'application  
APP_ENV = local (dev) / production (mise en ligne)  
APP_URL = l'url de l'application (ex : https://tracker.monsite.fr)  
APP_AUTHOR = l'auteur de l'application   

## Sécurisation minimum (production)
Afin de sécuriser un peu plus l'application, je vous conseil de renommer la route qui permet de se connecter au panel.

Rendez-vous dans les paramètres (panel admin)

Remplacez **login-dash** par quelque chose de plus personnel.

Si l'application fonctionne correctement, **désactivez l'affichage des erreurs**.

## Configuration de l'envoi des courriels
**Important** Pensez à bien inscrire une adresse courriel dans les informations de votre entreprise  
> Menu "Accueil" puis onglet "Mon entreprise"

Champ "Courriel"  

La configuration des courriels se fait maintenant dans le panel d'administration  
> Menu "Paramètres" puis onglet "Service Courriel"  
### MailJet
Pour Mailjet, il également nécessaire de remplir la partie "Configuration SMTP".   

Adresse courriel : votre adresse courriel ajoutée dans Mailjet   
Utilisateur : votre clé public Mailjet   
Mot de passe : votre clé privée Mailjet  

La configuration des courriels sera "allégée" à l'avenir.  

### Tester la configuration
Rentrez votre adresse courriel de test dans le champ "Courriel de test".  
Afin de s'assurer que votre configuration fonctionne correctement, cliquez sur "Tester l'envoi".

## Variables d'environnement

APP_NAME => Nom de l'application   
APP_ENV => N'est pour le moment pas utilisée  
_#APP_URL => URL de votre installation Proaxive  
_#APP_LOGIN_URL => Url personnalisée pour la connexion au panel  
APP_ADMIN_THEME => Chemin absolut vers le dossier du thème du panel  
APP_ROOT_PUBLIC => Chemin du dossier public de Proaxive  
APP_DEBUG => Permet d'afficher les erreurs PHP (basique) (ne rien mettre pour désactiver / true pour activer)  
APP_DEBUG_PHP => Permet d'afficher les erreurs PHP (complet) (ne rien mettre pour désactiver / true pour activer)  
DB_HOST => Adresse/IP du serveur MySQL  
DB_PORT => Port MySQL  
DB_DATABASE => Nom de votre base de données  
DB_USERNAME => Utilisateur de la base de données  
DB_PASSWORD => Mot de passe de la base de données  
MAIL_TITLE_FROM => Titre du sujet des emails (suivi intervention par courriel)  
MAIL_SERVICE => Service d'envoi de courriel (mailjet pour utiliser avec les services de Mailjet / swiftmailer pour utiliser SwiftMailer (SMTP personnal))  
MAIL_ADDRESS => Adresse courriel principale  
MAIL_DRIVER  
MAIL_HOST => Adresse/IP/Hôte du service  
MAIL_PORT => Port du service  
MAIL_USERNAME => Utilisateur  
MAIL_PASSWORD => Mot de passe  
MAIL_ENCRYPTION => 
