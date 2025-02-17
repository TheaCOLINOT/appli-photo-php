<?php
class RegisterRequest {
    public static function validate(array $data): array {
        $errors = [];
        if (empty($data['nom'])) {
            $errors['nom'] = "Le nom est requis.";
        }
        if (empty($data['prenom'])) {
            $errors['prenom'] = "Le prénom est requis.";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Un email valide est requis.";
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
        }
        if (empty($data['password_confirmation'])) {
            $errors['password_confirmation'] = "La confirmation du mot de passe est requise.";
        } elseif ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = "Les mots de passe ne correspondent pas.";
        }
        return $errors;
    }
}
