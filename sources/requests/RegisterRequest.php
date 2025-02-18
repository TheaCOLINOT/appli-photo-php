<?php
// requests/RegisterRequest.php

class RegisterRequest {
    public static function validate(array $data): array {
        $errors = [];

        // Nettoyage et validation du nom
        $nom = trim($data['nom'] ?? '');
        if (empty($nom) || !preg_match("/^[a-zA-ZÀ-ÿ '-]+$/", $nom)) {
            $errors['nom'] = "Le nom est requis et ne doit contenir que des lettres.";
        }

        // Nettoyage et validation du prénom
        $prenom = trim($data['prenom'] ?? '');
        if (empty($prenom) || !preg_match("/^[a-zA-ZÀ-ÿ '-]+$/", $prenom)) {
            $errors['prenom'] = "Le prénom est requis et ne doit contenir que des lettres.";
        }

        // Nettoyage et validation de l'email
        $email = trim($data['email'] ?? '');
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Un email valide est requis.";
        }

        // Vérification que l'email est unique en base de données
        if (self::emailExists($email)) {
            $errors['email'] = "Cet email est déjà utilisé.";
        }

        // Validation du mot de passe (min 8 caractères, 1 lettre et 1 chiffre)
        $password = trim($data['password'] ?? '');
        if (empty($password) || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{12,}$/", $password)) {
            $errors['password'] = "Le mot de passe doit contenir au moins 12 caractères, une lettre, un chiffre et un caractère spécial.";
        }

        // Validation de la confirmation du mot de passe
        $passwordConfirmation = trim($data['password_confirmation'] ?? '');
        if (empty($passwordConfirmation)) {
            $errors['password_confirmation'] = "La confirmation du mot de passe est requise.";
        } elseif ($password !== $passwordConfirmation) {
            $errors['password_confirmation'] = "Les mots de passe ne correspondent pas.";
        }

        return $errors;
    }

    // Vérifie si l'email existe déjà en base de données
    private static function emailExists(string $email): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}
?>
