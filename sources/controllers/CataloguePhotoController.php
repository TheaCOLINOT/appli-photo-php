<?php
class CataloguePhoto {
    public function show($groupId) {
        $photoModel = new PhotoModel();
        $photos = $photoModel->getGroupPhotos($groupId);
        
        require_once __DIR__ . 'views/photo/show.php';
    }
}
?>