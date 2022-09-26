#### Proaxive Lite 1.5.3 (stable)
Attention : cette mise à jour modifie les variables couleurs du CSS, pensez à sauvegarder vos fichiers `light-style.css` et `dark-style.css`
Pensez également à vider le cache de votre navigateur après la mise à jour.
```
- Modification du menu "Actions" dans l'édition d'intervention
- Ajout de l'édition du titre/nom de l'intervention
- Mise à jour de l'export CSV Client (pour import v1.7)
- Mise à jour CSS et HTML
- Correction grid dans la fiche client
- Correction de l'éditeur SimpleMde
- Réorganisation du profil client dans le panel d'administration
- Ajout d'un label si l'intervention n'est pas débutée
- Nouveau switcher de theme
- Plusieurs améliorations graphique
```

#### Proaxive Lite 1.5.2 (stable)
```
- Suppression de la décompression d'archive
- Modification de la connexion à la base de données
- Mise à jour du fichier SQL
```

#### Proaxive Lite 1.5.2 (stable)
Version stable du projet Proaxive.
```
- Ajout de la gestion de débours
- Suppression card sécurité application (paramètres)
- Corrections HTML/CSS mobile
- Correction du menu (mobile)
- Mise à jour "Services Courriel"
- Mise à jour profil client
```
#### [Fichiers nouveaux/édités]
config/routing.php  
app/Controller/Dashboard/AdminOutlayController.php  
app/Controller/Dashboard/AdminClientController.php  
app/Entity/OutlayEntity.php  
app/Model/OutlayModel.php  
views/outlay/*all  
views/_layout/dashboard/_main_menu.twig  
views/_layout/dashboard/_main_menu_mobile.twig
views/client/admin/show.twig
views/_layout/dashboard/layout.twig  
public/assets/styles/admin-default/stylesheets/layout.css  
public/assets/styles/print-intervention/voucher.css
views/dashboard/settings/courriel.twig  
views/dashboard/settings/home.twig  
views/templates/print_outlay.twig
app/Controller/Dashboard/AdminSettingController.php  
src/MyClass/SendMail.php

#### Proaxive Lite 1.5.1 (stable)
Première version stable du projet Proaxive.
```
- Ajout de la suppression client
```
#### [Fichiers édités]   
app/App.php  
config/routing.php  
views/clients/admin/show.twig  
version.xml  
README.md  
composer.json