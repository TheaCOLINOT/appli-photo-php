<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/PasswordResetToken.php';
require_once __DIR__ . '/../core/MailService.php';

class MailController {
    
    public static function sendResetLink() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);

            // Vérifier si l'utilisateur existe
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                $token = PasswordResetToken::createToken($email);
                MailService::sendPasswordResetEmail($email, $token);
                echo "Un email de réinitialisation a été envoyé.";
            } else {
                echo "Adresse email non trouvée.";
            }
        }
    }
}
