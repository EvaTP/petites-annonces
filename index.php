<?php
session_start();

// On charge le fichier .env manuellement avec les variables d'environnement
$env = parse_ini_file('.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

// Chargement des classes
require_once 'config/Database.php';
require_once 'controllers/AnnonceController.php';
require_once 'controllers/MembreController.php';
require_once 'controllers/admin/AdminAnnonceController.php';

// Connexion à la BDD
$database = new Database();
$pdo = $database->getConnection();

// On crée les contrôleurs
$annonceController = new AnnonceController($pdo);
$membreController  = new MembreController($pdo);
$adminAnnonceController = new AdminAnnonceController($pdo);

// Routeur — on regarde l'URL pour savoir quoi afficher
$page = $_GET['page'] ?? 'accueil';

switch ($page) {
    case 'annonce':
        $annonceController->detail((int) $_GET['id']);
        break;
    case 'inscription':
        $membreController->inscription();
        break;
    case 'connexion':
        $membreController->connexion();
        break;
    case 'deconnexion':
        $membreController->deconnexion();
        break;
    case 'profil':
        $membreController->profil();
        break;
    case 'creer-annonce':
        $annonceController->creer();
        break;
    case 'admin':
        $adminAnnonceController->index();
        break;
    case 'admin-supprimer-annonce':
        $adminAnnonceController->supprimerAnnonce((int) $_GET['id']);
        break;
    case 'admin-editer-membre':
        $adminAnnonceController->editerMembre((int) $_GET['id']);
        break;    
    case 'admin-supprimer-membre':
        $adminAnnonceController->supprimerMembre((int) $_GET['id']);
        break;
    case 'admin-supprimer-commentaire':
        $adminAnnonceController->supprimerCommentaire((int) $_GET['id']);
        break;
    case 'profil-public':
        $membreController->profilPublic((int) $_GET['id']);
        break;
    default:
        $annonceController->liste();
        break;
}



// TEST : on récupère toutes les annonces
// $stmt = $pdo->query("SELECT * FROM annonce");
// $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
// On affiche pour vérifier (variable de débogage var_dump)
// var_dump($annonces);


// On regarde ce qu'il y a dans l'URL pour savoir quoi afficher
// $page = $_GET['page'] ?? 'accueil';

// if ($page === 'annonce' && isset($_GET['id'])) {
//      Affiche le détail d'une annonce précise
//     $controller->detail((int) $_GET['id']);
// } else {
//      Par défaut, affiche la liste des annonces
//     $controller->liste();
// }
