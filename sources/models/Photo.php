<?php
// /models/Photo.php

class Photo {
    public int $id;
    public int $user_id;
    public ?int $group_id;
    public string $path;
    public string $date;
    public ?string $share_token;
    public string $visibility;

    public function __construct($data) {
        $this->id          = $data['id'];
        $this->user_id     = $data['user_id'];
        $this->group_id    = $data['group_id'];
        $this->path        = $data['path'];
        $this->date        = $data['date'];
        $this->share_token = $data['share_token'];
        $this->visibility  = $data['visibility'];
    }

    public static function upload(array $data): bool {
        $db = Database::getInstance();
        $query = $db->prepare("INSERT INTO photos (user_id, path, group_id) VALUES (:user_id, :path, :group_id)");
        return $query->execute([
            'user_id'  => $data['user_id'],
            'path'     => $data['path'],
            'group_id' => $data['group_id'] ?? null
        ]);
    }

    public static function delete(int $photoId, int $currentUserId): bool {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT * FROM photos WHERE id = :id");
        $query->execute(['id' => $photoId]);
        $photo = $query->fetch();
        if (!$photo) {
            return false;
        }
        // Autoriser la suppression si l'utilisateur est l'auteur ou le propriétaire du groupe
        if ($photo['user_id'] != $currentUserId) {
            if (!empty($photo['group_id'])) {
                $group = Group::getById($photo['group_id']);
                if ($group && $group->owner_id != $currentUserId) {
                    return false;
                }
            } else {
                return false;
            }
        }
        if (file_exists($photo['path'])) {
            unlink($photo['path']);
        }
        $query = $db->prepare("DELETE FROM photos WHERE id = :id");
        return $query->execute(['id' => $photoId]);
    }

    public static function sharePublic(int $photoId, int $currentUserId): ?string {
        $db = Database::getInstance();
        
        // Récupérer la photo
        $stmt = $db->prepare("SELECT * FROM photos WHERE id = :id");
        $stmt->execute(['id' => $photoId]);
        $photo = $stmt->fetch();
        if (!$photo) {
            return null;
        }
        
        // Vérifier les droits (ici, on suppose que seul l'auteur ou le propriétaire du groupe peut partager)
 
        if ($photo['user_id'] != $currentUserId) {
            return null;
        }
        
        // Générer un token unique (par exemple, 32 caractères hexadécimaux)
        $token = bin2hex(random_bytes(16));
        
        // Mettre à jour la photo pour la rendre publique et stocker le token
        $stmt = $db->prepare("UPDATE photos SET share_token = :token, visibility = 'public' WHERE id = :id");
        if ($stmt->execute(['token' => $token, 'id' => $photoId])) {
            return $token;
        }
        return null;
    }
}
