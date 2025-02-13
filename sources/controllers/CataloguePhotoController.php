<?php

require_once __DIR__.'/../models/Photo.php';

class CataloguePhoto {

    public static function index($slug = null): void
    {
        // Vérification de connexion
        if (Session::get('user') == null) {
            $_SESSION['error'] = "Vous devez être connecté pour uploader une photo.";
            header("Location: /login");
            exit();
        }

        if(empty($slug)) {
            $photos = Photo::getAllByUser(Session::get('user')['id']);
        } else {
            $photos = Photo::getAllByGroup(htmlspecialchars($slug));
        }

        require_once __DIR__ . '/../views/catalogs/photos/index.php';
    }

    public function showByGroup() {
        $groupID = $slug;
        
        $photos = $photoModel->getGroupPhotos($groupId);
        
        require_once __DIR__ . 'views/photo/show.php';
    }
}
?>