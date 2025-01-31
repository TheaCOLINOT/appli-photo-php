<?php

require_once 'Database.php';

class Photo {
    public function savePhoto($userId, $filename) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO photos (user_id, filename, uploaded_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$userId, $filename]);
    }
}
?>
