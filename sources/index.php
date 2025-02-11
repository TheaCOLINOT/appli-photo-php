<?php
ob_start();

require_once __DIR__ . '/core/Session.php';
Session::start();

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Router.php';

require_once __DIR__ . '/models/User.php';

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/LoginController.php';
require_once __DIR__ . '/controllers/RegisterController.php';
require_once __DIR__ . '/controllers/LogoutController.php';
require_once __DIR__ . '/controllers/UploadController.php';
require_once __DIR__ . '/controllers/CatalogueGroupController.php';
require_once __DIR__ . '/controllers/CataloguePhotoController.php';

$router = new Router();

$router->get("/articles/{slug}", ArticleController::class, "index");

$router->get("/upload", UploadController::class, "index");

$router->get('/upload', 'UploadController', 'index');
$router->post('/upload', 'UploadController', 'upload');

$router->get('/', HomeController::class, 'index');
$router->get('/login', LoginController::class, 'index');
$router->post('/login', LoginController::class, 'post');
$router->get('/register', RegisterController::class, 'index');
$router->post('/register', RegisterController::class, 'post');
// Routes pour la réinitialisation du mot de passe

$router->get('/groups', 'GroupPhotoController', 'index');
$router->post('/groups/create', 'GroupPhotoController', 'create');
$router->post('/groups/addUser', 'GroupPhotoController', 'addUser');
$router->post('/groups/removeUser', 'GroupPhotoController', 'removeUser');
$router->post('/groups/changeRole', 'GroupPhotoController', 'changeRole');
$router->get('/groups', 'GroupPhotoController', 'index');

$router->get('/catagroup', 'CatalogueGroup', 'index');
$router->get('/CatalogueGroup/photos', 'CatalogueGroup', 'index');

$router->get('/CataloguePhoto', 'CataloguePhoto', 'index');
$router->get('/group/photos', 'CataloguePhoto', 'index');

$router->get('/logout', LogoutController::class, 'index');

$router->start();
ob_end_flush();
