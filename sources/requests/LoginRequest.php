<?php
// requests/LoginRequest.php

class LoginRequest {
    public static function validate(array $data): array {
        $errors = [];

        // Nettoyage et validation de l'email
        $email = trim($data['email'] ?? '');
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Un email valide est requis.";
        }

        // Nettoyage et validation du mot de passe
        $password = trim($data['password'] ?? '');
        if (empty($password)) {
            $errors['password'] = "Le mot de passe est requis.";
        }

        return $errors;
    }
}
?>
