<?php

// require_once '../../models/Annonce.php';
// require_once '../../models/Membre.php';
// require_once '../../models/Categorie.php';
// require_once '../../models/Commentaire.php';

require_once __DIR__ . '/../../models/Annonce.php';
require_once __DIR__ . '/../../models/Membre.php';
require_once __DIR__ . '/../../models/Categorie.php';
require_once __DIR__ . '/../../models/Commentaire.php';

class AdminAnnonceController {
    private Annonce $annonceModel;
    private Membre $membreModel;
    private Categorie $categorieModel;
    private Commentaire $commentaireModel;

    public function __construct(PDO $pdo) {
        $this->annonceModel     = new Annonce($pdo);
        $this->membreModel      = new Membre($pdo);
        $this->categorieModel   = new Categorie($pdo);
        $this->commentaireModel = new Commentaire($pdo);
    }

    // Vérifie que l'utilisateur est admin
    private function checkAdmin(): void {
        if (!isset($_SESSION['membre_id']) || $_SESSION['statut'] !== 'admin') {
            header('Location: /petites-annonces/');
            exit;
        }
    }

    // Dashboard admin — liste des annonces
    public function index(): void {
        $this->checkAdmin();
        $annonces = $this->annonceModel->findAll();
		$membres = $this->membreModel->findAll();
		$categories = $this->categorieModel->findAll();
		$commentaires = $this->commentaireModel->findAll();
        require_once 'views/admin/index.php';
    }

    // Éditer un membre
    public function editerMembre(int $id): void {
        $this->checkAdmin();

        $membre  = $this->membreModel->findById($id);
        $erreurs = [];

        if ($membre === null) {
            header('Location: /petites-annonces/?page=admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo    = trim($_POST['pseudo'] ?? '');
            $nom       = trim($_POST['nom'] ?? '');
            $prenom    = trim($_POST['prenom'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $civilite  = trim($_POST['civilite'] ?? '');
            $statut    = trim($_POST['statut'] ?? '');

            if (empty($pseudo))  $erreurs[] = "Le pseudo est obligatoire.";
            if (empty($nom))     $erreurs[] = "Le nom est obligatoire.";
            if (empty($prenom))  $erreurs[] = "Le prénom est obligatoire.";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = "L'email n'est pas valide.";

            if (empty($erreurs)) {
                $succes = $this->membreModel->update($id, $pseudo, $nom, $prenom, $email, $telephone, $civilite, $statut);

                if ($succes) {
                    header('Location: /petites-annonces/?page=admin');
                    exit;
                } else {
                    $erreurs[] = "Une erreur est survenue, veuillez réessayer.";
                }
            }
        }

        require_once 'views/admin/membre/edit.php';
    }

    // Supprimer une annonce
    public function supprimerAnnonce(int $id): void {
        $this->checkAdmin();
        $this->annonceModel->delete($id);
        header('Location: /petites-annonces/?page=admin');
        exit;
    }
	// Supprimer un membre
    public function supprimerMembre(int $id): void {
        $this->checkAdmin();
        $this->membreModel->delete($id);
        header('Location: /petites-annonces/?page=admin');
        exit;
    }
    // Supprimer un commentaire
    public function supprimerCommentaire(int $id): void {
        $this->checkAdmin();
        $this->commentaireModel->delete($id);
        header('Location: /petites-annonces/?page=admin');
        exit;
    }
}