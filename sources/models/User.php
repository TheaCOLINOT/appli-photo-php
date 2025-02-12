<?php

class User {
    private function __construct(
        public int $id,
        public string $email,
        public string $password,
        public string $nom,
        public string $prenom,
        public ?string $reset_token = null,
        public ?string $token_expiration = null
    ) {}

    public static function create(array $data): bool {
        $db = Database::getInstance();
        $query = $db->prepare("
            INSERT INTO users (nom, prenom, email, password)
            VALUES (:nom, :prenom, :email, :password)
        ");

        return $query->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public static function findOneByEmail(string $email): ?User {
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

    public static function findByResetToken(string $token): ?User {
        $db = Database::getInstance();
        $query = $db->prepare("
            SELECT * FROM users 
            WHERE reset_token = :token 
            AND token_expiration > NOW()
        ");
        $query->execute(['token' => $token]);
        
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

    public function setResetToken(): string {
        $token = bin2hex(random_bytes(32));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $db = Database::getInstance();
        $query = $db->prepare("
            UPDATE users 
            SET reset_token = :token, token_expiration = :expiration 
            WHERE id = :id
        ");
        
        $query->execute([
            'token' => $token,
            'expiration' => $expiration,
            'id' => $this->id
        ]);
        
        return $token;
    }

    public static function resetPassword(string $token, string $password): bool {
        $db = Database::getInstance();
        $query = $db->prepare("
            UPDATE users 
            SET password = :password, reset_token = NULL, token_expiration = NULL
            WHERE reset_token = :token 
            AND token_expiration > NOW()
        ");
        
        return $query->execute([
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'token' => $token
        ]);
    }

    public function isValidPassword(string $password): bool {
        return password_verify($password, $this->password);
    }
}