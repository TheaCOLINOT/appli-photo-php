<?php
try {
    // Connexion à la base de données
    $databaseConnection = new PDO(
        "mysql:host=mariadb;dbname=database;charset=utf8mb4",
        "user",
        "password",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Création de la table password_reset_tokens
    $sql = "
        CREATE TABLE IF NOT EXISTS password_reset_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $databaseConnection->exec($sql);

    echo "Migration 0003 : Table password_reset_tokens créée avec succès.\n";
} catch (PDOException $e) {
    echo "Erreur lors de la migration 0003 : " . $e->getMessage();
}
