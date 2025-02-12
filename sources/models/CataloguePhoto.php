<?php
class PhotoModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getGroupPhotos($groupId) {
        $stmt = $this->db->prepare("SELECT * FROM photos WHERE group_id = ?");
        $stmt->execute([$groupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>