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
$autoloadPath = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    die("Autoload file not found at: " . $autoloadPath);
}
require_once $autoloadPath;

require_once __DIR__ . '/controllers/MailController.php';




// var_dump($autoloadPath);
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
$router->get('/passwordReset',LoginController::class, 'passwordReset');
$router->post('/passwordReset',MailController::class, 'passwordResetEmail');
$router->get('/logout', LogoutController::class, 'index');

$router->start();
ob_end_flush();
