<?php
require_once __DIR__ . '/../core/Database.php';

class PasswordResetToken {

    public static function createToken($email) {
        $pdo = Database::getInstance();
        $token = bin2hex(random_bytes(50)); 
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour')); // Expiration dans 1 heure

        // Supprimer d'abord l'ancien token s'il existe
        $stmt = $pdo->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
        $stmt->execute([$email]);

        // Insérer le nouveau token
        $stmt = $pdo->prepare("INSERT INTO password_reset_tokens (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expiresAt]);

        return $token;
    }

    public static function validateToken($token) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT email FROM password_reset_tokens WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetchColumn();
    }

    public static function deleteToken($token) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
        $stmt->execute([$token]);
    }
}
