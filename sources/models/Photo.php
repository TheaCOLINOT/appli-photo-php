<?php

class Photo {
    private function __construct(
        public int $user_id,
        public string $path
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

}