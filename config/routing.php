<?php

use src\Router\Router;

$router = new Router($_GET['url']);
//// LOGIN DASHBAORD ////
$router->get('/'.App::getJson()->app_login_url, "UserForm#login");
$router->post('/'.App::getJson()->app_login_url, "UserForm#login");
$router->get('/login-Totp', "UserForm#loginTotp");
$router->post('/login-Totp', "UserForm#loginTotp");
//
$router->get('/lostpassword', "UserForm#reset");
$router->post('/lostpassword', "UserForm#reset");
$router->get('/init-password/:token/:id', 'UserForm#init')->with('token', '[a-z\-0-9]+')->with('id', '[0-9]+');
$router->post('/init-password/:token/:id', 'UserForm#init')->with('token', '[a-z\-0-9]+')->with('id', '[0-9]+');

//// GET INDEX (VISITOR) ////
// Interventions
$router->get('/i/:numberlink', "Intervention#show")->with('numberlink', '[a-z\-0-9]+');
$router->get('/i/:number/pdf', 'Intervention#snappyPDF')->with('number', '[0-9]+');
$router->get('/i/:number_link/print', 'Intervention#printIntervention')->with('number_link', '[a-z\-0-9]+');
$router->get('/', "Home#home");
$router->post('/', "Home#home");
// Error
$router->get('/notfound', "Error#error404");
$router->get('/ie6-browser', "Error#browser");
// Logout
$router->get('/logout', 'User#logout');
//// ADMIN GET AND POST ////
$router->get('/admin', "Dashboard#AdminHome#index"); // index dashboard
// Company
$router->get('/admin/company', 'Dashboard#AdminCompany#home');
$router->get('admin/add-company', 'Dashboard#AdminCompany#add');
$router->post('admin/add-company', 'Dashboard#AdminCompany#add');
$router->get('/admin/edit-company/:id', "Dashboard#AdminCompany#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-company/:id', "Dashboard#AdminCompany#edit")->with('id', '[0-9]+');
// Interventions
$router->get('/admin/interventions', "Dashboard#AdminIntervention#home");
$router->get('/admin/intervention/sendmail-update/:id', "Dashboard#AdminIntervention#sendMailUpdate")->with('id', '[0-9]+');
$router->get('/admin/intervention/html/:id', "Dashboard#AdminIntervention#showHtml")->with('id', '[0-9]+');
$router->get('/admin/intervention/html/print/:id', "Dashboard#AdminIntervention#showHtml")->with('id', '[0-9]+');
$router->get('/admin/intervention/pdf/:id', "Dashboard#AdminIntervention#snappyPDF")->with('id', '[0-9]+');
$router->get('/admin/inter/messages', "Dashboard#AdminIntervention#messages");
$router->get('/admin/edit-intervention/:id', "Dashboard#AdminIntervention#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-intervention/:id', "Dashboard#AdminIntervention#edit")->with('id', '[0-9]+');
$router->get('/admin/intervention/:id/rapport/bao', "Dashboard#AdminIntervention#bao")->with('id', '[0-9]+');
$router->post('/admin/intervention/:id/rapport/bao', "Dashboard#AdminIntervention#bao")->with('id', '[0-9]+');
$router->get('/admin/add-intervention', "Dashboard#AdminIntervention#add");
$router->post('/admin/add-intervention', "Dashboard#AdminIntervention#add");
$router->get('/admin/equipments/byclient/:id', 'Dashboard#AdminEquipment#byclient')->with('id', '[0-9]+');
$router->get('/admin/client/:id_client/add-intervention', "Dashboard#AdminIntervention#addWithClient")->with('id_client', '[0-9]+');
$router->post('/admin/client/:id_client/add-intervention', "Dashboard#AdminIntervention#addWithClient")->with('id_client', '[0-9]+');
$router->post('/admin/client/:id_client/equipment/:id_equipment/add-intervention', "Dashboard#AdminIntervention#addWithClientAndEquipment")->with('id_client', '[0-9]+')->with('id_equipment', '[0-9]+');
$router->get('/admin/client/:id_client/equipment/:id_equipment/add-intervention', "Dashboard#AdminIntervention#addWithClientAndEquipment")->with('id_client', '[0-9]+')->with('id_equipment', '[0-9]+');
$router->post('/admin/intervention/delete', "Dashboard#AdminIntervention#delete");
// Equipments
$router->get('/admin/equipments', "Dashboard#AdminEquipment#home");
$router->post('/admin/equipments/export', "Dashboard#AdminEquipment#exportEquipment");
$router->get('admin/equipments/byclient/:id', 'Dashboard#AdminEquipment#byclient')->with('id', '[0-9]+');
$router->get('/admin/edit-equipment/:id', "Dashboard#AdminEquipment#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-equipment/:id', "Dashboard#AdminEquipment#edit")->with('id', '[0-9]+');
$router->get('/admin/add-equipment', "Dashboard#AdminEquipment#add");
$router->post('/admin/add-equipment', "Dashboard#AdminEquipment#add");
$router->post('/admin/equipment/delete', "Dashboard#AdminEquipment#delete");
$router->get('/admin/client/:id_client/add-equipment', "Dashboard#AdminEquipment#addWithClient")->with('id_client', '[0-9]+');
$router->post('/admin/client/:id_client/add-equipment', "Dashboard#AdminEquipment#addWithClient")->with('id_client', '[0-9]+');
// Equipments categories
$router->get('/admin/equipments/categories', "Dashboard#AdminCategoriesEquipment#home");
$router->post('/admin/equipments/categories', "Dashboard#AdminCategoriesEquipment#home");
$router->get('/admin/equipments/edit-category/:id', "Dashboard#AdminCategoriesEquipment#edit")->with('id', '[0-9]+');
$router->post('/admin/equipments/edit-category/:id', "Dashboard#AdminCategoriesEquipment#edit")->with('id', '[0-9]+');
$router->post('/admin/equipments/category/delete', "Dashboard#AdminCategoriesEquipment#delete");
// Equipments brands
$router->get('/admin/equipments/brands', "Dashboard#AdminBrand#home");
$router->post('/admin/equipments/brands', "Dashboard#AdminBrand#home");
$router->get('/admin/equipments/edit-brand/:id', "Dashboard#AdminBrand#edit")->with('id', '[0-9]+');
$router->post('/admin/equipments/edit-brand/:id', "Dashboard#AdminBrand#edit")->with('id', '[0-9]+');
$router->post('/admin/equipments/brand/delete', "Dashboard#AdminBrand#delete");
// Equipments Operating System
$router->get('/admin/operating-systems', "Dashboard#AdminOperatingSystem#home");
$router->post('/admin/operating-systems', "Dashboard#AdminOperatingSystem#home");
$router->get('/admin/edit-operating-system/:id', "Dashboard#AdminOperatingSystem#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-operating-system/:id', "Dashboard#AdminOperatingSystem#edit")->with('id', '[0-9]+');
$router->post('/admin/operating-system/delete', "Dashboard#AdminOperatingSystem#delete")->with('id', '[0-9]+');
// Company
$router->get('/admin/company', 'Dashboard#AdminCompany#home');
$router->get('/admin/add-company', 'Dashboard#AdminCompany#add');
$router->post('/admin/add-company', 'Dashboard#AdminCompany#add');
$router->get('/admin/edit-company/:id', "Dashboard#AdminCompany#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-company/:id', "Dashboard#AdminCompany#edit")->with('id', '[0-9]+');
// Status
$router->get('/admin/status', "Dashboard#AdminStatus#home");
$router->post('/admin/status', "Dashboard#AdminStatus#home");
$router->get('/admin/edit-status/:id', "Dashboard#AdminStatus#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-status/:id', "Dashboard#AdminStatus#edit")->with('id', '[0-9]+');
$router->post('/admin/status/deleted', "Dashboard#AdminStatus#delete");
// Departments
$router->get('/admin/departments', "Dashboard#AdminDepartment#home");
$router->post('/admin/departments', "Dashboard#AdminDepartment#home");
$router->get('/admin/edit-department/:id', "Dashboard#AdminDepartment#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-department/:id', "Dashboard#AdminDepartment#edit")->with('id', '[0-9]+');
// Client
$router->get('/admin/clients', "Dashboard#AdminClient#home");
$router->post('/admin/clients/export', "Dashboard#AdminClient#exportClient");
$router->get('/admin/add-client', "Dashboard#AdminClient#add");
$router->post('/admin/add-client', "Dashboard#AdminClient#add");
$router->get('/admin/edit-client/:id', "Dashboard#AdminClient#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-client/:id', "Dashboard#AdminClient#edit")->with('id', '[0-9]+');
$router->get('/admin/client/:id', "Dashboard#AdminClient#view")->with('id', '[0-9]+');
$router->post('/admin/client/delete', "Dashboard#AdminClient#delete");
/* God Users and tech */
$router->get('/admin/ausers', "Dashboard#AdminAuser#home");
$router->get('/admin/ausers/totp', "Dashboard#AdminAuser#totp");
$router->post('/admin/ausers/totp', "Dashboard#AdminAuser#totp");
$router->post('/admin/auser/totp/desactivate', "Dashboard#AdminAuser#totpDesactivate");
$router->get('/admin/add-auser', "Dashboard#AdminAuser#add");
$router->post('/admin/add-auser', "Dashboard#AdminAuser#add");
$router->get('/admin/edit-auser/:id', "Dashboard#AdminAuser#edit")->with('id', '[0-9]+');
$router->post('/admin/edit-auser/:id', "Dashboard#AdminAuser#edit")->with('id', '[0-9]+');
// Roles
$router->get('/admin/ausers/roles', "Dashboard#AdminAuser#rolesAuser");
$router->post('/admin/ausers/roles', "Dashboard#AdminAuser#rolesAuser");
$router->get('/admin/ausers/role/:id', "Dashboard#AdminAuser#editRoleAuser")->with('id', '[0-9]+');
$router->post('/admin/ausers/role/:id', "Dashboard#AdminAuser#editRoleAuser")->with('id', '[0-9]+');
$router->post('/admin/ausers/role/delete', "Dashboard#AdminAuser#deleteRole");
// Setting
$router->get('/admin/setting', 'Dashboard#AdminSetting#home');
$router->post('/admin/setting', 'Dashboard#AdminSetting#home');
$router->get('/admin/setting/courriel', 'Dashboard#AdminSetting#courriel');
$router->post('/admin/setting/courriel', 'Dashboard#AdminSetting#courriel');
$router->get('/admin/setting/css', 'Dashboard#AdminSetting#homeTheme');
$router->post('/admin/setting/css', 'Dashboard#AdminSetting#homeTheme');
$router->get('/admin/setting/css/:theme', 'Dashboard#AdminSetting#viewCSS')->with('theme', '[a-z\-0-9]+');
$router->post('/admin/setting/css/:theme', 'Dashboard#AdminSetting#viewCSS')->with('theme', '[a-z\-0-9]+');
$router->get('/admin/setting/css/:theme/:css', 'Dashboard#AdminSetting#editCSS')->with('string', '[a-z\-0-9]+')->with('css', '[a-z\-0-9]+');
$router->post('/admin/setting/css/:theme/:css', 'Dashboard#AdminSetting#editCSS')->with('string', '[a-z\-0-9]+')->with('css', '[a-z\-0-9]+');
// Update App
$router->get('/database-update', 'ProaxiveUpdate#updateDatabase');
$router->post('/database-update', 'ProaxiveUpdate#updateDatabase');
$router->run();