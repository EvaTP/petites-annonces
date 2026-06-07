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
}