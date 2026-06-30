<?php

require_once 'models/Annonce.php';
require_once 'models/Commentaire.php';
require_once 'models/Categorie.php';
require_once 'models/Note.php';

class AnnonceController {
    private Annonce $annonceModel;
    private Commentaire $commentaireModel;
    private Categorie $categorieModel;
    private Note $noteModel;

    public function __construct(PDO $pdo) {
        $this->annonceModel     = new Annonce($pdo);
        $this->commentaireModel = new Commentaire($pdo);
        $this->categorieModel   = new Categorie($pdo);
        $this->noteModel        = new Note($pdo);
    }

    public function liste(): void {
        $categories = $this->categorieModel->findAll();
        $villes     = $this->annonceModel->findVilles();

        // Récupération des filtres depuis l'URL
        $categorieId = isset($_GET['categorie']) && $_GET['categorie'] !== '' ? (int) $_GET['categorie'] : null;
        $ville       = isset($_GET['ville']) && $_GET['ville'] !== '' ? $_GET['ville'] : null;
        $prixMax     = isset($_GET['prix_max']) && $_GET['prix_max'] !== '' ? (float) $_GET['prix_max'] : null;

        $annonces = $this->annonceModel->findWithFilters($categorieId, $ville, $prixMax);

        require_once 'views/annonce/index.php';
    }

    public function detail(int $id): void {
        $annonce = $this->annonceModel->findById($id);

        if ($annonce === null) {
            echo "Cette annonce n'existe pas.";
            return;
        }

        $erreurs = [];
        $succes = false;
        $succesNote = false;
        $erreursNote = [];

        // Traitement du formulaire de commentaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['membre_id'])) {

            // Formulaire de commentaire
            if (isset($_POST['commentaire'])) {
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
                    } else {
                        $erreurs[] = "Une erreur est survenue, veuillez réessayer.";
                    }
                }
            }

            // Formulaire de note
            if (isset($_POST['note'])) {
                $note = (int) $_POST['note'];
                $avis = trim($_POST['avis'] ?? '');
                $vendeurId = (int) $annonce['membre_id'];

                // On ne peut pas se noter soi-même
                if ($_SESSION['membre_id'] === $vendeurId) {
                    $erreursNote[] = "Vous ne pouvez pas vous noter vous-même.";
                } elseif ($this->noteModel->hasAlreadyNoted($_SESSION['membre_id'], $vendeurId)) {
                    $erreursNote[] = "Vous avez déjà noté ce vendeur.";
                } elseif ($note < 1 || $note > 5) {
                    $erreursNote[] = "La note doit être entre 1 et 5.";
                } else {
                    $result = $this->noteModel->create($_SESSION['membre_id'], $vendeurId, $note, $avis);
                    if ($result) {
                        $succesNote = true;
                    } else {
                        $erreursNote[] = "Une erreur est survenue, veuillez réessayer.";
                    }
                }
            }
        }

        $commentaires     = $this->commentaireModel->findByAnnonceId($id);
        $noteMoyenne      = $this->noteModel->getNoteMoyenne($annonce['membre_id']);
        $avis             = $this->noteModel->findAvisByMembreId($annonce['membre_id']);
        $dejaNote         = isset($_SESSION['membre_id']) 
                            ? $this->noteModel->hasAlreadyNoted($_SESSION['membre_id'], $annonce['membre_id']) 
                            : false;

        require_once 'views/annonce/detail.php';
    }

    public function creer(): void {
        if (!isset($_SESSION['membre_id'])) {
            header('Location: /petites-annonces/?page=connexion');
            exit;
        }

        $categories = $this->categorieModel->findAll();
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre             = trim($_POST['titre'] ?? '');
            $descriptionCourte = trim($_POST['description_courte'] ?? '');
            $descriptionLongue = trim($_POST['description_longue'] ?? '');
            $prix              = (float) ($_POST['prix'] ?? 0);
            $pays              = trim($_POST['pays'] ?? 'France');
            $ville             = trim($_POST['ville'] ?? '');
            $adresse           = trim($_POST['adresse'] ?? '');
            $cp                = (int) ($_POST['cp'] ?? 0);
            $categorieId       = (int) ($_POST['categorie_id'] ?? 0);

            if (empty($titre)) $erreurs[] = "Le titre est obligatoire.";
            if (empty($descriptionCourte)) $erreurs[] = "La description courte est obligatoire.";
            if ($prix <= 0) $erreurs[] = "Le prix doit être supérieur à 0.";
            if (empty($ville)) $erreurs[] = "La ville est obligatoire.";
            if ($categorieId === 0) $erreurs[] = "La catégorie est obligatoire.";

            $photo = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $nomFichier   = basename($_FILES['photo']['name']);
                $extension    = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
                $extensionsOk = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($extension, $extensionsOk)) {
                    $erreurs[] = "Format de photo non accepté (jpg, jpeg, png, webp uniquement).";
                } else {
                    $nomUnique   = uniqid() . '.' . $extension;
                    $destination = 'img/' . $nomUnique;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                        $photo = $destination;
                    } else {
                        $erreurs[] = "Erreur lors de l'upload de la photo.";
                    }
                }
            }

            if (empty($erreurs)) {
                $succes = $this->annonceModel->create(
                    $titre, $descriptionCourte, $descriptionLongue, $prix,
                    $photo, $pays, $ville, $adresse, $cp,
                    $_SESSION['membre_id'], $categorieId
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