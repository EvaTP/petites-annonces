
<?php

class Membre {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Trouver un membre par son pseudo
    public function findByPseudo(string $pseudo): ?array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM membre WHERE pseudo = :pseudo
        ");
        $stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt->execute();

        $membre = $stmt->fetch(PDO::FETCH_ASSOC);
        return $membre ?: null;
    }

    // Trouver un membre par son id
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM membre WHERE id_membre = :id
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $membre = $stmt->fetch(PDO::FETCH_ASSOC);
        return $membre ?: null;
    }

    // Créer un nouveau membre
    public function create(string $pseudo, string $nom, string $prenom, string $email, string $telephone, string $mdp, string $civilite): bool {
        $mdpHashe = password_hash($mdp, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("
            INSERT INTO membre (pseudo, nom, prenom, email, telephone, mdp, civilite, statut)
            VALUES (:pseudo, :nom, :prenom, :email, :telephone, :mdp, :civilite, 'membre')
        ");

        $stmt->bindValue(':pseudo',     $pseudo,     PDO::PARAM_STR);
        $stmt->bindValue(':nom',        $nom,        PDO::PARAM_STR);
        $stmt->bindValue(':prenom',     $prenom,     PDO::PARAM_STR);
        $stmt->bindValue(':email',      $email,      PDO::PARAM_STR);
        $stmt->bindValue(':telephone',  $telephone,  PDO::PARAM_STR);
        $stmt->bindValue(':mdp',        $mdpHashe,   PDO::PARAM_STR);
        $stmt->bindValue(':civilite',   $civilite,   PDO::PARAM_STR);

        return $stmt->execute();
    }
}