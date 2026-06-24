<?php

require_once 'models/Annonce.php';
require_once 'models/Commentaire.php';

class AnnonceController {
    private Annonce $annonceModel;
    private Commentaire $commentaireModel;

    public function __construct(PDO $pdo) {
        $this->annonceModel = new Annonce($pdo);
        $this->commentaireModel = new Commentaire($pdo);
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
        $erreurs = [];
        $succes = false;

        // Formulaire de commentaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['membre_id'])) {
            $commentaire = trim($_POST['commentaire'] ?? '');

            if (empty($commentaire)) {
                $erreurs[] = "Le commentaire ne peut pas être vide.";
            } elseif (strlen($commentaire) < 10) {
                $erreurs[] = "Le commentaire doit faire au moins 10 caractères.";
            } else {
                $result = $this->commentaireModel->create(
                    $_SESSION['membre_id'],
                    $id,
                    $commentaire
                );

                if ($result) {
                    $succes = true;
                    // On recharge les commentaires après ajout
                    $commentaires = $this->commentaireModel->findByAnnonceId($id);
                } else {
                    $erreurs[] = "Une erreur est survenue, veuillez réessayer.";
                }
            }
        }

        // On récupère les commentaires pour cette annonce
        $commentaires = $this->commentaireModel->findByAnnonceId($id);

        require_once 'views/annonce/detail.php';
    }
}