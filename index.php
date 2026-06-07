<?php
// On charge le fichier .env manuellement avec les variables d'environnement
$env = parse_ini_file('.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

// Chargement des classes
require_once 'config/Database.php';
require_once 'controllers/AnnonceController.php';

// On crée la connexion à la BDD
$database = new Database();
$pdo = $database->getConnection();

// TEST : on récupère toutes les annonces
// $stmt = $pdo->query("SELECT * FROM annonce");
// $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
// On affiche pour vérifier (variable de débogage var_dump)
// var_dump($annonces);


// On appelle le contrôleur
$controller = new AnnonceController($pdo);
$controller->liste();
