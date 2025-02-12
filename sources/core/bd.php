<?php
$host = "mariadb";
$dbname = getenv('DATABASE_NAME');
$user = getenv('DATABASE_USER');
$pass = getenv('DATABASE_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}
?>
