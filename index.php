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

// On regarde ce qu'il y a dans l'URL pour savoir quoi afficher
$page = $_GET['page'] ?? 'accueil';

if ($page === 'annonce' && isset($_GET['id'])) {
    // Affiche le détail d'une annonce précise
    $controller->detail((int) $_GET['id']);
} else {
    // Par défaut, affiche la liste des annonces
    $controller->liste();
}
