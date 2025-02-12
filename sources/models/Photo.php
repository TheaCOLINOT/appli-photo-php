<?php

class Photo {
    private function __construct(
        public int $id,
        public string $path,
        public string $date
    ) {}

    public static function upload(array $data): bool {
        $db = Database::getInstance();
        $query = $db->prepare("
            INSERT INTO photos (user_id, path)
            VALUES (:user_id, :path)
        ");

        return $query->execute([
            'user_id' => $data['user_id'],
            'path' => $data['path']
        ]);
    }


    public static function getAllByUser(int $userid): ?Array {
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


    public static function findByGroup(string $group): ?User {
        $db = Database::getInstance();
        $query = $db->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        
        if ($user = $query->fetch()) {
            return new User(
                $user['id'],
                $user['email'],
                $user['password'],
                $user['nom'],
                $user['prenom'],
                $user['reset_token'],
                $user['token_expiration']
            );
        }
        return null;
    }
}