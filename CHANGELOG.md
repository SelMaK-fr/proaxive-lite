#### Proaxive Lite 1.5.2 (stable)
Version stable du projet Proaxive.
```
- Ajout de la gestion de débours
- Suppression card sécurtié application (paramètres)
- Corrections HTML/CSS mobile
- Correction du menu (mobile)
- Mise à jour "Services Courriel"
- Mise à jour profil client
- Correction des cases à cocher (print intervention)
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
views/clients/admin/show.twig
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