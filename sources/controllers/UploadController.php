<?php
// controllers/UploadController.php

require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Database.php';

class UploadController {
    
    /**
     * Affiche le formulaire d'upload.
     */
    public static function index(): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        require_once __DIR__ . '/../views/upload/index.php';
    }
    
    /**
     * Gère l'upload d'une photo personnelle.
     */
    public static function upload(): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['photo'])) {
            Session::setFlash('error', "Aucun fichier envoyé.");
            header("Location: /upload");
            exit;
        }
        
        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '.' . $ext;
        
        // Définition d'un chemin absolu pour le dossier d'upload.
        // __DIR__ retourne le dossier "controllers", on remonte donc d'un cran.
        $uploadDir = __DIR__ . '/../uploads';
        // On vérifie si le dossier existe, sinon on le crée
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                Session::setFlash('error', "Erreur interne : impossible de créer le dossier d'upload.");
                header("Location: /upload");
                exit;
            }
        }
        
        // On construit le chemin complet du fichier
        $filePath = $uploadDir . '/' . $filename;
        
        // On tente de déplacer le fichier temporaire vers le dossier d'upload
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            Session::setFlash('error', "Erreur lors du déplacement du fichier.");
            header("Location: /upload");
            exit;
        }
        
        // Stocker le chemin relatif (pour l'affichage) ou le chemin absolu selon votre besoin.
        // Ici, nous stockons "uploads/filename" pour pouvoir l'utiliser dans les URLs.
        $relativePath = "uploads/" . $filename;
        
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO photos (user_id, path) VALUES (:user_id, :path)");
        if ($stmt->execute(['user_id' => Session::get('user')['id'], 'path' => $relativePath])) {
            Session::setFlash('success', "Photo uploadée avec succès !");
        } else {
            Session::setFlash('error', "Erreur lors de l'enregistrement de la photo.");
        }
        header("Location: /upload/manage");
        exit;
    }
    
    /**
     * Affiche la liste des photos personnelles de l'utilisateur.
     */
    public static function manage(): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM photos WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => Session::get('user')['id']]);
        $photos = $stmt->fetchAll();
        require_once __DIR__ . '/../views/upload/manage.php';
    }
}
