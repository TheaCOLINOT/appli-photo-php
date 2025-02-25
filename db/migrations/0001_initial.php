<?php
try {
    // Connexion à la base via PDO 
    $databaseConnection = new PDO(
        "mysql:host=mariadb;dbname=database;charset=utf8mb4",
        "user",
        "password",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Requête de création des tables
    $sql = "
      CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_token VARCHAR(255) DEFAULT NULL,
        token_expiration DATETIME DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

      CREATE TABLE IF NOT EXISTS photos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        path VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $databaseConnection->exec($sql);
    echo "Les tables ont été créées avec succès.\n";
} catch (PDOException $e) {
    echo "Erreur lors de la création des tables : " . $e->getMessage();
}
