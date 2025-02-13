<?php

require_once __DIR__.'/../models/CatalogueGroup.php';


class CatalogueGroup 
{
    public static function index(): void 
    {
        $userId = Session::get('user')["id"]; // Récupération de l'utilisateur connecté
        $groupModel = new GroupModel();
        $groups = $groupModel->getUserGroups($userId);
        
        require_once __DIR__ .  '/../views/groups/index.php';
    }

    public static function create(): void 
    {
        // Vérification de connexion
        if (Session::get('user') == null) {
            $_SESSION['error'] = "Vous devez être connecté pour uploader une photo.";
            header("Location: /login");
            exit();
        }

        // Vérification de la requête
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['name'])) {
            $_SESSION['error'] = "Aucun fichier envoyé.";
            header("Location: /groups");
            exit();
        }

        $data = [
            'owner_id' => Session::get('user')["id"],
            'name' => htmlspecialchars($_POST['name']),
            'description' => empty($_POST['description']) ? null : htmlspecialchars($_POST['description'])
        ];
        
        if (GroupModel::create($data)) {
            $_SESSION['success'] = "Groupe crée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors de la création du groupe";
        }

        header("Location: /groups");
        exit();
    }
}
?>