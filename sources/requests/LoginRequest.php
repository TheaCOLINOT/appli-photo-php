<?php
// requests/LoginRequest.php

class LoginRequest {
    public static function validate(array $data): array {
        $errors = [];
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Un email valide est requis.";
        }
        if (empty($data['password'])) {
            $errors['password'] = "Le mot de passe est requis.";
        }
        return $errors;
    }
}
