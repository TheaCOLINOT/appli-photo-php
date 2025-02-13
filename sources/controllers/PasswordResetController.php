<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/PasswordResetToken.php';

class PasswordResetController {

    public static function resetPassword() {
        if (!isset($_POST['token'], $_POST['password'])) {
            die("Requête invalide.");
        }
    
        $token = $_POST['token'];
        $newPassword = $_POST['password'];
    
        // Vérifier la longueur du mot de passe
        if (strlen($newPassword) < 8) {
            die("Le mot de passe doit contenir au moins 8 caractères.");
        }
    
        $email = PasswordResetToken::validateToken($token);
        
        if (!$email) {
            die("Lien expiré ou invalide.");
        }
    
        // Hasher le nouveau mot de passe avant de l'enregistrer
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $email]);
    
        // Supprimer le token utilisé
        PasswordResetToken::deleteToken($token);
    
        echo "Mot de passe mis à jour avec succès. <a href='/login'>Se connecter</a>";
    }
    
}
