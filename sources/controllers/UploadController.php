<?php

class UploadController {
    public static function index(): void 
    {
        require_once 'views/upload/index.php';
    }

    public static function upload(): void 
    {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour uploader une photo.";
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['photo'])) {
            $_SESSION['error'] = "Aucun fichier envoyé.";
            header("Location: /upload");
            exit();
        }

        $file = $_FILES['photo'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $uploadDir = 'uploads/';

        // Vérification erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Erreur lors de l'upload : code " . $file['error'];
            header("Location: /upload");
            exit();
        }

        // Vérification type MIME
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, $allowedTypes)) {
            $_SESSION['error'] = "Format non autorisé (JPG, PNG, GIF uniquement).";
            header("Location: /upload");
            exit();
        }

        // Vérification taille du fichier
        if ($file['size'] > $maxSize) {
            $_SESSION['error'] = "Fichier trop volumineux (5MB max).";
            header("Location: /upload");
            exit();
        }

        // Vérification extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $_SESSION['error'] = "Extension non valide.";
            header("Location: /upload");
            exit();
        }

        // Génération nom unique
        $filename = uniqid() . '.' . $ext;
        $filePath = $uploadDir . $filename;

        // Création dossier d'upload
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Déplace fichier
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            require_once 'models/Photo.php';
            $photo = new Photo();
            $photo->savePhoto($_SESSION['user_id'], $filename);

            $_SESSION['success'] = "Photo uploadée avec succès !";
        } else {
            $_SESSION['error'] = "Erreur lors du déplacement du fichier.";
        }

        header("Location: /upload");
        exit();
    }
}
?>
