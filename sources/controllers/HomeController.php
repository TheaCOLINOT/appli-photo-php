
<?php

class HomeController
{
    public static function index(): void
    {
        require_once __DIR__ . '/../views/frontend/accueil.php';
    }
}
