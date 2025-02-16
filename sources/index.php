<?php
ob_start();

require_once __DIR__ . '/core/Session.php';
Session::start();

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/MailService.php';


require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Group.php';
require_once __DIR__ . '/models/Photo.php';
require_once __DIR__ . '/models/PasswordResetToken.php';


require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/LoginController.php';
require_once __DIR__ . '/controllers/RegisterController.php';
require_once __DIR__ . '/controllers/LogoutController.php';
require_once __DIR__ . '/controllers/UploadController.php';
require_once __DIR__ . '/controllers/GroupController.php';
require_once __DIR__ . '/controllers/PhotoController.php';
require_once __DIR__ . '/controllers/PasswordResetController.php';
require_once __DIR__ . '/controllers/MailController.php';

$autoloadPath = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    die("Autoload file not found at: " . $autoloadPath);
}
require_once $autoloadPath;




$router = new Router();

/* ---------------------- */
/* Routes pour l'authentification et la page d'accueil */
/* ---------------------- */
$router->get("/", HomeController::class, "index");
$router->get("/galerie", HomeController::class, "galerie");

$router->get("/login", LoginController::class, "index");
$router->post("/login", LoginController::class, "post");
$router->get("/register", RegisterController::class, "index");
$router->post("/register", RegisterController::class, "post");
$router->get("/logout", LogoutController::class, "index");

/* ---------------------- */
/* Routes pour l'upload de photos */
/* ---------------------- */
$router->get("/upload", UploadController::class, "index");
$router->post("/upload", UploadController::class, "upload");
$router->get("/upload/manage", UploadController::class, "manage");

/* ---------------------- */
/* Routes pour la gestion des groupes */
/* ---------------------- */
// Dashboard général des groupes (menu principal)
$router->get("/group", GroupController::class, "dashboard");

// Route pour créer un groupe
$router->get("/group/create", GroupController::class, "createForm");
$router->post("/group/create", GroupController::class, "create");

// Route pour afficher les groupes de l'utilisateur (Mes groupes)
$router->get("/group/my", GroupController::class, "myGroups");

// Routes pour la gestion d'un groupe existant
$router->get("/group/{name}/manage", GroupController::class, "manage");
$router->get("/group/{name}/photos", GroupController::class, "photos");
$router->post("/group/{name}/upload", GroupController::class, "uploadPhoto");

// Routes pour la gestion des membres dans un groupe
$router->post("/groups/add-member/{groupId}", GroupController::class, "addMember");
$router->post("/groups/update-member/{groupId}/{userId}", GroupController::class, "updateMemberRights");
$router->post("/groups/remove-member/{groupId}/{userId}", GroupController::class, "removeMember");
$router->get("/photo/public/{token}", PhotoController::class, "publicView");
$router->post("/photo/{id}/share", PhotoController::class, "share");

// Route pour la suppression d'une photo
$router->post("/photo/{id}/delete", PhotoController::class, "delete");
$router->post("/group/{name}/delete", GroupController::class, "delete");


// Routes pour la réinitialisation du mot de passe

$router->get('/password-reset', LoginController::class, 'showPasswordResetForm');
$router->post('/password-reset', MailController::class, 'sendResetLink');

$router->get('/reset-password', LoginController::class, 'showResetPasswordForm');
$router->post('/reset-password', PasswordResetController::class, 'resetPassword');


$router->start();
ob_end_flush();
