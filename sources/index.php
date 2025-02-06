<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/core/Router.php";

require_once __DIR__ . "/controllers/LoginController.php";
require_once __DIR__ . "/controllers/RegisterController.php";
require_once __DIR__ . "/controllers/UploadController.php";

$router = new Router();

$router->get("/login", LoginController::class, "index");
$router->post("/login", LoginController::class, "post");

$router->get("/articles/{slug}", ArticleController::class, "index");

$router->get("/register", RegisterController::class, "index");

$router->get("/upload", UploadController::class, "index");

$router->get('/upload', 'UploadController', 'index');
$router->post('/upload', 'UploadController', 'upload');

$router->get('/groupes/{id}/photos', 'PhotoController', 'showByGroup');



$router->start();
