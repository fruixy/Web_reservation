<?php

// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'rendez_vous_db';
$username = 'root';
$password = 'root';

try {
    // Création d'une connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fonction pour sécuriser les entrées utilisateur
function securiser($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
