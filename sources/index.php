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

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/login', LoginController::class, 'index');
$router->post('/login', LoginController::class, 'post');
$router->get('/register', RegisterController::class, 'index');
$router->post('/register', RegisterController::class, 'post');
// Routes pour la réinitialisation du mot de passe

$router->get('/logout', LogoutController::class, 'index');

$router->start();
ob_end_flush();
