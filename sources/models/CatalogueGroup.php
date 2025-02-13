<?php 


class GroupModel {

    public static function getUserGroups($userId): Array {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT GROUPS.id, GROUPS.name FROM GROUP_USERS,GROUPS WHERE user_id = ? AND GROUPS.id = GROUP_USERS.group_id");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): bool {
        try {
            $db = Database::getInstance();
            $db->beginTransaction(); // Démarre une transaction
    
            // Insérer dans GROUPS
            $query = $db->prepare("
                INSERT INTO GROUPS (owner_id, name, description)
                VALUES (:owner_id, :name, :description)
            ");
    
            $query->execute([
                'owner_id' => $data['owner_id'],
                'name' => $data['name'],
                'description' => $data['description']
            ]);
    
            // Récupérer l'ID du groupe nouvellement inséré
            $groupId = $db->lastInsertId();
            if (!$groupId) {
                $db->rollBack();
                return false;
            }
    
            // Insérer dans GROUP_USERS
            $query = $db->prepare("
                INSERT INTO GROUP_USERS (user_id, group_id, role)
                VALUES (:user_id, :group_id, :role)
            ");
    
            $query->execute([
                'user_id' => $data['owner_id'],
                'group_id' => $groupId,
                'role' => "creator"
            ]);
    
            $db->commit(); // Valide la transaction
            return true;
    
        } catch (PDOException $e) {
            $db->rollBack(); // Annule la transaction en cas d'erreur
            error_log("Erreur lors de la création du groupe : " . $e->getMessage());
            return false;
        }
    }
}
?>