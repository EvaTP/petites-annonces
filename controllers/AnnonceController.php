<?php

require_once 'models/Annonce.php';

class AnnonceController {
    private Annonce $annonceModel;

    public function __construct(PDO $pdo) {
        $this->annonceModel = new Annonce($pdo);
    }

    public function liste(): void {
        // On récupère les annonces via le modèle
        $annonces = $this->annonceModel->findAll();

        // On envoie les données à la vue
		require_once 'views/annonce/index.php';
    }

    public function detail(int $id): void {
        // On récupère une annonce via le modèle
        $annonce = $this->annonceModel->findById($id);

        // Si l'annonce n'existe pas, on affiche un message d'erreur
        if ($annonce === null) {
            echo "Cette annonce n'existe pas.";
            return;
        }

        require_once 'views/annonce/detail.php';
    }
}