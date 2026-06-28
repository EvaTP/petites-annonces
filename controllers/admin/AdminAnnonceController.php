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
        require_once 'views/admin/annonce/index.php';
    }

    // Supprimer une annonce
    public function supprimer(int $id): void {
        $this->checkAdmin();
        $this->annonceModel->delete($id);
        header('Location: /petites-annonces/?page=admin');
        exit;
    }
}