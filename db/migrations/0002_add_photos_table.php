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

    // 1. Création de la table groups
    $sql = "
        CREATE TABLE IF NOT EXISTS groups (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            owner_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_group_owner FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $databaseConnection->exec($sql);

    // 2. Création de la table group_users
    $sql = "
        CREATE TABLE IF NOT EXISTS group_users (
            group_id INT NOT NULL,
            user_id INT NOT NULL,
            role ENUM('read', 'write') DEFAULT 'read',
            PRIMARY KEY (group_id, user_id),
            CONSTRAINT fk_group FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
            CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $databaseConnection->exec($sql);

    // 3. Vérification avant d'ajouter la colonne `group_id` à la table photos
    $checkColumnQuery = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'photos' AND COLUMN_NAME = 'group_id'";
    $columnExists = $databaseConnection->query($checkColumnQuery)->fetchColumn();

    if (!$columnExists) {
        $sql = "ALTER TABLE photos ADD COLUMN group_id INT DEFAULT NULL;";
        $databaseConnection->exec($sql);
        $sql = "ALTER TABLE photos ADD CONSTRAINT fk_photo_group FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE SET NULL;";
        $databaseConnection->exec($sql);
    } else {
        echo "La colonne group_id existe déjà dans la table photos. Aucune modification nécessaire.\n";
    }

    // 4. Vérification avant d'ajouter les colonnes `share_token` et `visibility`
    $checkShareToken = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'photos' AND COLUMN_NAME = 'share_token'";
    $shareTokenExists = $databaseConnection->query($checkShareToken)->fetchColumn();

    if (!$shareTokenExists) {
        $sql = "ALTER TABLE photos ADD COLUMN share_token VARCHAR(255) DEFAULT NULL;";
        $databaseConnection->exec($sql);
    }

    $checkVisibility = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'photos' AND COLUMN_NAME = 'visibility'";
    $visibilityExists = $databaseConnection->query($checkVisibility)->fetchColumn();

    if (!$visibilityExists) {
        $sql = "ALTER TABLE photos ADD COLUMN visibility ENUM('public', 'group') DEFAULT 'group';";
        $databaseConnection->exec($sql);
    }

    echo "Migration 0002 exécutée avec succès.\n";
} catch (PDOException $e) {
    echo "Erreur lors de la migration 0002 : " . $e->getMessage();
}
