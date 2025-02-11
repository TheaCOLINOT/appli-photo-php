<?php 
class GroupModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getUserGroups($userId) {
        $stmt = $this->db->prepare("SELECT * FROM groups WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>