<?php
// controllers/UploadController.php

require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Database.php';

class UploadController {

    /**
     * Redirige vers la page de gestion des photos.
     */
    public static function index(): void {
        if (Session::get('user') === null) {
            header("Location: /login");
            exit;
        }
        // On redirige vers la page combinée d'upload et de gestion
        header("Location: /upload/manage");
        exit;
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
            header("Location: /upload/manage");
            exit;
        }

        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid() . '.' . $ext;

        // Définition d'un chemin absolu pour le dossier d'upload.
        $uploadDir = __DIR__ . '/../uploads';
        // Vérifie si le dossier existe, sinon le crée
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                Session::setFlash('error', "Erreur interne : impossible de créer le dossier d'upload.");
                header("Location: /upload/manage");
                exit;
            }
        }

        // Chemin complet du fichier
        $filePath = $uploadDir . '/' . $filename;

        // Déplacement du fichier temporaire vers le dossier d'upload
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            Session::setFlash('error', "Erreur lors du déplacement du fichier.");
            header("Location: /upload/manage");
            exit;
        }

        // Stocker le chemin relatif pour l'affichage
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
     * Affiche la page combinée : formulaire d'upload et liste des photos personnelles.
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

        // Variable utilisée dans la vue pour afficher le formulaire d'upload
        $canUpload = true;
        require_once __DIR__ . '/../views/upload/manage.php';
    }
}
