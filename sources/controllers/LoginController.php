<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../requests/LoginRequest.php';
require_once __DIR__ . '/../core/Database.php';

class LoginController {
    public static function index() {
        require_once __DIR__ . '/../views/login/index.php';
    }
    public static function showPasswordResetForm() {
        require_once __DIR__ . '/../views/login/password_reset_request.php';
    }

    public static function showResetPasswordForm() {
        require_once __DIR__ . '/../views/login/reset_password.php';
    }
    

    public static function post() {
        $errors = LoginRequest::validate($_POST);
        if (!empty($errors)) {
            Session::setErrors($errors);
            Session::setOldInput($_POST);
            header("Location: /login");
            exit;
        }

        $user = User::findOneByEmail($_POST['email']);
        if ($user && $user->isValidPassword($_POST['password'])) {
            // Pour renforcer la sécurité, régénérer l'ID de session pour éviter la fixation de session
            session_regenerate_id(true);

            // Vous pouvez générer un token de session pour une vérification additionnelle si nécessaire
            $sessionToken = bin2hex(random_bytes(16));

            Session::set('user', [
                'id'      => $user->id,
                'prenom'  => $user->prenom, // Assurez-vous que ce champ existe dans votre table users
                'email'   => $user->email,
                'token'   => $sessionToken
            ]);
            header("Location: /");
            exit;
        } else {
            Session::setErrors(['auth' => "Email ou mot de passe incorrect."]);
            header("Location: /login");
            exit;
        }
    }
}
