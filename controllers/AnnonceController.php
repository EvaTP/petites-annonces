<?php

require_once 'models/Annonce.php';
require_once 'models/Commentaire.php';
require_once 'models/Categorie.php';

class AnnonceController {
    private Annonce $annonceModel;
    private Commentaire $commentaireModel;
    private Categorie $categorieModel;

    public function __construct(PDO $pdo) {
        $this->annonceModel = new Annonce($pdo);
        $this->commentaireModel = new Commentaire($pdo);
        $this->categorieModel = new Categorie($pdo);
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

    // Méthode pour créer une annonce
    public function creer(): void {
        // Protection : membre connecté uniquement
        if (!isset($_SESSION['membre_id'])) {
            header('Location: /petites-annonces/?page=connexion');
            exit;
        }

        $categories = $this->categorieModel->findAll();
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $titre             = trim($_POST['titre'] ?? '');
            $descriptionCourte = trim($_POST['description_courte'] ?? '');
            $descriptionLongue = trim($_POST['description_longue'] ?? '');
            $prix              = (float) ($_POST['prix'] ?? 0);
            $pays              = trim($_POST['pays'] ?? 'France');
            $ville             = trim($_POST['ville'] ?? '');
            $adresse           = trim($_POST['adresse'] ?? '');
            $cp                = (int) ($_POST['cp'] ?? 0);
            $categorieId       = (int) ($_POST['categorie_id'] ?? 0);

            // Validations
            if (empty($titre)) {
                $erreurs[] = "Le titre est obligatoire.";
            }
            if (empty($descriptionCourte)) {
                $erreurs[] = "La description courte est obligatoire.";
            }
            if ($prix <= 0) {
                $erreurs[] = "Le prix doit être supérieur à 0.";
            }
            if (empty($ville)) {
                $erreurs[] = "La ville est obligatoire.";
            }
            if ($categorieId === 0) {
                $erreurs[] = "La catégorie est obligatoire.";
            }

            // Gestion de l'upload de photo
            $photo = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $nomFichier    = basename($_FILES['photo']['name']);
                $extension     = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
                $extensionsOk  = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $extensionsOk)) {
                    $erreurs[] = "Format de photo non accepté (jpg, jpeg, png, webp uniquement).";
                } else {
                    $nomUnique = uniqid() . '.' . $extension;
                    $destination = 'img/' . $nomUnique;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                        $photo = $destination;
                    } else {
                        $erreurs[] = "Erreur lors de l'upload de la photo.";
                    }
                }
            }

            // Si pas d'erreurs on crée l'annonce
            if (empty($erreurs)) {
                $succes = $this->annonceModel->create(
                    $titre,
                    $descriptionCourte,
                    $descriptionLongue,
                    $prix,
                    $photo,
                    $pays,
                    $ville,
                    $adresse,
                    $cp,
                    $_SESSION['membre_id'],
                    $categorieId
                );

                if ($succes) {
                    header('Location: /petites-annonces/');
                    exit;
                } else {
                    $erreurs[] = "Une erreur est survenue, veuillez réessayer.";
                }
            }
        }

        require_once 'views/annonce/create.php';
    }
}