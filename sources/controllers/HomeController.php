<?php

class HomeController
{
    public static function index(): void
    {
        require_once __DIR__ . '/../views/frontend/accueil.php';
    }
    public static function galerie(): void
    {
        require_once __DIR__ . '/../views/frontend/galerie.php';
    }
    public static function mesphotos(): void
    {
        require_once __DIR__ . '/../views/frontend/mesphotos.php';
    }
}
