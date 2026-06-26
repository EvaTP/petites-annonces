<?php

class Annonce {
    private PDO $pdo;

    // Le constructeur reçoit la connexion PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupère toutes les annonces. On joint les tables membre et categorie pour avoir les infos nécessaires
    public function findAll(): array {
        $stmt = $this->pdo->query("
            SELECT a.*, m.pseudo, c.titre AS categorie
            FROM annonce a
            JOIN membre m ON a.membre_id = m.id_membre
            JOIN categorie c ON a.categorie_id = c.id_categorie
            ORDER BY a.date_enregistrement DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupére une annonce par son ID
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT a.*, m.pseudo, m.telephone,c.titre AS categorie
            FROM annonce a
            JOIN membre m ON a.membre_id = m.id_membre
            JOIN categorie c ON a.categorie_id = c.id_categorie
            WHERE a.id_annonce = :id
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

        return $annonce ?: null;
    }

    // Récupère toutes les annonces d'un membre précis
    public function findByMembreId(int $membreId): array {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.titre AS categorie
            FROM annonce a
            JOIN categorie c ON a.categorie_id = c.id_categorie
            WHERE a.membre_id = :membreId
            ORDER BY a.date_enregistrement DESC
        ");
        $stmt->bindValue(':membreId', $membreId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crée une nouvelle annonce
    public function create(
        string $titre,
        string $descriptionCourte,
        string $descriptionLongue,
        float $prix,
        string $photo,
        string $pays,
        string $ville,
        string $adresse,
        int $cp,
        int $membreId,
        int $categorieId
    ): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO annonce (
                titre, description_courte, description_longue, prix, photo,
                pays, ville, adresse, cp, membre_id, categorie_id
            ) VALUES (
                :titre, :descriptionCourte, :descriptionLongue, :prix, :photo,
                :pays, :ville, :adresse, :cp, :membreId, :categorieId
            )
        ");

        $stmt->bindValue(':titre',              $titre,              PDO::PARAM_STR);
        $stmt->bindValue(':descriptionCourte',  $descriptionCourte,  PDO::PARAM_STR);
        $stmt->bindValue(':descriptionLongue',  $descriptionLongue,  PDO::PARAM_STR);
        $stmt->bindValue(':prix',               $prix,               PDO::PARAM_STR);
        $stmt->bindValue(':photo',              $photo,              PDO::PARAM_STR);
        $stmt->bindValue(':pays',               $pays,               PDO::PARAM_STR);
        $stmt->bindValue(':ville',              $ville,              PDO::PARAM_STR);
        $stmt->bindValue(':adresse',            $adresse,            PDO::PARAM_STR);
        $stmt->bindValue(':cp',                 $cp,                 PDO::PARAM_INT);
        $stmt->bindValue(':membreId',           $membreId,           PDO::PARAM_INT);
        $stmt->bindValue(':categorieId',        $categorieId,        PDO::PARAM_INT);

        return $stmt->execute();
    }
}