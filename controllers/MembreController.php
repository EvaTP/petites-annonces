<?php

require_once 'models/Membre.php';

class MembreController {
    private Membre $membreModel;

    public function __construct(PDO $pdo) {
        $this->membreModel = new Membre($pdo);
    }

    public function inscription(): void {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère les données du formulaire
            $pseudo    = trim($_POST['pseudo'] ?? '');
            $nom       = trim($_POST['nom'] ?? '');
            $prenom    = trim($_POST['prenom'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $mdp       = trim($_POST['mdp'] ?? '');
            $civilite  = trim($_POST['civilite'] ?? '');

            // Validations (RegEx)
            if (empty($pseudo)) {
                $erreurs[] = "Le pseudo est obligatoire.";
            }
            if (empty($nom)) {
                $erreurs[] = "Le nom est obligatoire.";
            }
            if (empty($prenom)) {
                $erreurs[] = "Le prénom est obligatoire.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = "L'email n'est pas valide.";
            }
            if (strlen($mdp) < 6) {
                $erreurs[] = "Le mot de passe doit faire au moins 6 caractères.";
            }

            // Si pas d'erreurs on crée le membre
            if (empty($erreurs)) {
                $succes = $this->membreModel->create($pseudo, $nom, $prenom, $email, $telephone, $mdp, $civilite);

                if ($succes) {
                    // Redirection vers la page de connexion
                    header('Location: /petites-annonces/?page=connexion');
                    exit;
                } else {
                    $erreurs[] = "Une erreur est survenue, veuillez réessayer.";
                }
            }
        }

        require_once 'views/membre/inscription.php';
    }

    public function connexion(): void {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = trim($_POST['pseudo'] ?? '');
            $mdp    = trim($_POST['mdp'] ?? '');

            $membre = $this->membreModel->findByPseudo($pseudo);

            if ($membre === null || !password_verify($mdp, $membre['mdp'])) {
                $erreurs[] = "Pseudo ou mot de passe incorrect.";
            } else {
                // Connexion réussie — on crée la session
                session_start();
                $_SESSION['membre_id'] = $membre['id_membre'];
                $_SESSION['pseudo']    = $membre['pseudo'];
                $_SESSION['statut']    = $membre['statut'];

                header('Location: /petites-annonces/');
                exit;
            }
        }

        require_once 'views/membre/connexion.php';
    }

    public function deconnexion(): void {
        session_start();
        session_destroy();
        header('Location: /petites-annonces/');
        exit;
    }

    public function profil(): void {
        // Protection : si pas connecté, on redirige vers la connexion
        if (!isset($_SESSION['membre_id'])) {
            header('Location: /petites-annonces/?page=connexion');
            exit;
        }

        $membre = $this->membreModel->findById($_SESSION['membre_id']);

        require_once 'views/membre/profil.php';
    }
}