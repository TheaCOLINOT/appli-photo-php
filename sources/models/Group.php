<?php
// models/Group.php
require_once __DIR__ . '/../core/Database.php';

class Group
{
    public int $id;
    public string $name;
    public int $owner_id;
    public string $created_at;

    public function __construct(int $id, string $name, int $owner_id, string $created_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->created_at = $created_at;
    }

    /**
     * Crée un groupe et insère le propriétaire dans group_users avec le rôle "write".
     */
    public static function create(array $data): ?Group
    {
        $db = Database::getInstance();
        $query = $db->prepare("INSERT INTO groups (name, owner_id) VALUES (:name, :owner_id)");
        if ($query->execute([
            'name'     => $data['name'],
            'owner_id' => $data['owner_id']
        ])) {
            $groupId = $db->lastInsertId();
            
            self::addUser($groupId, $data['owner_id'], 'write');
            return self::getById($groupId);
        }
        return null;
    }


    public static function getById(int $id): ?Group
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM groups WHERE id = :id");
        $stmt->execute(['id' => $id]);
        if ($group = $stmt->fetch()) {
            return new Group($group['id'], $group['name'], $group['owner_id'], $group['created_at']);
        }
        return null;
    }

    public static function getByName(string $name): ?Group 
    {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT * FROM groups WHERE name = :name");
        $query->execute(['name' => $name]);
        if ($group = $query->fetch()) {
            return new Group($group['id'], $group['name'], $group['owner_id'], $group['created_at']);
        }
        return null;
    }
    

    public static function getMembers(int $groupId): array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM group_users WHERE group_id = :group_id");
        $stmt->execute(['group_id' => $groupId]);
        return $stmt->fetchAll();
    }

    public static function addUser(int $groupId, int $userId, string $role = 'read'): bool
    {
        $db = Database::getInstance();
    
        // Vérifier si l'utilisateur est déjà membre du groupe
        $stmt = $db->prepare("SELECT COUNT(*) FROM group_users WHERE group_id = :group_id AND user_id = :user_id");
        $stmt->execute([
            'group_id' => $groupId,
            'user_id'  => $userId,
        ]);
    
        if ($stmt->fetchColumn() > 0) {
            // L'utilisateur est déjà dans le groupe : on peut retourner false ou lancer une exception
            // return false;
            throw new Exception("L'utilisateur est déjà membre de ce groupe.");
        }
    
        // Insertion du nouvel enregistrement si la combinaison n'existe pas
        $stmt = $db->prepare("INSERT INTO group_users (group_id, user_id, role) VALUES (:group_id, :user_id, :role)");
        return $stmt->execute([
            'group_id' => $groupId,
            'user_id'  => $userId,
            'role'     => $role,
        ]);
    }
    

    public static function removeUser(int $groupId, int $userId): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM group_users WHERE group_id = :group_id AND user_id = :user_id");
        return $stmt->execute(['group_id' => $groupId, 'user_id' => $userId]);
    }

    public static function delete(int $groupId): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM groups WHERE id = :id");
        return $stmt->execute(['id' => $groupId]);
    }
}
