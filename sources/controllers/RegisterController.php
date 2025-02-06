<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../requests/RegisterRequest.php';

class RegisterController {
    public static function index() {
        require_once __DIR__ . '/../views/register/index.php';
    }

    public static function post() {
        $errors = RegisterRequest::validate($_POST);
        if (!empty($errors)) {
            Session::setErrors($errors);
            Session::setOldInput($_POST);
            header("Location: /register");
            exit;
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            $databaseConnection = new PDO(
                "mysql:host=mariadb;dbname=database;charset=utf8mb4",
                "user",
                "password",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $stmt = $databaseConnection->prepare("INSERT INTO users (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)");
            $stmt->execute([
                'nom'      => $_POST['nom'],
                'prenom'   => $_POST['prenom'],
                'email'    => $_POST['email'],
                'password' => $hashedPassword
            ]);

            Session::setFlash('success', "Inscription réussie ! Vous pouvez maintenant vous connecter.");
            header("Location: /login");
            exit;

        } catch (PDOException $e) {
            // Vous pouvez ajouter un log ou afficher une erreur appropriée
            die("Erreur lors de l'inscription : " . $e->getMessage());
        }
    }
}
