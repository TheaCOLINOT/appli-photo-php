<?php

require_once __DIR__.'/../models/Photo.php';
require_once __DIR__.'/../models/CatalogueGroup.php';

class UploadController {
    private const UPLOAD_DIR = 'uploads/';
    private const MAX_SIZE = 5 * 1024 * 1024; // 5MB
    private const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];

    public static function index(): void 
    {
        // Vérification de connexion
        if (Session::get('user') == null) {
            $_SESSION['error'] = "Vous devez être connecté pour uploader une photo.";
            header("Location: /login");
            exit();
        }

        $groups = GroupModel::getUserGroups(Session::get('user')["id"]);

        require_once 'views/upload/index.php';
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

        $file = $_FILES['photo'];

        // Vérification des erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Erreur lors de l'upload : code " . $file['error'];
            header("Location: /upload");
            exit();
        }

        // Vérification du type MIME
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, self::ALLOWED_TYPES)) {
            $_SESSION['error'] = "Format non autorisé (JPG, PNG, GIF uniquement).";
            header("Location: /upload");
            exit();
        }

        // Vérification de la taille
        if ($file['size'] > self::MAX_SIZE) {
            $_SESSION['error'] = "Fichier trop volumineux (5MB max).";
            header("Location: /upload");
            exit();
        }

        // Vérification de l'extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXTENSIONS)) {
            $_SESSION['error'] = "Extension non valide.";
            header("Location: /upload");
            exit();
        }

        // Génération d'un nom de fichier unique
        $filename = uniqid() . '.' . $ext;
        $filePath = self::UPLOAD_DIR . $filename;

        // Vérification du dossier d'upload
        if (!is_dir(self::UPLOAD_DIR) && !mkdir(self::UPLOAD_DIR, 0777, true)) {
            $_SESSION['error'] = "Erreur interne : impossible de créer le dossier d'upload.";
            header("Location: /upload");
            exit();
        }

        // Déplacement du fichier
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            $_SESSION['error'] = "Erreur lors du déplacement du fichier.";
            header("Location: /upload");
            exit();
        }

        // Sauvegarde en base de données
        // $photo = new Photo();
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
