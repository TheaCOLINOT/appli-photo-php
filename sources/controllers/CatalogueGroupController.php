<?php

require_once __DIR__.'/../models/CatalogueGroup.php';


class CatalogueGroup 
{
    public static function index(): void 
    {
        $userId = Session::get('user')["id"]; // Récupération de l'utilisateur connecté
        $groupModel = new GroupModel();
        $groups = $groupModel->getUserGroups($userId);
        
        require_once __DIR__ .  '/../views/group/index.php';
    }

    public static function upload(): void 
    {
        // Vérification de connexion
        if (Session::get('user') == null) {
            $_SESSION['error'] = "Vous devez être connecté pour uploader une photo.";
            header("Location: /login");
            exit();
        }

        // Vérification de la requête
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['photo'])) {
            $_SESSION['error'] = "Aucun fichier envoyé.";
            header("Location: /upload");
            exit();
        }

        $data = [
            'user_id' => Session::get('user')["id"],
            'path' => $filePath
        ];
        
        if (Photo::upload($data)) {
            $_SESSION['success'] = "Photo uploadée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de l'enregistrement de la photo.";
        }

        header("Location: /upload");
        exit();
    }
}
?>