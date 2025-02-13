<?php

class Photo {
    private function __construct(
        public int $id,
        public string $path,
        public string $date
    ) {}

    public static function upload(array $data): bool {
        try {
            $db = Database::getInstance();
            $db->beginTransaction(); // Démarre une transaction
    
            // Insérer dans GROUPS
            $query = $db->prepare("
                INSERT INTO photos (user_id, path)
                VALUES (:user_id, :path)
            ");
    
            $query->execute([
                'user_id' => $data['user_id'],
                'path' => $data['path']
            ]);
    
            // Récupérer l'ID du groupe nouvellement inséré
            $photoId = $db->lastInsertId();
            if (!$photoId) {
                $db->rollBack();
                return false;
            }
    
            
            // Insérer dans GROUP_USERS
            if($data != null){
                $query = $db->prepare("
                    INSERT INTO GROUPS_TO_PHOTOS (id_group, id_photo)
                    VALUES (:id_group, :id_photo)
                ");
        
                $query->execute([
                    'id_group' => $data['user_id'],
                    'id_photo' => $photoId,
                ]);
            }
    
            $db->commit(); // Valide la transaction
            return true;

        } catch (PDOException $e) {
            $db->rollBack(); // Annule la transaction en cas d'erreur
            error_log("Erreur lors de la création du groupe : " . $e->getMessage());
            return false;
        }
    }


    public static function getAllByUser(int $userid): Array {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT id, path, date FROM photos WHERE user_id = :userid");
        $query->execute(['userid' => $userid]);
        
        if ($photos = $query->fetchAll(PDO::FETCH_ASSOC)) {
            $result = Array();
            foreach($photos as $photo){
                array_push(
                    $result,
                    [
                        'id' => $photo['id'],
                        'path' => $photo['path'],
                        'date' => $photo['date']
                    ]
                );
            }
            return $result;
        }
        return null;
    }


    public static function getAllByGroup(string $group): Array {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT photos.id, photos.path, photos.date FROM photos, GROUPS_TO_PHOTOS WHERE GROUPS_TO_PHOTOS.id_photo = photos.id AND GROUPS_TO_PHOTOS.id_group = :group");
        $query->execute(['group' => $group]);
        
        if ($photos = $query->fetchAll(PDO::FETCH_ASSOC)) {
            $result = Array();
            foreach($photos as $photo){
                array_push(
                    $result,
                    [
                        'id' => $photo['id'],
                        'path' => $photo['path'],
                        'date' => $photo['date']
                    ]
                );
            }
            return $result;
        }
        return [];
    }
}